<?php

#
# XiVO Web-Interface
# Copyright (C) 2006-2016  Avencall
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

$act = isset($_QR['act']) === true ? $_QR['act'] : '';
$iddirectories = isset($_QR['iddirectories']) === true ? dwho_uint($_QR['iddirectories'],1) : 1;
$page = isset($_QR['page']) === true ? dwho_uint($_QR['page'],1) : 1;

xivo::load_class('xivo_directories',XIVO_PATH_OBJECT,null,false);
$dir = new xivo_directories();
$directories = $dir->get_all(null, true);

$param = array();
$param['act'] = 'list';
$param['iddirectories'] = $iddirectories;
$info = $result = array();

switch($act)
{
	case 'add':
		$app = &$ipbx->get_application('ctidirectories');

		$result = $fm_save = null;

		if(isset($_QR['fm_send']) === true
		&& dwho_issa('directories',$_QR) === true)
		{
			$_QR['fields'] = array();
			for($i = 0; $i < count($_QR['field_fieldname'])-1; $i++)
			{
				$_QR['fields'][] = array(
					'dir_id'    => null,
					'fieldname' => $_QR['field_fieldname'][$i],
					'value'     => $_QR['field_value'][$i]
				);
			}

			$_QR['directories']['deletable'] = 1;

			if($app->set_add($_QR) === false
			|| $app->add() === false)
			{
				$fm_save = false;
				$result = $app->get_result();
			}
			else
				$_QRY->go($_TPL->url('cti/directories'),$param);
		}

		dwho::load_class('dwho_sort');

		$_TPL->set_var('directories',$directories);
		$_TPL->set_var('info',$result);
		$_TPL->set_var('fm_save',$fm_save);

		$dhtml = &$_TPL->get_module('dhtml');
		$dhtml->set_js('js/dwho/submenu.js');
		break;

	case 'edit':
		$app = &$ipbx->get_application('ctidirectories');

		if(isset($_QR['iddirectories']) === false
		|| ($info = $app->get($_QR['iddirectories'])) === false)
			$_QRY->go($_TPL->url('cti/directories'),$param);

		$result = $fm_save = null;
		$return = &$info;

		if(isset($_QR['fm_send']) === true
		&& dwho_issa('directories',$_QR) === true)
		{
			$return = &$result;

			$_QR['fields'] = array();
			for($i = 0; $i < count($_QR['field_fieldname'])-1; $i++)
			{
				$_QR['fields'][] = array(
					'dir_id'    => $_QR['iddirectories'],
					'fieldname' => $_QR['field_fieldname'][$i],
					'value'     => $_QR['field_value'][$i]
				);
			}

			$_QR['directories']['deletable'] = 1;
			if($app->set_edit($_QR) === false
			|| $app->edit() === false)
			{
				$fm_save = false;
				$result = $app->get_result();
				$error  = $app->get_error();
			}
			else
				$_QRY->go($_TPL->url('cti/directories'),$param);
		}

		dwho::load_class('dwho_sort');
		dwho::load_class('dwho_json');

		$arr = array();

		foreach(array('match_direct', 'match_reverse') as $v)
		{
			if($return['directories'][$v] != '')
			{
				$arr = dwho_json::decode($return['directories'][$v], true);
				$return['directories'][$v] = implode(',', $arr);
			}
		}

		$_TPL->set_var('directories',$directories);
		$_TPL->set_var('iddirectories',$info['directories']['id']);
		$_TPL->set_var('info',$return);
		$_TPL->set_var('fm_save',$fm_save);

		$dhtml = &$_TPL->get_module('dhtml');
		$dhtml->set_js('js/dwho/submenu.js');
		break;

	case 'delete':
		$param['page'] = $page;

		$app = &$ipbx->get_application('ctidirectories');

		if(isset($_QR['iddirectories']) === false
		|| ($info = $app->get($_QR['iddirectories'])) === false)
			$_QRY->go($_TPL->url('cti/directories'),$param);

		$app->delete();

		$_QRY->go($_TPL->url('cti/directories'),$param);
		break;

	default:
		$act = 'list';
		$prevpage = $page - 1;
		$nbbypage = XIVO_SRE_IPBX_AST_NBBYPAGE;

		$app = &$ipbx->get_application('ctidirectories',null,false);

		$order = array();
		$order['name'] = SORT_ASC;

		$limit = array();
		$limit[0] = $prevpage * $nbbypage;
		$limit[1] = $nbbypage;

		$list = $app->get_directories_list();
		$total = $app->get_cnt();

		if($list === false && $total > 0 && $prevpage > 0)
		{
			$param['page'] = $prevpage;
			$_QRY->go($_TPL->url('cti/directories'),$param);
		}

		$_TPL->set_var('pager',dwho_calc_page($page,$nbbypage,$total));
		$_TPL->set_var('list',$list);
}

$_TPL->set_var('act',$act);
#$_TPL->set_var('group',$group);

$menu = &$_TPL->get_module('menu');
$menu->set_top('top/user/'.$_USR->get_info('meta'));
$menu->set_left('left/cti/menu');

$menu->set_toolbar('toolbar/cti/directories');

$_TPL->set_bloc('main','/cti/directories/'.$act);
$_TPL->set_struct('service/ipbx/'.$ipbx->get_name());
$_TPL->display('index');

?>
