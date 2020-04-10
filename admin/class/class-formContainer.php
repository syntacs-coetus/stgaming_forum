<?php
class FormContainer extends DefaultFormContainer
{
	/** @var Table */
	private $_container;
	/** @var string */
	public $_title;

	/**
	 * Initialise the new form container.
	 *
	 * @param string $title The title of the form container
	 * @param string $extra_class An additional class to apply if we have one.
	 */
	function __construct($title='', $extra_class='')
	{
		$this->_container = new Table;
		$this->extra_class = $extra_class;
		$this->_title = $title;
	}

	/**
	 * Output a header row of the form container.
	 *
	 * @param string $title The header row label.
	 * @param array $extra Array of extra information for this header cell (class, style, colspan, width)
	 */
	function output_row_header($title, $extra=array())
	{
		$this->_container->construct_header($title, $extra);
	}

	/**
	 * Output a row of the form container.
	 *
	 * @param string $title The title of the row.
	 * @param string $description The description of the row/field.
	 * @param string $content The HTML content to show in the row.
	 * @param string $label_for The ID of the control this row should be a label for.
	 * @param array $options Array of options for the row cell.
	 * @param array $row_options Array of options for the row container.
	 */
	function output_row($title, $description="", $content="", $label_for="", $options=array(), $row_options=array())
	{
		global $plugins;
		$pluginargs = array(
			'title' => &$title,
			'description' => &$description,
			'content' => &$content,
			'label_for' => &$label_for,
			'options' => &$options,
			'row_options' => &$row_options,
			'this' => &$this
		);

		$plugins->run_hooks("admin_formcontainer_output_row", $pluginargs);

		$row = $for = '';
		if($label_for != '')
		{
			$for = " for=\"{$label_for}\"";
		}

		if($title)
		{
			$row = "<label{$for} class=\"title title--section\">{$title}</label>";
		}
		
		$row .= '<div class="form__container">';

		if($description != '')
		{
			$row .= "\n<div class=\"form__description\">{$description}</div>\n";
		}

		$row .= "<div class=\"block__row block__row--field\">{$content}</div></div>\n";

		$this->_container->construct_cell($row, $options);

		if(!isset($options['skip_construct']))
		{
			$this->_container->construct_row($row_options);
		}
	}

	/**
	 * Output a row cell for a table based form row.
	 *
	 * @param string $data The data to show in the cell.
	 * @param array $options Array of options for the cell (optional).
	 */
	function output_cell($data, $options=array())
	{
		$this->_container->construct_cell($data, $options);
	}

	/**
	 * Build a row for the table based form row.
	 *
	 * @param array $extra Array of extra options for the cell (optional).
	 */
	function construct_row($extra=array())
	{
		$this->_container->construct_row($extra);
	}

	/**
	 * return the cells of a row for the table based form row.
	 *
	 * @param string $row_id The id of the row.
	 * @param boolean $return Whether or not to return or echo the resultant contents.
	 * @return string The output of the row cells (optional).
	 */
	function output_row_cells($row_id, $return=false)
	{
		if(!$return)
		{
			echo $this->_container->output_row_cells($row_id, $return);
		}
		else
		{
			return $this->_container->output_row_cells($row_id, $return);
		}
	}

	/**
	 * Count the number of rows in the form container. Useful for displaying a 'no rows' message.
	 *
	 * @return int The number of rows in the form container.
	 */
	function num_rows()
	{
		return $this->_container->num_rows();
	}

	/**
	 * Output the end of the form container row.
	 *
	 * @param boolean $return Whether or not to return or echo the resultant contents.
	 * @return string The output of the form container (optional).
	 */
	function end($return=false)
	{
		global $plugins;

		$hook = array(
			'return'	=> &$return,
			'this'		=> &$this
		);

		$plugins->run_hooks("admin_formcontainer_end", $hook);
		if($return == true)
		{
			return $this->_container->output($this->_title, 1, "form_container {$this->extra_class}", true);
		}
		else
		{
			echo $this->_container->output($this->_title, 1, "form_container {$this->extra_class}", false);
		}
	}
}
?>