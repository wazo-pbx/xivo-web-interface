<?php

#
# XiVO Web-Interface
# Copyright 2006-2018 The Wazo Authors  (see the AUTHORS file)
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

$appentity = &$_XOBJ->get_application('entity',null,false);

xivo::load_class('xivo_ldapserver',XIVO_PATH_OBJECT,null,false);
$_LDAPSVR = new xivo_ldapserver();

$userstat = $entitystat = $serverstat = $ldapserver = array();
$userstat['enable'] = $entitystat['enable'] = $serverstat['enable'] = $ldapserverstat['enable'] =  0;
$userstat['disable'] = $entitystat['disable'] = $serverstat['disable'] = $ldapserverstat['disable'] = 0;

if(($enableentity = $appentity->get_nb(null,false)) !== false)
	$entitystat['enable'] = $enableentity;

if(($disableentity = $appentity->get_nb(null,true)) !== false)
	$entitystat['disable'] = $disableentity;

$entitystat['total'] = $entitystat['enable'] + $entitystat['disable'];

$userstat['total'] = $userstat['enable'] + $userstat['disable'];

$serverstat['total'] = $serverstat['enable'] + $serverstat['disable'];

if(($enableldapserver = $_LDAPSVR->get_nb(null,false)) !== false)
	$ldapserverstat['enable'] = $enableldapserver;

if(($disableldapserver = $_LDAPSVR->get_nb(null,true)) !== false)
	$ldapserverstat['disable'] = $disableldapserver;

$ldapserverstat['total'] = $ldapserverstat['enable'] + $ldapserverstat['disable'];

$_TPL->set_var('userstat',$userstat);
$_TPL->set_var('entitystat',$entitystat);
$_TPL->set_var('serverstat',$serverstat);
$_TPL->set_var('ldapserverstat',$ldapserverstat);

$menu = &$_TPL->get_module('menu');
$menu->set_top('top/user/'.$_USR->get_info('meta'));
$menu->set_left('left/xivo/configuration');

$_TPL->set_bloc('main','xivo/configuration/index');
$_TPL->set_struct('xivo/configuration');
$_TPL->display('index');

?>
