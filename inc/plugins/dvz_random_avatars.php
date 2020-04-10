<?php
/* by Tomasz 'Devilshakerz' Mlynski [devilshakerz.com]; Copyright (C) 2015
 released under Creative Commons BY-NC-SA 4.0 license: http://creativecommons.org/licenses/by-nc-sa/4.0/ */

$plugins->add_hook('usercp_do_avatar_end', ['dvz_ra', 'update_avatar']);
$plugins->add_hook('datahandler_user_insert', ['dvz_ra', 'user_insert']);
$plugins->add_hook('admin_user_users_edit_commit', ['dvz_ra', 'update_avatar_admin']);
$plugins->add_hook('admin_config_plugins_begin', ['dvz_ra', 'plugins_admin']);

function dvz_random_avatars_info ()
{
    return [
        'name'           => 'DVZ Random Avatars',
        'description'    => 'Assigns a Gravatar\'s randomly-generated abstract as an avatar on signup.' . dvz_ra::description_appendix(),
        'website'        => 'http://devilshakerz.com/',
        'author'         => 'Tomasz \'Devilshakerz\' Mlynski',
        'authorsite'     => 'http://devilshakerz.com/',
        'version'        => '1.1',
        'codename'       => 'dvz_random_avatars',
        'compatibility'  => '18*',
    ];
}

function dvz_random_avatars_install ()
{
    global $db, $cache;

    // settings
    $settingGroupId = $db->insert_query('settinggroups', [
        'name'        => 'dvz_random_avatars',
        'title'       => 'DVZ Random Avatars',
        'description' => 'Settings for DVZ Random Avatars.',
    ]);

    $settings = [
        [
            'name'        => 'dvz_ra_scheme',
            'title'       => 'Gravatar scheme',
            'description' => 'More information & sample images: <a href="https://en.gravatar.com/site/implement/images/">https://en.gravatar.com/site/implement/images/</a>',
            'optionscode' => 'select
identicon=identicon (geometric patterns)
monsterid=monsterid (cartoon monsters)
wavatar=wavatar (cartoon faces)
retro=retro (pixelated faces)',
            'value'       => 'identicon',
        ],
        [
            'name'        => 'dvz_ra_default',
            'title'       => 'Default to Random Avatars',
            'description' => 'Set a random avatar after the previous one is removed.',
            'optionscode' => 'yesno',
            'value'       => '1',
        ],
    ];

    $i = 1;

    foreach ($settings as &$row) {
        $row['gid']         = $settingGroupId;
        $row['title']       = $db->escape_string($row['title']);
        $row['description'] = $db->escape_string($row['description']);
        $row['disporder']   = $i++;
    }

    $db->insert_query_multiple('settings', $settings);

    rebuild_settings();
}

function dvz_random_avatars_uninstall ()
{
    global $db;

    $settingGroupId = $db->fetch_field(
        $db->simple_select('settinggroups', 'gid', "name='dvz_random_avatars'"),
        'gid'
    );

    // delete settings
    $db->delete_query('settinggroups', "gid=" . $settingGroupId);
    $db->delete_query('settings', 'gid=' . $settingGroupId);
}

function dvz_random_avatars_is_installed ()
{
    global $db;
    $query = $db->simple_select('settinggroups', 'gid', "name='dvz_random_avatars'");
    return (bool)$db->num_rows($query);
}

class dvz_ra
{

    static $displayOptions = false;

    // hooks
    function user_insert (UserDataHandler $UserDataHandler)
    {
        $UserDataHandler->user_insert_data = array_merge($UserDataHandler->user_insert_data, self::generate_avatar());
    }

    function update_avatar ()
    {
        global $mybb, $db;

        if ($mybb->settings['dvz_ra_default']) {

            if (!empty($mybb->input['remove'])) {
                $db->update_query('users', self::generate_avatar(), 'uid=' . $mybb->user['uid']);
            }

        }
    }

    function update_avatar_admin ()
    {
        global $mybb, $db, $user;

        if ($mybb->settings['dvz_ra_default']) {

            if ($mybb->input['remove_avatar']) {
                $db->update_query('users', self::generate_avatar(), 'uid=' . $user['uid']);
            }

        }
    }

    function plugins_admin ()
    {
        global $mybb;

        self::$displayOptions = true;

        if (isset($mybb->settings['dvz_ra_scheme'])) {

            if ($mybb->get_input('dvz_ra_remove_all') && verify_post_check($mybb->get_input('my_post_key'))) {
                self::remove_all();
                flash_message('Random Avatars have been removed.', 'success');
                admin_redirect("index.php?module=config-plugins");
            }

            if ($mybb->get_input('dvz_ra_assign_all') && verify_post_check($mybb->get_input('my_post_key'))) {
                self::assign_all();
                flash_message('Random Avatars have been assigned to users with no avatar.', 'success');
                admin_redirect("index.php?module=config-plugins");
            }

        }
    }

    // core
    function generate_avatar ()
    {
        global $mybb;

        $hash = md5(random_str(32));
        $size = (int)explode('|', $mybb->settings['useravatardims'])[0];
        $scheme = $mybb->settings['dvz_ra_scheme'];

        return [
            'avatar'           => 'https://secure.gravatar.com/avatar/' . $hash . '?s=' . $size . '&d=' . $scheme . '&f=y',
            'avatartype'       => 'gravatar',
            'avatardimensions' => $size . '|' . $size,
        ];
    }

    function assign_all ()
    {
        global $db;

        $users = $db->simple_select('users', 'uid,avatar', "avatar=''");

        while ($user = $db->fetch_array($users)) {

            $db->update_query('users', self::generate_avatar(), 'uid=' . $user['uid']);

        }
    }

    function remove_all ()
    {
        global $db;

        $users = $db->update_query(
            'users',
            [
                'avatar'           => '',
                'avatartype'       => '',
                'avatardimensions' => '',
            ],
            "avatar LIKE 'https://secure.gravatar.com/avatar/%&f=y'"
        );
    }

    function description_appendix ()
    {
        global $mybb;

        $content = null;

        if (self::$displayOptions) {

            $content .= '<br />';
            $content .= '<br />&bull; <a href="index.php?module=config-plugins&amp;dvz_ra_assign_all=1&amp;my_post_key=' . $mybb->post_code . '"><strong>Assign avatars to users with no avatar</strong></a>';
            $content .= '<br />&bull; <a href="index.php?module=config-plugins&amp;dvz_ra_remove_all=1&amp;my_post_key=' . $mybb->post_code . '"><strong>Remove Random Avatars</strong></a>';
            $content .= '<br />';

        }

        return $content;
    }

}
