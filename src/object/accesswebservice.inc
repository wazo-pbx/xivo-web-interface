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

dwho::load_class('dwho_network');

require_once(dwho_file::joinpath(XIVO_PATH_OBJECT,'abstract','libdatastorage.inc'));
require_once(dwho_file::joinpath(XIVO_PATH_OBJECT,'auth','client.inc'));
require_once(dwho_file::joinpath(XIVO_PATH_OBJECT,'auth','token','token.inc'));

class xivo_accesswebservice extends xivo_libdatastorage_abstract
{
	var $_conf		= array();
	var $_dso		= null;
	var $_name		= 'accesswebservice';
	var $_filter		= false;
	var $_origin		= false;
	var $_origin_list	= false;
	private $token_resource = null;

	public function __construct()
	{
		$this->_load_config(dirname(__FILE__).DWHO_SEP_DIR.'accesswebservice');
		$this->_load_dso();

		if(($this->client = AuthClient::default_config()) === false) {
			trigger_error('Invalid AUTH object',E_USER_ERROR);
			return(false);
		}
		$this->client->set_backend('xivo_service');

		if(($this->token_resource = new TokenResource($this->client)) === false) {
			trigger_error('Invalid TokenResource',E_USER_ERROR);
			return(false);
		}
	}

	function _pg_array_parse($literal)
	{
		if ($literal == '') return;
		preg_match_all('/(?<=^\{|,)(([^,"{]*)|\s*"((?:[^"\\\\]|\\\\(?:.|[0-9]+|x[0-9a-f]+))*)"\s*)(,|(?<!^\{)(?=\}$))/i', $literal, $matches, PREG_SET_ORDER);
		$values = [];
		foreach ($matches as $match) {
			$values[] = $match[3] != '' ? stripcslashes($match[3]) : (strtolower($match[2]) == 'null' ? null : $match[2]);
		}
		return $values;
	}

	function _prepare($data)
	{
		$data['disable'] = (bool) $data['disable'];
		$data['acl'] = $this->_pg_array_parse($data['acl']);

		return($data);
	}

	function add($arr,$id=0)
	{
		if(is_array($arr) === false)
			return(false);

		return(parent::add($arr,$id));
	}

	function _load_dso()
	{
		$dso = dwho_gct::get('DWHO_DSO');
		$type = $dso->get_type();
		$class = 'xivo_accesswebservice_'.$type;
		$dir = dwho_file::joinpath(XIVO_PATH_OBJECT,'accesswebservice','datastorage');

		if(xivo::load_class($class,$dir,$type,false) === false)
		{
			trigger_error('Failed to load datastorage '.$type.' for accesswebservice',E_USER_ERROR);
			return(false);
		}

		$this->_dso = new $class($dso);
		return(true);
	}

	function chk_http_access($category='',$subcategory='',$section='')
	{
		if(isset($_SERVER['REMOTE_ADDR']) === true)
			$host = $_SERVER['REMOTE_ADDR'];
		else
			$host = null;

		if(isset($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']) === true)
			$id = $this->chk_user_access($_SERVER['PHP_AUTH_USER'],
						     $_SERVER['PHP_AUTH_PW'],
						     $host);
		else
			$id = $this->chk_host_access($host);

		if($id === false)
			return(null);

		return(true);
	}

	function chk_token($login,$pass)
	{
		$tk = null;
		if(isset($_SESSION['token'])) {
			$tk = $this->token_resource->get($_SESSION['token']);
		}
		if(!$tk) {
			$tk = $this->token_resource->create($login, $pass);
		}
		if(!$tk) {
			return(false);
		}

		$token = $tk['data']['token'];
		if ($token) {
			$_SESSION['token'] = $token;
			return(true);
		}

		return(false);
	}

	function chk_user_access($user,$passwd,$host=null)
	{
		if(dwho_has_len($user) === false
		|| dwho_has_len($passwd) === false)
			return(false);

		if(($rs = $this->chk_token($user,$passwd)) === false)
			return(false);

		$where = array();
		$where['user'] = $user;

		if(($rs = $this->get_all_where($where,false,false)) === false
		|| ($nb = count($rs)) === 0)
			return(false);

		for($i = 0;$i < $nb;$i++)
		{
			if($user !== $rs[$i]['login'] || $passwd !== $rs[$i]['passwd'])
				continue;
			else if(dwho_has_len($rs[$i]['host']) === false
			|| dwho_network::ipv4_in_lhost($host,$rs[$i]['host']) === true)
				return($rs[$i]['id']);
		}

		return(false);
	}

	function chk_host_access($host)
	{
		if(dwho_has_len($host) === false
		|| ($rs = $this->get_all(false,false)) === false
		|| ($nb = count($rs)) === 0)
			return(false);

		for($i = 0;$i < $nb;$i++)
		{
			if(dwho_network::ipv4_in_lhost($host,$rs[$i]['host']) === true
			&& dwho_has_len($rs[$i]['login']) === false
			&& dwho_has_len($rs[$i]['passwd']) === false)
				return($rs[$i]['id']);
		}

		return(false);
	}
}

?>
