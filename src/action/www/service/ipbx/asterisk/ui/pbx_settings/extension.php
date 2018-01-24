<?php

#
# XiVO Web-Interface
# Copyright (C) 2006-2014  Avencall
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#

include(dwho_file::joinpath(dirname(__FILE__),'..','_common.php'));

if(defined('XIVO_LOC_UI_ACTION') === true)
	$act = XIVO_LOC_UI_ACTION;
else
	$act = $_QRY->get('act');

/*
 *

$_QRY->get('context')
eg. default, intern ......

$_QRY->get('obj')
eg. user, group ...

$_QRY->get('startnum')
eg. 80, 422 ...

$_QRY->get('except')
eg.

 *
 */

switch($act)
{
	case 'search':
	default:
		$act = 'search';
		$appcontext = &$ipbx->get_application('context');
		$context_id = $_QRY->get('context');

		if(($context = $appcontext->get($context_id)) === false)
		{
			$http_response->set_status_line(404);
			$http_response->send(true);
		}

		$contextnumbers = $context['contextnumbers'];

		$obj = $_QRY->get('obj');
		if(is_null($obj) || !array_key_exists($obj, $contextnumbers))
		{
			$http_response->set_status_line(204);
			$http_response->send(true);
		}

		if (($numbers_unavailable = $appcontext->get_extens_for_context_and_object($context_id, $obj)) === false)
		{
			$http_response->set_status_line(204);
			$http_response->send(true);
		}

		$contextnumbers_obj = $contextnumbers[$obj];

		$has_getnumpull = (bool) $_QRY->get('getnumpool');

		$filter = '';
		if (is_null($_QRY->get('startnum')) === false)
			$filter  = $_QRY->get('startnum');
		elseif(is_null($_QRY->get('q')) === false)
			$filter  = $_QRY->get('q');

		if ($filter != '')
		{
			if(strlen($filter) > 0 && !is_numeric($filter))
			{
				$_TPL->set_var('list', array());
				break;
			}
		}

		$numbers = array();
		$list_pool_free = array();
		foreach($contextnumbers_obj as $numb)
		{
			$str_start = $numb['numberbeg'];
			$str_end = $numb['numberend'];
			$start = intval($str_start);
			$end = intval($str_end);
			$digits = strLen($str_start);

			if($has_getnumpull)
			{
				array_push($list_pool_free, array('numberbeg' => $str_start, 'numberend' => $str_end));
				continue;
			}

            if ($filter != '')
            {
                $start = str_pad($filter, $digits, "0", STR_PAD_RIGHT);
                $end = str_pad($filter, $digits, "9", STR_PAD_RIGHT);

                if(strcmp($start, $str_end) > 0)
                    continue;
                if(strcmp($start, $str_start) < 0)
                    $start = $str_start;
                if(strcmp($end, $str_end) > 0)
                    $end = $str_end;
            }

			for($int_number = intval($start); $int_number <= intval($end); $int_number += 1)
			{
				$number = str_pad($int_number, $digits, "0", STR_PAD_LEFT);
				array_push($numbers, $number);
			}
		}

		if ($has_getnumpull)
		{
			$_TPL->set_var('list', $list_pool_free);
			$_TPL->display('genericjson');
		}

		foreach($numbers_unavailable as $number_unavailable) {
			if(($idx = array_search($number_unavailable, $numbers)) !== false)
				unset($numbers[$idx]);
		}

		switch ($_QRY->get('format'))
		{
			case 'jquery':
				$list = '';
				foreach(array_values($numbers) as $num)
					$list .=  $num."\n";
				break;
			case null:
			default:
				$list = array();
				// just to respect suggest.js data format
				foreach(array_values($numbers) as $num)
					$list[] = array('id' => $num, 'identity' => strval($num), 'info' => '');
		}

		$_TPL->set_var('list', $list);
		break;
}

$_TPL->display('/service/ipbx/'.$ipbx->get_name().'/pbx_settings/extension');

?>
