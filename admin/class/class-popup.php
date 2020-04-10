<?php
class PopupMenu extends DefaultPopupMenu
{
	 private $_title;
	 private $_id;
	 private $_items;
 
	 function __construct($id, $title='')
	 {
		 $this->_id = $id;
		 $this->_title = $title;
	 }
 
	 function add_item($text, $link, $onclick='')
	 {
		 if($onclick)
		 {
			 $onclick = " onclick=\"{$onclick}\"";
		 }
		 $this->_items .= "<div class=\"popup_item_container\"><a href=\"{$link}\"{$onclick} class=\"popup_item\">{$text}</a></div>\n";
	 }
 
	 function fetch()
	 {
		 $popup = '<div class="popup__container">';
		 if($this->_title)
		 {
			 $popup .= "<a href=\"javascript:;\" id=\"{$this->_id}\" class=\"popup_button\">{$this->_title}</a>\n";
		 }
		 $popup .= "<div class=\"popup_menu\" id=\"{$this->_id}_popup\">\n{$this->_items}</div>\n";
		 $popup .= "<script type=\"text/javascript\">\n";
		 $popup .= "$(\"#{$this->_id}\").popupMenu();\n";
		 $popup .= "</script>\n";
		 $popup .= "</div>\n";
		 return $popup;
	 }
 
	 function output()
	 {
		 echo $this->fetch();
	 }
}
?>