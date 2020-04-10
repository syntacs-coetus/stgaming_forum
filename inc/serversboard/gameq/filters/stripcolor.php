<?php
/**
 * This file is part of GameQ.
 *
 * GameQ is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * GameQ is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Strip color codes from specific protocol types.  This code was adapted from the original filter class
 *
 * @author Austin Bischoff <austin@codebeard.com>
 */
class GameQ_Filters_Stripcolor extends GameQ_Filters
{
	/**
	 * Strip all the color junk from returns
	 * @see GameQ_Filters_Core::filter()
	 */
	public function filter($data, GameQ_Protocols_Core $protocol_instance)
	{
		// Check the type of protocol
		switch($protocol_instance->protocol())
		{
			case 'quake2':
			case 'quake3':
			case 'doom3':
			case 'wet';
				array_walk_recursive($data, array($this, 'stripQuake'));
				break;

			case 'unreal2':
			case 'ut3':
			case 'gamespy3':  //not sure if gamespy3 supports ut colors but won't hurt
			case 'gamespy2':
			case 'minecraft':
				array_walk_recursive($data, array($this, 'stripMinecraft'));
				break;

			default:
				break;
		}

		return $data;
	}
	
	/**
	 * Strips minecraft color tags
	 *
	 * @param  $string  string  String to strip
	 * @param  $key     string  Array key
	 */
	protected function stripMinecraft(&$string, $key)
	{;
		$string = preg_replace('/(
                            (?:   [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
                              |   [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
                              |   [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
                              |   [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
                            ){1,100}                          # ...one or more times
                          )
                          | .[0-9|a-f|cX|nY|nX|cY|k-o|r]      # anything else
                        /x', '$1', $string);
	}

	/**
	 * Strips quake color tags
	 *
	 * @param  $string  string  String to strip
	 * @param  $key     string  Array key
	 */
	protected function stripQuake(&$string, $key)
	{
		$string = preg_replace('#(\^.)#', '', $string);
	}

	/**
	 * Strip UT color tags
	 *
	 * @param  $string  string  String to strip
	 * @param  $key     string  Array key
	 */
	protected function stripUT(&$string, $key)
	{
		$string = preg_replace('/\x1b.../', '', $string);
	}
}
