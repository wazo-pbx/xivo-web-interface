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

dwho_file::required(array(XIVO_PATH_OBJECT,'application','xivo.inc'),true);

class xivo_application_xivo_object_monitoring extends xivo_application_xivo_object_abstract
{
	var $_commonconf	 = false;
	var $_monitoring	 = false;

	public function __construct(&$xobj)
	{
		parent::__construct($xobj);

		if(($this->_monitoring    = &$this->_xobj->get_module('monitoring'))    === false
		|| ($this->_commonconf    = &$this->_xobj->get_module('commonconf'))    === false)
			return(false);

		return(true);
	}

	function get_monitoring()
	{
        return $this->_monitoring->get(1);
	}

	function set_monitoring($arr)
    {
        $this->_reset();

        if($this->_monitoring->chk_values($arr) === false)
            $this->_set_errors($this->_monitoring->get_filter_error());

        if($this->get_errnb() > 0)
            return false;

        $keys = array('maintenance', 'alert_emails', 'dahdi_monitor_ports', 'max_call_duration');
        foreach(array_keys($arr) as $key)
        {
            if(!in_array($key, $keys))
                unset($arr[$key]);
        }

        if($this->_monitoring->edit(1, $arr) === false)
            return false;

	// notify commonconf needs to be updated
        return $this->_commonconf->notify_changes();
    }


    function set_alerts($arr)
    {
        $this->_reset();

        // check dahdi_monitor_ports
        if(strlen(trim($arr['dahdi_monitor_ports'])) > 0)
        {
            foreach(preg_split('/ /', $arr['dahdi_monitor_ports']) as $port)
            {
                if(!ctype_digit($port))
                    $this->_set_error('dahdi_monitor_ports', 'typechecking');
            }
        }

        if($this->get_errnb() > 0)
            return false;

        return $this->set_monitoring($arr);
    }


    function set_max_call_duration($arr)
    {
        $this->_reset();

        if (!isset($arr['max_call_duration'])
        || $arr['max_call_duration'] == ''
        || !is_numeric($arr['max_call_duration']))
        	$arr['max_call_duration'] = null;
        else
        	$arr['max_call_duration'] = (int) $arr['max_call_duration'];

        return $this->set_monitoring($arr);
    }
}

?>
