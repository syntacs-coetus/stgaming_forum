<?php
/**
 * This is an example style file for Admin CP styles.
 *
 * It allows you to override our existing layout generation
 * classes with your own to further customise the Admin CP
 * layout beyond CSS.
 *
 * Your class name      Should extend
 * ---------------      -------------
 * Page                 DefaultPage
 * SidebarItem          DefaultSidebarItem
 * PopupMenu            DefaultPopupMenu
 * Table                DefaultTable
 * Form                 DefaultForm
 * FormContainer        DefaultFormContainer
 *
 * For example, to output your own custom header:
 *
 * class Page extends DefaultPage
 * {
 *   function output_header($title)
 *   {
 *      echo "<h1>{$title}</h1>";
 *   }
 * }
 *
 */

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

require_once 'class/class-page.php';

require_once 'class/class-sidebar.php';

require_once 'class/class-popup.php';

require_once 'class/class-table.php';

require_once 'class/class-form.php';

require_once 'class/class-formContainer.php';
