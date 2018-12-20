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

require_once('xivo.php');

if($_USR->mk_active() === false)
    $_QRY->go($_TPL->url('xivo/logoff'));

// search leaf full path (inverse resolution)
$leaf = trim($_SERVER['PATH_INFO'], '/');

if(xivo_user::chk_acl('','',$leaf) === false)
    $_QRY->go($_TPL->url('xivo'));

$ipbx = &$_SRE->get('ipbx');

$dhtml = &$_TPL->get_module('dhtml');
$dhtml->set_css('css/service/ipbx/'.$ipbx->get_name().'.css');
$dhtml->set_js('js/service/ipbx/'.$ipbx->get_name().'.js');

$_TPL->load_i18n_file('struct/service/ipbx/'.$ipbx->get_name());

$action_path = $_LOC->get_action_path('cti',0);

if($action_path === false)
    $_QRY->go($_TPL->url('xivo/logoff'));

die(include($action_path));

?>
