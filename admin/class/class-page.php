<?php 

class Page extends DefaultPage
{
    public $tab_control;

function output_header($title="")
{
    global $mybb, $admin_session, $lang, $plugins;

    $args = array(
        'this' => &$this,
        'title' => &$title,
    );

    $plugins->run_hooks("admin_page_output_header", $args);

    if(!$title)
    {
        $title = $lang->mybb_admin_panel;
    }

    $rtl = "";
    if($lang->settings['rtl'] == 1)
    {
        $rtl = " dir=\"rtl\"";
    }

    echo "<!DOCTYPE html>";
    echo "<html {$rtl}>\n";
    echo "<head>\n";
    echo "	<title>".$title."</title>\n";
    echo "	<meta name=\"author\" content=\"MyBB Group\" />\n";
    echo "	<meta name=\"copyright\" content=\"Copyright ".COPY_YEAR." MyBB Group.\" />\n";
    echo "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
    echo "  <link href=\"https://fonts.googleapis.com/css?family=Asap:400,600,600i|Open+Sans:300,400,700\" rel=\"stylesheet\">";
    echo "  <link rel=\"stylesheet\" href=\"https://use.fontawesome.com/releases/v5.1.0/css/all.css\" integrity=\"sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt\" crossorigin=\"anonymous\">";
    echo "	<link rel=\"stylesheet\" href=\"styles/".$this->style."/main.css?ver=1821\" type=\"text/css\" />\n";
    echo "	<link rel=\"stylesheet\" href=\"styles/".$this->style."/modal.css?ver=1821\" type=\"text/css\" />\n";

    // Load stylesheet for this module if it has one
    if(file_exists(MYBB_ADMIN_DIR."styles/{$this->style}/{$this->active_module}.css"))
    {
        echo "	<link rel=\"stylesheet\" href=\"styles/{$this->style}/{$this->active_module}.css\" type=\"text/css\" />\n";
    }

    echo "	<script type=\"text/javascript\" src=\"../jscripts/jquery.js?ver=1821\"></script>\n";
    echo "	<script type=\"text/javascript\" src=\"../jscripts/jquery.plugins.min.js?ver=1821\"></script>\n";
    echo "	<script type=\"text/javascript\" src=\"../jscripts/general.js?ver=1821\"></script>\n";
    echo "	<script type=\"text/javascript\" src=\"./jscripts/admincp.js?ver=1821\"></script>\n";
    echo "	<script type=\"text/javascript\" src=\"./jscripts/tabs.js\"></script>\n";
    echo "	<script type=\"text/javascript\" src=\"styles/{$this->style}/js/global.js\"></script>\n";

    echo "	<link rel=\"stylesheet\" href=\"jscripts/jqueryui/css/redmond/jquery-ui.min.css\" />\n";
    echo "	<link rel=\"stylesheet\" href=\"jscripts/jqueryui/css/redmond/jquery-ui.structure.min.css\" />\n";
    echo "	<link rel=\"stylesheet\" href=\"jscripts/jqueryui/css/redmond/jquery-ui.theme.min.css\" />\n";
    echo "	<script src=\"jscripts/jqueryui/js/jquery-ui.min.js?ver=1821\"></script>\n";
    
    // Stop JS elements showing while page is loading (JS supported browsers only)
    echo "  <style type=\"text/css\">.popup_button { display: none; } </style>\n";
    echo "  <script type=\"text/javascript\">\n".
            "//<![CDATA[\n".
            "	document.write('<style type=\"text/css\">.popup_button { display: inline; } .popup_menu { display: none; }<\/style>');\n".
            "//]]>\n".
            "</script>\n";

    echo "	<script type=\"text/javascript\">
//<![CDATA[
var loading_text = '{$lang->loading_text}';
var cookieDomain = '{$mybb->settings['cookiedomain']}';
var cookiePath = '{$mybb->settings['cookiepath']}';
var cookiePrefix = '{$mybb->settings['cookieprefix']}';
var cookieSecureFlag = '{$mybb->settings['cookiesecureflag']}';
var imagepath = '../images';

lang.unknown_error = \"{$lang->unknown_error}\";
lang.saved = \"{$lang->saved}\";
//]]>
</script>\n";
    echo $this->extra_header;
    $username = htmlspecialchars_uni($mybb->user['username']);
print <<<EOF
</head>
<body class="module--{$this->active_module}">
    <nav class="nav-bar">
        <div class="wrapper wrapper--nav-bar">
            <a href="./index.php" class="page__logo--link" title="{$lang->home}">
                <img src="styles/{$this->style}/images/logo.svg" alt="logo" class="page__logo" />
            </a>
            <input type="checkbox" id="toggle-menu" />
            <label class="nav-button" for="toggle-menu">
                
                <div class="icon nav-button__icon">
                    
                </div>
                <div class="nav-button__text">
                    Menu
                </div>
            </label>
            <div class="nav-container">
                {$this->_build_menu()}	
                <nav class="user-menu"> 
                    <ul class="user-menu__links"> 
                        <li class="user-menu__item">
                                <a href="index.php?module=user-users&amp;action=edit&amp;uid={$mybb->user['uid']}" class="user-menu__link">
                                    <i class="fas fa-user"></i>
                                    <span class="main-menu__text">{$username}</span>
                                </a>
                        </li>
                        <li class="user-menu__item">
                                <a href="{$mybb->settings['bburl']}" target="_blank" class="user-menu__link">
                                    <i class="fas fa-globe-americas"></i>
                                    <span class="main-menu__text">{$lang->view_board}</span>
                                </a>
                        </li>
                        <li class="user-menu__item">
                                <a href="index.php?action=logout&amp;my_post_key={$mybb->post_code}" class="user-menu__link">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span class="main-menu__text">{$lang->logout}</span>
                                </a>
                        </li>
                    </ul> 
                </nav> 
            </div>
        </div>
    </nav>
    <header id="top" class="header header--{$this->active_module}"> 
        <div class="wrapper wrapper--header"> 
            {$this->_generate_breadcrumb()}            
        </div> 
    </header> 	
    
    <section class="main">
        <div class="wrapper wrapper--main">
        
EOF;
    function output_alert($message, $id="")
    {		
        echo "<section class=\"alert alert--{$id}\">\n";
        echo "<i class=\"fas alert__icon  fa-info-circle\"></i>";
        echo "<div class=\"alert__message\">{$message}</div>\n";
        echo "</section>\n";
    }

    function output_inline_message($message)
    {
        echo "<section class=\"alert alert--inline_message\">\n";
        echo "<i class=\"fas alert__icon  fa-info-circle\"></i>";
        echo "<div class=\"alert__message\">{$message}</div>\n";
        echo "</section>\n";
    }

    function output_error($error)
    {
        echo "<section class=\"alert alert--error\">\n";
        echo "<i class=\"fas alert__icon  fa-exclamation-triangle\"></i>";
        echo "<div class=\"alert__message\">{$error}</div>\n";
        echo "</section>\n";
    }

    function output_inline_error($errors)
    {
        global $lang;

        if(!is_array($errors))
        {
            $errors = array($errors);
        }
        echo "<section class=\"alert alert--error\">\n";
        echo "<i class=\"fas alert__icon  fa-info-circle\"></i>";
        echo "<p><em>{$lang->encountered_errors}</em></p>\n";
        echo "<ul>\n";
        foreach($errors as $error)
        {
            echo "<li>{$error}</li>\n";
        }
        echo "</ul>\n";
        echo "</section>\n";
    }

    if(isset($admin_session['data']['flash_message']) && $admin_session['data']['flash_message'])
    {
        $message = $admin_session['data']['flash_message']['message'];
        $type = $admin_session['data']['flash_message']['type'];
        echo "<section class=\"alert alert--{$type}\">\n";
        echo "<i class=\"fas alert__icon  fa-info-circle\"></i>";
        echo "<div class=\"alert__message\">{$message}</div>\n";
        echo "</section>\n";
        update_admin_session('flash_message', '');
    }

    if(!empty($this->extra_messages) && is_array($this->extra_messages))
    {
        foreach($this->extra_messages as $message)
        {
            switch($message['type'])
            {
                case 'success':
                case 'error':
                    echo "<section class=\"alert alert--{$message['type']}\">\n";
                    echo "<i class=\"fas alert__icon  fa-info-circle\"></i>";
                    echo "{$message['message']}\n";
                    echo "</section>\n";
                    break;
                default:
                    $this->output_error($message['message']);
                    break;
            }
        }
    }

    if($this->show_post_verify_error == true)
    {
        $this->output_error($lang->invalid_post_verify_key);
    }

print <<<EOF

            <aside>
            {$this->submenu}
            {$this->sidebar}
            </aside>
            <main class="page-content">	
EOF;
 
}   
    
function output_nav_tabs($tabs=array(), $active='')
{
    global $plugins;
    $tabs = $plugins->run_hooks("admin_page_output_nav_tabs_start", $tabs);
    echo "<div>";
    echo "\t<ul class=\"page-tabs\">\n";
    foreach($tabs as $id => $tab)
    {
        $class = '';
        if($id == $active) $class = ' page-tabs__item--active';			
        if(isset($tab['align']) == "right") $class .= " align_right";
        
        $target = '';
        if(isset($tab['link_target'])) $target = " target=\"{$tab['link_target']}\"";
        
        $rel = '';
        if(isset($tab['link_rel'])) $rel = " rel=\"{$tab['link_rel']}\"";
        if(!isset($tab['link'])) $tab['link'] = '';
        
        echo "\t\t<li class=\"page-tabs__item{$class}\"><a href=\"{$tab['link']}\" class=\"page-tabs__link\" {$target}{$rel}>{$tab['title']}</a></li>\n";
        $target = '';
    }
    
    if($tabs[$active]['description'])
    {
        echo "\t<li class=\"page-tabs__desc\">{$tabs[$active]['description']}</li>\n";
    }
    echo "\t</ul>\n";
    echo "</div>";
    
    $arguments = array('tabs' => $tabs, 'active' => $active);
    $plugins->run_hooks("admin_page_output_nav_tabs_end", $arguments);
}

function output_tab_control($tabs=array(), $observe_onload=true, $id="tabs")
{
	global $plugins;
	$tabs = $plugins->run_hooks("admin_page_output_tab_control_start", $tabs);
	$this->tab_control = "<ul class=\"tabs page-tabs\" id=\"{$id}\">\n";
	$tab_count = count($tabs);
	$done = 1;
	foreach($tabs as $anchor => $title)
	{
		$class = "";
		if($tab_count == $done)
		{
			$class .= " last";
		}
		if($done == 1)
		{
			$class .= " first";
		}
		++$done;
		$this->tab_control .= "<li class=\"page-tabs__item page-tabs__item--{$class}\"><a href=\"#tab_{$anchor}\" class=\"page-tabs__link\" >{$title}</a></li>\n";
	}
    $this->tab_control .= "</ul>\n";
    echo $this->tab_control;
	$plugins->run_hooks("admin_page_output_tab_control_end", $tabs);
}



function output_footer($quit=true)
{
    global $mybb, $maintimer, $db, $lang, $plugins;

    $args = array(
        'this' => &$this,
        'quit' => &$quit,
    );

    $plugins->run_hooks("admin_page_output_footer", $args);

    $memory_usage = get_friendly_size(get_memory_usage());

    $totaltime = format_time_duration($maintimer->stop());
    $querycount = $db->query_count;

    if(my_strpos(getenv("REQUEST_URI"), "?"))
    {
        $debuglink = htmlspecialchars_uni(getenv("REQUEST_URI")) . "&amp;debug=1#footer";
    }
    else
    {
        $debuglink = htmlspecialchars_uni(getenv("REQUEST_URI")) . "?debug=1#footer";
    }

    $copy_year = COPY_YEAR;
    print <<<EOT
            </main>
        </div>
    </section>
    <footer id="#footer" class="footer">
        <div class="footer--powered">		
            <p class="wrapper"> 
                Powered By <a href=\"https://mybb.com/\" target=\"_blank\" rel=\"noopener\">MyBB</a>, 
                &copy; 2002-{$copy_year} <a href=\"https://mybb.com/\" target=\"_blank\" rel=\"noopener\">MyBB Group</a>.
            </p>
        </div>
        <div class="footer--generation">
            <p class="wrapper"> 
                Design by <a href="https://mybboard.pl/user-35621.html" target=\"_blank\" title="mybboard.pl">myCreedo</a> – 2018-2019 <br />
                {$lang->sprintf($lang->generated_in, $totaltime, $debuglink, $querycount, $memory_usage)} 
            </p>
        </div>


EOT;
    if($mybb->debug_mode) echo "<div class=\"wrapper wrapper--debug\"> {$db->explain} </div>";

    
    echo "</footer>\n";
    echo "</body>\n";
    echo "</html>\n";

    if($quit != false)
    {
        exit;
    }
}

    

function _build_menu()
{
    if(!is_array($this->_menu))
    {
        return false;
    }
    $build_menu = "\n<ul class=\"nav-bar__links\">\n";
    ksort($this->_menu);
    foreach($this->_menu as $items)
    {
        foreach($items as $menu_item)
        {
            $menu_item['link'] = htmlspecialchars_uni($menu_item['link']);
            $menu_item_class = explode(" ", $menu_item['title'] )['0'];
            if($menu_item['id'] == $this->active_module)
            {
                $sub_menu = $menu_item['submenu'];
                $sub_menu_title = $menu_item['title'];					
                $build_menu .= "<li class=\"nav-bar__item nav-bar__item--{$menu_item_class}\"><a href=\"{$menu_item['link']}\" class=\"nav-bar__link nav-bar__link--active-tab\">{$menu_item['title']}</a></li>\n";

            }
            else
            {
                $build_menu .= "<li class=\"nav-bar__item nav-bar__item--{$menu_item_class}\"><a href=\"{$menu_item['link']}\" class=\"nav-bar__link\">{$menu_item['title']}</a></li>\n";
            }
        }
    }
    $build_menu .= "</ul>";

    if($sub_menu)
    {
        $this->_build_submenu($sub_menu_title, $sub_menu);
    }
    return $build_menu;
}

function _generate_breadcrumb()
{
    if(!is_array($this->_breadcrumb_trail))
    {
        return false;
    }
    array_shift($this->_breadcrumb_trail);
    $trail = '';
    foreach($this->_breadcrumb_trail as $key => $crumb)
    {
        if($this->_breadcrumb_trail[$key+1])
        {
            $trail .= "<a href=\"{$crumb['url']}\" class=\"breadcrumb__link\"><span class=\"breadcrumb__text\">{$crumb['name']}</span></a> <i class=\"fas fa-chevron-right breadcrumb__separator\"></i>"; 
        }
        else
        {
            $trail .= "<h1 class=\"title title--page\">{$crumb['name']}</h1>";
        }
    }
    return $trail;
}


}

?>