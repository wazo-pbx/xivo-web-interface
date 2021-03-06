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
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#

xivo_service_asterisk::required(array('abstract','abstract.inc'),true);

class xivo_service_asterisk_stat_call_on_queue extends xivo_service_asterisk_abstract
{
	protected $_dso           = null;
	protected $_name          = 'stat_call_on_queue';
	protected $_filter        = false;
	protected $_queuefeatures = null;
	protected $_stat_queue    = null;

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

	public function get_count_under_qos($interval, $queue_id, $qos)
	{
		return($this->_dso->queue_count_under_qos($qos, $interval, $queue_id));
	}

	public function get_queue_wait_time($interval, $queue_id)
	{
		return($this->_dso->queue_wait_time($interval, $queue_id));
	}

	public function get_count_wait_time_by_period($status, $interval, $queue_id, $interval_wt)
	{
		return($this->_dso->queue_count_by_period($status, $interval, $queue_id, $interval_wt));
	}

	public function get_agent_conversation_time($interval, $agent_ids)
	{
		$conversation_time = $this->_dso->agent_conversation_time($interval, $agent_ids);
		return($this->_interval_value($conversation_time));
	}

	public function get_count_agent_answered($interval, $agent_ids)
	{
		return($this->_dso->agent_count_status('answered', $interval, $agent_ids));
	}


}

?>
