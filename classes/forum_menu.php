<?php
// Copyright 2011 Toby Zerner, Simon Zerner
// This file is part of esoTalk. Please see the included license file for usage information.

/**
 * The Forum_Menu class provides a way to collect menu items and then render them as list items in a menu.
 *
 * @package esoTalk
 */
class Forum_Menu 
{
	/**
	 * A list of menu items.
	 * @var array
	 */
	public $items = array();


	/**
	 * A list of menu item keys to highlight.
	 * @var array
	 */
	public $highlight = array();


	/**
	 * Add an item to this menu collection.
	 *
	 * @param string $id The name of the menu item.
	 * @param string $html The HTML content of the menu item.
	 * @param mixed $position The position to put the menu item, relative to other menu items.
	 * @see Phpr_Array::inject_at_key
	 * @return void
	 */
	public function add($id, $html, $position = false)
	{
		Phpr_Array::inject_at_key($this->items, $id, $html, $position);
	}


	/**
	 * Remove an item from this menu collection.
	 *
	 * @param string $id The name of the menu item.
	 * @return void
	 */
	public function remove($id)
	{
		unset($this->items[$id]);
	}


	/**
	 * Add a separator item to this menu collection.
	 *
	 * @param mixed $position The position to put the menu item, relative to other menu items.
	 * @see Phpr_Array::inject_at_key
	 * @return void
	 */
	public function separator($position = false)
	{
		Phpr_Array::inject_at_key($this->items, count($this->items) + 1, "separator", $position);
	}


	/**
	 * Highlight a particular menu item.
	 *
	 * @param string $id The name of the menu item to highlight.
	 * @return void
	 */
	public function highlight($id)
	{
		$this->highlight[] = $id;
	}


	/**
	 * Get the contents of the menu as a string of <li> elements.
	 *
	 * @return string The HTML contents of the menu.
	 */
	public function get_contents()
	{
		$return = "";
		foreach ($this->items as $k => $v) {
			if ($v == "separator") $return .= "<li class='sep'></li>\n";
			else $return .= "<li class='item-$k".(in_array($k, $this->highlight) ? " selected" : "")."'>$v</li>\n";
		}
		return $return;
	}


	/**
	 * Get the number of menu items collected in this menu.
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->items);
	}

}