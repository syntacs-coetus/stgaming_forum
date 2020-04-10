<?php
class SidebarItem extends DefaultSidebarItem
{
	private $_title;
	private $_contents;

	function __construct($title="")
	{
		$this->_title = $title;
	}

	function add_menu_items($items, $active)
	{
		global $run_module;

		$this->_contents = "<ul class=\"section-menu__links\">";
		foreach($items as $item)
		{
			if(!check_admin_permissions(array("module" => $run_module, "action" => $item['id']), false))
			{
				continue;
			}

			$class = "";
			if($item['id'] == $active)
			{
				$class = " section-menu__item--active";
			}
			$item['link'] = htmlspecialchars_uni($item['link']);
			$this->_contents .= "<li class=\"section-menu__item section-menu__item--{$item['id']} {$class}\"><a href=\"{$item['link']}\" class=\"section-menu__link\">{$item['title']}</a></li>\n";
		}
		$this->_contents .= "</ul>";
	}

	function set_contents($html)
	{
		$this->_contents = $html;
	}

	function get_markup()
	{
		$markup = "<nav class=\"section-menu\">\n";
		$markup .= "<h3 class=\"section-menu__title\">{$this->_title}</h3>\n";
		if($this->_contents)
		{
			$markup .= $this->_contents;
		}
		$markup .= "</nav>\n";
		return $markup;
	}
}

?>