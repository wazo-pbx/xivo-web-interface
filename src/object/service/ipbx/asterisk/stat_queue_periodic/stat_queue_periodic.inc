<?php

#
# XiVO Web-Interface
# Copyright (C) 2012-2014  Avencall
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

xivo_service_asterisk::required(array('abstract','abstract.inc'),true);

class xivo_service_asterisk_stat_queue_periodic extends xivo_service_asterisk_abstract
{
	protected	$_dso			= null;
	protected	$_name			= 'stat_queue_periodic';
	protected	$_filter		= false;
	protected	$_queuefeatures	= null;
	protected	$_stat_queue	= null;

	public function __construct(&$sre,&$dso)
	{
		if(is_object($sre) === false)
			trigger_error('Invalid service in '.__CLASS__,E_USER_ERROR);

		if(is_object($dso) === false)
			trigger_error('Invalid datastorage in '.__CLASS__,E_USER_ERROR);

		$this->_sre = &$sre;
		$this->_dso = &$dso;

		$this->_queuefeatures = $this->_sre->get_module('queuefeatures');
		$this->_stat_queue = $this->_sre->get_module('stat_queue');
	}

	function get_min_and_max_time()
	{
		if(($min = $this->_dso->get_min_time()) === false
		|| ($max = $this->_dso->get_max_time()) === false)
			return(false);

		$rs = array();
		$rs['min'] = $min;
		$rs['max'] = $max;

		return($rs);
	}

	function get_event_abandon($interval, $queue_id)
	{
		return($this->_dso->queue_sum_by_event('abandoned', $interval, $queue_id));
	}

	function get_event_answered($interval, $queue_id)
	{
		return($this->_dso->queue_sum_by_event('answered', $interval, $queue_id));
	}

	function get_event_closed($interval, $queue_id)
	{
		return($this->_dso->queue_sum_by_event('closed', $interval, $queue_id));
	}

	function get_event_full($interval, $queue_id)
	{
		return($this->_dso->queue_sum_by_event('full', $interval, $queue_id));
	}

	function get_event_joinempty($interval, $queue_id)
	{
		return($this->_dso->queue_sum_by_event('joinempty', $interval, $queue_id));
	}

	function get_event_leaveempty($interval, $queue_id)
	{
		return($this->_dso->queue_sum_by_event('leaveempty', $interval, $queue_id));
	}

	function get_event_timeout($interval, $queue_id)
	{
		return($this->_dso->queue_sum_by_event('timeout', $interval, $queue_id));
	}

	function get_event_divert_ca_ratio($interval, $queue_id)
	{
		return($this->_dso->queue_sum_by_event('divert_ca_ratio', $interval, $queue_id));
	}

	function get_event_divert_waittime($interval, $queue_id)
	{
		return($this->_dso->queue_sum_by_event('divert_waittime', $interval, $queue_id));
	}

	function get_event_total($interval, $queue_id)
	{
		return($this->_dso->queue_sum_by_event('total', $interval, $queue_id));
	}
}

?>
