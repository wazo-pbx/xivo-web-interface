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

$access_category = 'pbx_settings';
$access_subcategory = 'groups';

include(dwho_file::joinpath(dirname(__FILE__),'..','_common.php'));

$act = $_QRY->get('act');

switch($act)
{
	case 'view':
		$appgroup = &$ipbx->get_application('group');

		$nocomponents = array('exten' => true);

		if(($info = $appgroup->get($_QRY->get('id'),
					   null,
					   $nocomponents)) === false)
		{
			$http_response->set_status_line(404);
			$http_response->send(true);
		}

		$_TPL->set_var('info',$info);
		break;
	case 'add':
		$appgroup = &$ipbx->get_application('group');

		if($appgroup->add_from_json() === true)
			$status = 200;
		else
			$status = 400;

		dwho_error_log($appgroup->get_error(), $status);

		$http_response->set_status_line($status);
		$http_response->send(true);
		break;
	case 'edit':
		$appgroup = &$ipbx->get_application('group');

		if(($group = $appgroup->get($_QRY->get('id'))) === false)
			$status = 404;
		else if($appgroup->edit_from_json($group) === true)
			$status = 200;
		else
			$status = 400;

		dwho_error_log($appgroup->get_error(), $status);

		$http_response->set_status_line($status);
		$http_response->send(true);
		break;
	case 'delete':
		$appgroup = &$ipbx->get_application('group');

		if($appgroup->get($_QRY->get('id')) === false)
			$status = 404;
		else if($appgroup->delete() === true)
			$status = 200;
		else
			$status = 500;

		dwho_error_log($appgroup->get_error(), $status);

		$http_response->set_status_line($status);
		$http_response->send(true);
		break;
	case 'deleteall':
		$appgroup = &$ipbx->get_application('group');

		if(($list = $appgroup->get_groups_list()) === false
		|| ($nb = count($list)) === 0)
		{
			$http_response->set_status_line(204);
			$http_response->send(true);
		}
		for ($i=0; $i<$nb; $i++)
		{
			$ref = &$list[$i];
			$appgroup->get($ref['id']);
			$appgroup->delete();
		}
		$status = 200;

		$http_response->set_status_line($status);
		$http_response->send(true);
		break;
	case 'search':
		$appgroup = &$ipbx->get_application('group',null,false);

		if(($list = $appgroup->get_groups_search($_QRY->get('search'))) === false)
		{
			$http_response->set_status_line(204);
			$http_response->send(true);
		}

		$_TPL->set_var('list',$list);
		break;
	case 'list':
	default:
		$act = 'list';

		$appgroup = &$ipbx->get_application('group',null,false);

		if(($list = $appgroup->get_groups_list()) === false)
		{
			$http_response->set_status_line(204);
			$http_response->send(true);
		}

		$_TPL->set_var('list',$list);
}

$_TPL->set_var('act',$act);
$_TPL->set_var('sum',$_QRY->get('sum'));
$_TPL->display('/service/ipbx/'.$ipbx->get_name().'/generic');

?>
