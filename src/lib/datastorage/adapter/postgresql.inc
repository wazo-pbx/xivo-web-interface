<?php

#
# XiVO Web-Interface
# Copyright (C) 2006-2014  Avencall
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version, with a Section 7 Additional
# Permission as follows:
#   This notice constitutes a grant of such permission as is necessary
#   to combine or link this software, or a modified version of it, with
#   the MySQL Client Library, as published by Sun Microsystems and/or
#   MySQL AB, or a derivative work of the MySQL CLient LIbrary, and to
#   copy, modify, and distribute the resulting work. The MySQL Client
#   LIbrary is licensed under version 2 of the GNU General Public
#   License.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#

require_once(dwho_file::joinpath(DWHO_PATH_ROOT,'datastorage','adapter','abstract','sql.inc'));

class dwho_datastorage_adapter_postgresql extends dwho_datastorage_adapter_abstract_sql
{
	var $_param    = array(
			'host'        => 'localhost',
			'user'        => '',
			'pass'        => '',
			'db'        => '',
			'port'        => 0,
			'socket'    => '',
			'persist'    => false,
			'ssl'        => false);

	var $_flag   = 0;
	var $_type   = 'postgresql';
	var $_free   = true;
	var $_escape = false;
	var $_date   = array(
			'datetime'    => '%Y-%m-%d %H:%i:%s',
			'date'        => '%Y-%m-%d',
			'time'        => '%H:%i:%s');

	public function __construct($param=array())
	{
		$param = (array) $param;

		$open = true;

		if(isset($param['open']) === true)
			$open = false;

		if(isset($param['host']) === true)
			$this->_param['host'] = (string) $param['host'];

		if(isset($param['user']) === true)
			$this->_param['user'] = (string) $param['user'];

		if(isset($param['pass']) === true)
			$this->_param['pass'] = (string) $param['pass'];
		else if(isset($param['passwd']) === true)
			$this->_param['pass'] = (string) $param['passwd'];

		if(isset($param['db']) === true)
			$this->_param['db'] = (string) $param['db'];
		else
			$open = false;

		if(isset($param['port']) === true)
			$this->_param['port'] = dwho_uint($param['port']);

		if(isset($param['socket']) === true)
			$this->_param['socket'] = (string) $param['socket'];

		if(isset($param['persist']) === true)
			$this->_param['persist'] = (bool) $param['persist'];

		if(isset($param['compress']) === true)
			$this->_param['compress'] = (bool) $param['compress'];

		if(isset($param['ignore_space']) === true)
			$this->_param['ignore_space'] = (bool) $param['ignore_space'];

		if(isset($param['interactive']) === true)
			$this->_param['interactive'] = (bool) $param['interactive'];

		if(isset($param['ssl']) === true)
			$this->_param['ssl'] = (bool) $param['ssl'];

		if(isset($param['charset']) === true
				&& preg_match('/^[a-zA-Z0-9-]+$/',$param['charset']) === 1)
			$this->_param['charset'] = strtolower(str_replace('-','',$param['charset']));

		//$this->_escape = (bool) function_exists('postgresql_real_escape_string');

		if($open === true && $this->open() !== false)
			$this->select_db();
	}

	function quote_identifier($name)
	{
		if(($r = $this->_get_scalar($name,true)) !== '' && is_object($name) === false)
			$r = '"'.str_replace('"','',$r).'"';

		return($r);
	}

	function concat($list)
	{
		if(is_array($list) === false)
			return(false);

		return(implode('||',array_map(array($this,'escape'),$list)));
	}
	/*
	 function _set_flag()
	 {
	if($this->_param['compress'] === true)
		$this->_flag |= MYSQL_CLIENT_COMPRESS;

	if($this->_param['ignore_space'] === true)
		$this->_flag |= MYSQL_CLIENT_IGNORE_SPACE;

	if($this->_param['interactive'] === true)
		$this->_flag |= MYSQL_CLIENT_INTERACTIVE;

	if($this->_param['ssl'] === true)
		$this->_flag |= MYSQL_CLIENT_SSL;
	}
	*/
	function open()
	{
		$this->_result = null;
		$connstring = "";
		/*
		 if(is_resource($this->_link) === true)
			return($this->_link);
		*/

		if($this->_param['host'] !== '')
			$connstring = "host=" . $this->_param['host'];
		else
			$connstring = "host=/" . $this->_param['socket'];
		// case host == ipaddr

		if($this->_param['port'] !== 0)
			$connstring .= " port=" . $this->_param['port'];

		$connstring .= " dbname=" . $this->_param['db'];
		$connstring .= " user=" . $this->_param['user'];
		$connstring .= " password=" . $this->_param['pass'];

		if($this->_param['ssl'] === true)
			$connstring .= " sslmode=require";

		if((bool) $this->_param['persist'] === false)
			$this->_link = @pg_connect($connstring);
		else
			$this->_link = @pg_pconnect($connstring);

		if($this->_link === false)
			$this->halt('Can\'t connect to PostgreSQL server');
		/*
		 if($this->_param['charset'] !== '')
			$this->query('SET NAMES \''.$this->_param['charset'].'\'');
		*/
		return($this->_link);
	}

	function select_db()
	{
		/* NOTE: postgresql cannot switch database. We must open a nuew connexion to do
		 * so
		*/
		return $this->open();
	}

	function query($query)
	{
		if(is_string($query) === false)
			return(false);

		$this->_query = $query;
		$this->select_db();

		$this->_debug = true;

		if(($this->_result = @pg_query($this->_link, $this->_query)) === false
				&& (bool) $this->_debug === true)
			$this->halt();

		return($this->_result);
	}

	function lock($t)
	{
		//$query = sprintf('LOCK TABLES %s WRITE',$t);
		//return($this->query($query));
	}

	function unlock()
	{
		//$query = 'UNLOCK TABLES';
		//return($this->query($query));
	}

	function errno()
	{
		if($this->_error === false)
			return -1;

		return 0;
	}

	function error()
	{
		if(is_resource($this->_link) === true)
			return(pg_last_error($this->_link));

		return('');
	}

	function _chk_join($type)
	{
		$type = strtoupper($type);

		if($type === 'FULL')
			return(false);

		return(parent::_chk_join($type));
	}

	function affected_rows()
	{
		if(is_resource($this->_result) === true)
			return(pg_affected_rows($this->_result));

		return(false);
	}

	function insert_id()
	{
		if(is_resource($this->_result) === true
				&& ($res = pg_query($this->_link, "SELECT lastval()")) != null
				&& ($row = pg_fetch_row($res)) != null)
			return $row[0];

		return(false);
	}

	function escape_string($str)
	{
		if(is_resource($this->_link) === false)
			return($str);

		return(pg_escape_string($this->_link, $str));
	}

	function set_bytea_output()
	{
		$this->query('SET bytea_output = "escape";');
	}

	function escape_bytea($str)
	{
		if(is_resource($this->_link) === false)
			return($str);

		return(pg_escape_bytea($this->_link, $str));
	}

	function unescape_bytea($str)
	{
		$escaped_data = str_replace(array("\\\\", "''"), array("\\", "'"), $str);
		/* and later unescape the escaped data from the bytea field with following to get the original binary data */

		return(pg_unescape_bytea($escaped_data));
	}

	function close()
	{
		$r = null;

		if(is_resource($this->_link) === true)
			$r = pg_close($this->_link);

		$this->_link = null;

		return($r);
	}

	function free()
	{
		if(is_resource($this->_result) === true)
			return(pg_free_result($this->_result));

		return(false);
	}

	function num_rows()
	{
		if(is_resource($this->_result) === true)
			return(pg_num_rows($this->_result));

		return(false);
	}

	function fetch_row()
	{
		if(is_resource($this->_result) === true)
			return(pg_fetch_row($this->_result));

		return(false);
	}

	function fetch_assoc()
	{
		if(is_resource($this->_result) === true)
			return(pg_fetch_assoc($this->_result));

		return(false);
	}

	function fetch_full_column_names()
	{
		if(is_resource($this->_result) === false
				|| ($num = pg_num_fields($this->_result)) === 0)
			return(false);

		$r = array();

		for($i = 0;$i < $num; ++$i)
		{
			$table = pg_field_table($this->_result,$i);
			$column = pg_field_name($this->_result,$i);

			if($table === ''
					|| isset($this->_colalias[$table],
							$this->_colalias[$table][$column]) === true)
				$r[$i] = $column;
			else
				$r[$i] = sprintf('%s.%s',$table,$column);
		}

		return($r);
	}

	function _fetch_single_assoc_full_column_names($query,$free=true)
	{
		if($this->query($query,((bool) $free === false)) === false
				|| ($full_column_names = $this->fetch_full_column_names()) === false
				|| ($m = $this->fetch_row()) === false)
			return(false);

		return(dwho_array_combine($full_column_names,$m));
	}

	function _fetch_assoc_full_column_names($query,$free=true,$assoc_column_value=null)
	{
		if($this->query($query,((bool) $free === false)) === false
				|| ($full_column_names = $this->fetch_full_column_names()) === false)
			return(false);

		$r = array();

		if(dwho_has_len($assoc_column_value) === false)
		{
			for($i = 0;$m = $this->fetch_row();$i++)
				$r[$i] = dwho_array_combine($full_column_names,$m);
		}
		else
		{
			for($i = 0;$m = $this->fetch_row();$i++)
			{
				$c = dwho_array_combine($full_column_names,$m);

				if(isset($c[$assoc_column_value]) === true)
					$r[$c[$assoc_column_value]] = $c;
			}
		}

		return($r);
	}

	function unix_timestamp($column='',$time='')
	{
		if(($r = $this->_expr_typetime('date',$column,$time,$this->_date['datetime'])) !== false)
			$r = 'UNIX_TIMESTAMP('.$r.')';

		return($r);
	}

	function _expr_typetime($type='',$column='',$time='',$format='',$table='')
	{
		$type = $type !== '' ? strtolower($type) : 'date';
		$column = trim($column);
		$time = strtolower($time);
		$format = (string) $format;
		$table = trim($table);

		$field = $column;

		if(($type !== 'unix' && $type !== 'date' && $type !== 'datetime') === true
				|| ($time !== '' && $time !== 'localtime' && $time !== 'utc') === true)
			return(false);
		else if($table === '')
			$column = $this->quote_identifier($column);
		else if(isset($this->_table[$table]) === false || $column === '')
			return(false);
		else
			$column = $this->quote_identifier($table).'.'.$this->quote_identifier($column);

		if($type === 'unix')
			$func = 'FROM_UNIXTIME';
		elseif($type === 'datetime')
		$func = 'TO_TIMESTAMP'; //'DATETIME_FORMAT';
		else
			$func = 'TO_CHAR'; //'DATE_FORMAT';

		if($column === '')
			$column = ($time === 'utc' ? 'UTC' : 'CURRENT').'_TIMESTAMP()';
		else if($time === 'utc')
			$column = 'CONVERT_TZ('.$func.'('.$column.',\'%Y-%m-%d %H:%i:%s\'),@@session.time_zone,\'+00:00\')';
		else if($time === 'localtime')
			$column = 'CONVERT_TZ('.$func.'('.$column.',\'%Y-%m-%d %H:%i:%s\'),\'+00:00\',@@session.time_zone)';

		if($type === 'unix')
			$column = 'UNIX_TIMESTAMP('.$column.')';

		// compliant format
		$format = str_replace('%Y', 'YYYY', $format);
		$format = str_replace('%m', 'MM', $format);
		$format = str_replace('%d', 'DD', $format);
		$format = str_replace('%H', 'HH24', $format);
		$format = str_replace('%i', 'MI', $format);
		$format = str_replace('%s', 'SS', $format);

		$r = $func.'('.$column.($format !== '' ? ', \''.$format.'\'' : '').')';

		return($r);
	}

	function cast($field, $type)
	{
		switch($type)
		{
			case 'int':
				$field .= '::int';
				break;
			case 'varchar':
				$field .= '::varchar';
				break;
		}

		return $field;
	}
}

?>
