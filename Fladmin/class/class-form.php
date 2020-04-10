<?php
class Form extends DefaultForm
{
	 private $_return = false;

	 public $construct_return = "";
 
	 function __construct($script='', $method='', $id="", $allow_uploads=false, $name="", $return=false, $onsubmit="")
	 {
		 global $mybb;
		 $form = "<form action=\"{$script}\" method=\"{$method}\"";
		 if($allow_uploads != false)
		 {
			 $form .= " enctype=\"multipart/form-data\"";
		 }
 
		 if($name != "")	 $form .= " name=\"{$name}\""; 
		 if($id != "")		 $form .= " id=\"{$id}\""; 
		 if($onsubmit != "") $form .= " onsubmit=\"{$onsubmit}\"";
		
		 $form .= ">\n";
		 $form .= $this->generate_hidden_field("my_post_key", $mybb->post_code)."\n";

		 if($return == false)
		 {
			 echo $form;
		 }
		 else
		 {
			 $this->_return = true;
			 $this->construct_return = $form;
		 }
	 }

	 function generate_hidden_field($name, $value, $options=array())
	 {
		 $input = "<input type=\"hidden\" name=\"{$name}\" value=\"".htmlspecialchars_uni($value)."\"";
		 if(isset($options['id']))
		 {
			 $input .= " id=\"".$options['id']."\"";
		 }
		 $input .= " />";
		 return $input;
	 }
 
	 function generate_text_box($name, $value="", $options=array())
	 {
		 $input = "<input type=\"text\" name=\"".$name."\" value=\"".htmlspecialchars_uni($value)."\"";

		 if(isset($options['class'])) {
			 $input .= " class=\"textbox ".$options['class']."\"";
		 } else {
			 $input .= " class=\"textbox\"";
		 }

		 if(isset($options['style'])) 	$input .= " style=\"".$options['style']."\"";
		 if(isset($options['id']))		$input .= " id=\"".$options['id']."\"";

		 $input .= " />";
		 return $input;
	 }
 

	 function generate_numeric_field($name, $value=0, $options=array())
	 {
		 if(is_numeric($value))
		 {
			 $value = (float)$value;
		 }
		 else
		 {
			 $value = '';
		 }
 
		 $input = "<input type=\"number\" name=\"{$name}\" value=\"{$value}\"";
		 if(isset($options['min']))		$input .= " min=\"".$options['min']."\"";
		 if(isset($options['max']))		$input .= " max=\"".$options['max']."\"";
		 if(isset($options['step']))	$input .= " step=\"".$options['step']."\"";

		 if(isset($options['class'])) {
			 $input .= " class=\"textbox ".$options['class']."\"";
		 } else {
			 $input .= " class=\"textbox\"";
		 }
		 if(isset($options['style']))	$input .= " style=\"".$options['style']."\"";
		 if(isset($options['id']))		$input .= " id=\"".$options['id']."\"";

		 $input .= " />";
		 return $input;
	 }
 

	 function generate_password_box($name, $value="", $options=array())
	 {
		 $input = "<input type=\"password\" name=\"".$name."\" value=\"".htmlspecialchars_uni($value)."\"";

		 if(isset($options['class'])) {
			 $input .= " class=\"textbox ".$options['class']."\"";
		 } else {
			 $input .= " class=\"textbox\"";
		 }

		 if(isset($options['id']))				$input .= " id=\"".$options['id']."\"";
		 if(isset($options['autocomplete']))	$input .= " autocomplete=\"".$options['autocomplete']."\"";

		 $input .= " />";
		 return $input;
	 }
 
	 function generate_file_upload_box($name, $options=array())
	 {
		 $input = "<input type=\"file\" name=\"".$name."\"";

		 if(isset($options['class']))
		 {
			 $input .= " class=\"textbox ".$options['class']."\"";
		 } else {
			 $input .= " class=\"textbox\"";
		 }

		 if(isset($options['style']))	$input .= " style=\"".$options['style']."\"";
		 if(isset($options['id']))		$input .= " id=\"".$options['id']."\"";

		 $input .= " />";
		 return $input;
 
	 }
 

	 function generate_text_area($name, $value="", $options=array())
	 {
		 $textarea = "<textarea";
		 if(!empty($name))				$textarea .= " name=\"{$name}\"";
		 if(isset($options['class']))	$textarea .= " class=\"{$options['class']}\"";
		 if(isset($options['id']))		$textarea .= " id=\"{$options['id']}\"";
		 if(isset($options['style']))	$textarea .= " style=\"{$options['style']}\"";

		 if(isset($options['disabled']) && $options['disabled'] !== false)	$textarea .= " disabled=\"disabled\"";
		 if(isset($options['readonly']) && $options['readonly'] !== false)	$textarea .= " readonly=\"readonly\"";
		 
		 if(isset($options['maxlength']))	$textarea .= " maxlength=\"{$options['maxlength']}\"";
		 
		 if(!isset($options['rows']))	$options['rows'] = 5;
		 if(!isset($options['cols']))	$options['cols'] = 45;

		 $textarea .= " rows=\"{$options['rows']}\" cols=\"{$options['cols']}\">";
		 $textarea .= htmlspecialchars_uni($value);
		 $textarea .= "</textarea>";
		 return $textarea;
	 }
 
	 function generate_radio_button($name, $value="", $label="", $options=array())
	 {
		 
		 $input = "<label class=\"radio\"";
		 if(isset($options['id']))		$input .= " for=\"{$options['id']}\"";

		 $input .= "><input type=\"radio\" name=\"{$name}\" value=\"".htmlspecialchars_uni($value)."\"";

		 if(isset($options['class']))
		 {
			 $input .= " class=\"radio__box ".$options['class']."\"";
		 } else {
			 $input .= " class=\"radio__box\"";
		 }

		 if(isset($options['id']))		$input .= " id=\"".$options['id']."\"";

		 if(isset($options['checked']) && $options['checked'] != 0)	$input .= " checked=\"checked\"";

		 $input .= " /><span class=\"icon radio__box--icon\"></span>";
		 if($label != "")
		 {
			 $input .= "<span class=\"radio__box--title\"> {$label} </span>";
		 }
		 $input .= "</label>";
		 return $input;
	 }
 
	 function generate_check_box($name, $value="", $label="", $options=array())
	 {
		 $input = "<label";
		 if(isset($options['id']))		$input .= " for=\"{$options['id']}\"";
		 if(isset($options['class']))	$input .= " class=\"label_{$options['class']}\"";

		 $input .= "><input type=\"checkbox\" name=\"{$name}\" value=\"".htmlspecialchars_uni($value)."\"";
		 if(isset($options['class']))
		 {
			 $input .= " class=\"checkbox_input ".$options['class']."\"";
		 } else {
			 $input .= " class=\"checkbox_input\"";
		 }

		 if(isset($options['id']))		$input .= " id=\"".$options['id']."\"";

		 if(isset($options['checked']) && ($options['checked'] === true || $options['checked'] == 1)) $input .= " checked=\"checked\"";

		 if(isset($options['onclick']))	$input .= " onclick=\"{$options['onclick']}\"";

		 $input .= " /><span class=\"icon check__box--icon\"></span> ";
		 if($label != "") $input .= "<span class=\"check__box--title\"> {$label} </span>";
		 $input .= "</label>";
		 return $input;
	 }
 
	 function generate_select_box($name, $option_list=array(), $selected=array(), $options=array())
	 {
		 if(!isset($options['multiple']))
		 {
			 $select = "<div class=\"select-field\"><i class=\"fas fa-sort select-field__icon\"></i><select name=\"{$name}\"";
		 } else {
			 $select = "<div class=\"select-field\"><i class=\"fas fa-sort select-field__icon\"></i><select name=\"{$name}\" multiple=\"multiple\"";
			 if(!isset($options['size']))
			 {
				 $options['size'] = count($option_list);
			 }
		 }

		 if(isset($options['class']))	$select .= " class=\"{$options['class']}\"";
		 if(isset($options['id']))		$select .= " id=\"{$options['id']}\"";
		 if(isset($options['size']))	$select .= " size=\"{$options['size']}\"";

		 $select .= ">\n";
		 foreach($option_list as $value => $option)
		 {
			 $select_add = '';
			 if((!is_array($selected) || !empty($selected)) && ((string)$value == (string)$selected || (is_array($selected) && in_array((string)$value, $selected))))
			 {
				 $select_add = " selected=\"selected\"";
			 }
			 $select .= "<option value=\"{$value}\"{$select_add}>{$option}</option>\n";
		 }
		 $select .= "</select></div>\n";
		 return $select;
	 }
 

	 function generate_forum_select($name, $selected, $options=array(), $is_first=1)
	 {
		 global $fselectcache, $forum_cache, $selectoptions;
 
		 if(!$selectoptions)
		 {
			 $selectoptions = '';
		 }
 
		 if(!isset($options['depth']))
		 {
			 $options['depth'] = 0;
		 }
 
		 $options['depth'] = (int)$options['depth'];
 
		 if(!isset($options['pid']))
		 {
			 $options['pid'] = 0;
		 }
 
		 $pid = (int)$options['pid'];
 
		 if(!is_array($fselectcache))
		 {
			 if(!is_array($forum_cache))
			 {
				 $forum_cache = cache_forums();
			 }
 
			 foreach($forum_cache as $fid => $forum)
			 {
				 $fselectcache[$forum['pid']][$forum['disporder']][$forum['fid']] = $forum;
			 }
		 }
 
		 if($options['main_option'] && $is_first)
		 {
			 $select_add = '';
			 if($selected == -1)
			 {
				 $select_add = " selected=\"selected\"";
			 }
 
			 $selectoptions .= "<option value=\"-1\"{$select_add}>{$options['main_option']}</option>\n";
		 }
 
		 if(isset($fselectcache[$pid]))
		 {
			 foreach($fselectcache[$pid] as $main)
			 {
				 foreach($main as $forum)
				 {
					 if($forum['fid'] != "0" && $forum['linkto'] == '')
					 {
						 $select_add = '';
 
						 if(!empty($selected) && ($forum['fid'] == $selected || (is_array($selected) && in_array($forum['fid'], $selected))))
						 {
							 $select_add = " selected=\"selected\"";
						 }
 
						 $sep = '';
						 if(isset($options['depth']))
						 {
							 $sep = str_repeat("&nbsp;", $options['depth']);
						 }
 
						 $style = "";
						 if($forum['active'] == 0)
						 {
							 $style = " style=\"font-style: italic;\"";
						 }
 
						 $selectoptions .= "<option value=\"{$forum['fid']}\"{$style}{$select_add}>".$sep.htmlspecialchars_uni(strip_tags($forum['name']))."</option>\n";
 
						 if($forum_cache[$forum['fid']])
						 {
							 $options['depth'] += 5;
							 $options['pid'] = $forum['fid'];
							 $this->generate_forum_select($forum['fid'], $selected, $options, 0);
							 $options['depth'] -= 5;
						 }
					 }
				 }
			 }
		 }
 
		 if($is_first == 1)
		 {
			 if(!isset($options['multiple']))
			 {
				 $select = "<select name=\"{$name}\"";
			 }
			 else
			 {
				 $select = "<select name=\"{$name}\" multiple=\"multiple\"";
			 }
			 if(isset($options['class']))
			 {
				 $select .= " class=\"{$options['class']}\"";
			 }
			 if(isset($options['id']))
			 {
				 $select .= " id=\"{$options['id']}\"";
			 }
			 if(isset($options['size']))
			 {
				 $select .= " size=\"{$options['size']}\"";
			 }
			 $select .= ">\n".$selectoptions."</select>\n";
			 $selectoptions = '';
			 return $select;
		 }
	 }
 
	 function generate_group_select($name, $selected=array(), $options=array())
	 {
		 global $cache;
 
		 $select = "<div class=\"select-field\"><i class=\"fas fa-sort select-field__icon\"></i><select name=\"{$name}\"";
 
		 if(isset($options['multiple']))	$select .= " multiple=\"multiple\""; 
		 if(isset($options['class']))		$select .= " class=\"{$options['class']}\"";
		 if(isset($options['id']))			$select .= " id=\"{$options['id']}\""; 
		 if(isset($options['size']))		$select .= " size=\"{$options['size']}\"";

		 $select .= ">\n";
 
		 $groups_cache = $cache->read('usergroups');
		 
		 if(!is_array($selected))			$selected = array($selected);

			 
		 foreach($groups_cache as $group)
		 {
			 $selected_add = "";
			 
			 if(in_array($group['gid'], $selected))	$selected_add = " selected=\"selected\"";

			 $select .= "<option value=\"{$group['gid']}\"{$selected_add}>".htmlspecialchars_uni($group['title'])."</option>";
		 }
 
		 $select .= "</select></div>";
 
		 return $select;
	 }
 
	 function generate_submit_button($value, $options=array())
	 {
		 $input = "<button type=\"submit\"";
 
		 if(isset($options['class']))
		 {
			 $input .= " class=\"button ".$options['class']."\"";
		 }
		 else
		 {
			 $input .= " class=\"button\"";
		 }
		 if(isset($options['id']))
		 {
			 $input .= " id=\"".$options['id']."\"";
		 }
		 if(isset($options['name']))
		 {
			 $input .= " name=\"".$options['name']."\"";
		 }
		 if(isset($options['disabled']))
		 {
			 $input .= " disabled=\"disabled\"";
		 }
		 if(isset($options['onclick']))
		 {
			 $input .= " onclick=\"".str_replace('"', '\"', $options['onclick'])."\"";
		 }
		 $input .= " value=\"".htmlspecialchars_uni($value)."\"><i class=\"fas fa-check-double button__icon\"></i><span class=\"button__text\">".htmlspecialchars_uni($value)."</span></button>";
		 return $input;
	 }
 
	 function generate_reset_button($value, $options=array())
	 {
		 $input = "<button type=\"reset\"";
 
		 if(isset($options['class']))
		 {
			 $input .= " class=\"button ".$options['class']."\"";
		 }
		 else
		 {
			 $input .= " class=\"button\"";
		 }
		 if(isset($options['id']))
		 {
			 $input .= " id=\"".$options['id']."\"";
		 }
		 if(isset($options['name']))
		 {
			 $input .= " name=\"".$options['name']."\"";
		 }
		 $input .= " value=\"".htmlspecialchars_uni($value)."\"><i class=\"fas fa-trash-alt button__icon\"></i><span class=\"button__text\">".htmlspecialchars_uni($value)."</span></button>";
		 return $input;
	 }
 

	 function generate_yes_no_radio($name, $value="1", $int=true, $yes_options=array(), $no_options = array())
	 {
		 global $lang;
 
		 // Checked status
		 if($value == "no" || $value === '0')
		 {
			 $no_checked = 1;
			 $yes_checked = 0;
		 }
		 else
		 {
			 $yes_checked = 1;
			 $no_checked = 0;
		 }
		 // Element value
		 if($int == true)
		 {
			 $yes_value = 1;
			 $no_value = 0;
		 }
		 else
		 {
			 $yes_value = "yes";
			 $no_value = "no";
		 }
 
		 if(!isset($yes_options['class']))
		 {
			 $yes_options['class'] = '';
		 }
 
		 if(!isset($no_options['class']))
		 {
			 $no_options['class'] = '';
		 }
 
		 // Set the options straight
		 $yes_options['class'] = "radio_yes ".$yes_options['class'];
		 $yes_options['checked'] = $yes_checked;
		 $no_options['class'] = "radio_no ".$no_options['class'];
		 $no_options['checked'] = $no_checked;
		 
		 if(isset($yes_options['id'])) { $yes_id = $yes_options['id'];} else { $yes_id = $name."-on";}
		 if(isset($no_options['id'])) { $no_id = $no_options['id'];} else { $no_id = $name."-off";}

		 $yes = "<span class=\"segmented-control__option\"> ";
		 $yes .= "<input type=\"radio\" value=\"".htmlspecialchars_uni($yes_value)."\" class=\"radiobox segmented-control__input\"  name=\"$name\" id=\"{$yes_id}\" ";
		 if(isset($yes_options['checked']) && $yes_options['checked'] != 0)	$yes .= " checked=\"checked\"";		 
		 $yes .= "/><label class=\"segmented-control__button segmented-control__button--yes\" for=\"$yes_id\"> $lang->yes </label></span>";

		 $no = "<span class=\"segmented-control__option\"> ";
		 $no .= "<input type=\"radio\" value=\"".htmlspecialchars_uni($no_value)."\" class=\"radiobox segmented-control__input\"  name=\"$name\" id=\"{$no_id}\" ";
		 if(isset($no_options['checked']) && $no_options['checked'] != 0)	$no .= " checked=\"checked\"";		 
		 $no .= "/><label class=\"segmented-control__button segmented-control__button--no\" for=\"$no_id\"> $lang->no </label></span>";
		 
		 

		 $segment = "<div class=\"segmented-control\">{$yes}{$no}</div>";
		 return $segment;
	 }
 
	 function generate_on_off_radio($name, $value=1, $int=true, $on_options=array(), $off_options = array())
	 {
		 global $lang;
 
		 // Checked status
		 if($value == "off" || (int) $value !== 1)
		 {
			 $off_checked = 1;
			 $on_checked = 0;
		 }
		 else
		 {
			 $on_checked = 1;
			 $off_checked = 0;
		 }
		 // Element value
		 if($int == true)
		 {
			 $on_value = 1;
			 $off_value = 0;
		 }
		 else
		 {
			 $on_value = "on";
			 $off_value = "off";
		 }
 
		 // Set the options straight
		 if(!isset($on_options['class']))
		 {
			 $on_options['class'] = '';
		 }
 
		 if(!isset($off_options['class']))
		 {
			 $off_options['class'] = '';
		 }
 
		 $on_options['class'] = "radio_on ".$on_options['class'];
		 $on_options['checked'] = $on_checked;
		 $off_options['class'] = "radio_off ".$off_options['class'];
		 $off_options['checked'] = $off_checked;

		 if(isset($on_options['id'])) { $on_id = $on_options['id'];} else { $on_id = $name."-on";}
		 if(isset($off_options['id'])) { $off_id = $off_options['id'];} else { $off_id = $name."-off";}
 
		 $on = "<span class=\"segmented-control__option\"> ";
		 $on .= "<input type=\"radio\" value=\"".htmlspecialchars_uni($on_value)."\" class=\"radiobox segmented-control__input\"  name=\"$name\" id=\"$on_id\" ";		 
		 if(isset($on_options['checked']) && $on_options['checked'] != 0)	$on .= " checked=\"checked\"";		 
		 $on .= "/><label class=\"segmented-control__button segmented-control__button--yes\" for=\"{$on_id}\"> $lang->on </label></span>";

		 $off = "<span class=\"segmented-control__option\"> ";
		 $off .= "<input type=\"radio\" value=\"".htmlspecialchars_uni($off_value)."\" class=\"radiobox segmented-control__input\"  name=\"$name\" id=\"$off_id\" ";
		 if(isset($off_options['checked']) && $off_options['checked'] != 0)	$off .= " checked=\"checked\"";		 
		 $off .= "/><label class=\"segmented-control__button segmented-control__button--no\" for=\"{$off_id}\"> $lang->off </label></span>";

		 $segment = "<div class=\"segmented-control\">{$on}{$off}</div>";
		 return $segment;
	 }

	 function generate_date_select($name, $day=0,$month=0,$year=0)
	 {
		 global $lang;
 
		 $months = array(
			 1 => $lang->january,
			 2 => $lang->february,
			 3 => $lang->march,
			 4 => $lang->april,
			 5 => $lang->may,
			 6 => $lang->june,
			 7 => $lang->july,
			 8 => $lang->august,
			 9 => $lang->september,
			 10 => $lang->october,
			 11 => $lang->november,
			 12 => $lang->december,
		 );
 
		 // Construct option list for days
		 $days = array();
		 for($i = 1; $i <= 31; ++$i)
		 {
			 $days[$i] = $i;
		 }
 
		 if(!$day)
		 {
			 $day = date("j", TIME_NOW);
		 }
 
		 if(!$month)
		 {
			 $month = date("n", TIME_NOW);
		 }
 
		 if(!$year)
		 {
			 $year = date("Y", TIME_NOW);
		 }
 
		 $built = $this->generate_select_box($name.'_day', $days, (int)$day, array('id' => $name.'_day'))." &nbsp; ";
		 $built .= $this->generate_select_box($name.'_month', $months, (int)$month, array('id' => $name.'_month'))." &nbsp; ";
		 $built .= $this->generate_numeric_field($name.'_year', $year, array('id' => $name.'_year', 'style' => 'width: 100px;', 'min' => 0));
		 return $built;
	 }
 
	 function output_submit_wrapper($buttons)
	 {
		 global $plugins;
		 $buttons = $plugins->run_hooks("admin_form_output_submit_wrapper", $buttons);
		 $return = "<div class=\"form__submit\">\n";
		 foreach($buttons as $button)
		 {
			 $return .= $button." \n";
		 }
		 $return .= "</div>\n";
		 if($this->_return == false)
		 {
			 echo $return;
		 }
		 else
		 {
			 return $return;
		 }
	 }
 
	 function end()
	 {
		 global $plugins;
		 $plugins->run_hooks("admin_form_end", $this);
		 if($this->_return == false)
		 {
			 echo "</form>";
		 }
		 else
		 {
			 return "</form>";
		 }
	 }
}
?>