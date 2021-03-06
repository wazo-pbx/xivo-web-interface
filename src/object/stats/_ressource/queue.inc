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

class stats_ressource_queue extends xivo_stats_ressource_abstract
{

	protected	$_type = 'queue';

	public function __construct(&$_XS)
	{
		parent::__construct($_XS);
	}

	protected function _build_stat($obj_process, $key, $interval)
	{
		$queue_id = $this->_stat_queue->id_from_name($obj_process['name']);
		if (!$queue_id)
			return;

		$total = $this->_stat_queue_periodic->get_event_total($interval, $queue_id);
		$answered = $this->_stat_queue_periodic->get_event_answered($interval, $queue_id);
		$answered_in_qos = $this->_stat_call_on_queue->get_count_under_qos($interval, $queue_id, $obj_process['qos']);
		$closed = $this->_stat_queue_periodic->get_event_closed($interval, $queue_id);
		$divert_ca_ratio = $this->_stat_queue_periodic->get_event_divert_ca_ratio($interval, $queue_id);
		$divert_waittime = $this->_stat_queue_periodic->get_event_divert_waittime($interval, $queue_id);
		$full = $this->_stat_queue_periodic->get_event_full($interval, $queue_id);
		$abandon = $this->_stat_queue_periodic->get_event_abandon($interval, $queue_id);
		$joinempty = $this->_stat_queue_periodic->get_event_joinempty($interval, $queue_id);
		$leaveempty = $this->_stat_queue_periodic->get_event_leaveempty($interval, $queue_id);
		$timeout = $this->_stat_queue_periodic->get_event_timeout($interval, $queue_id);
		$total_wait_time = $this->_stat_call_on_queue->get_queue_wait_time($interval, $queue_id);

		$qos = $answered > 0 ? 100 * $answered_in_qos / $answered : null;

		$hr_total = $answered + $abandon + $closed + $full + $leaveempty + $joinempty + $timeout - $closed;
		$hr = $hr_total > 0 ? 100 * $answered / $hr_total : null;

		$waited_call = $answered + $abandon + $leaveempty + $timeout;
		$awt = $waited_call > 0 ? $total_wait_time / $waited_call : null;

		$blocking = $joinempty + $leaveempty;
		$saturated = $full + $divert_waittime + $divert_ca_ratio;

		$this->_result[$key]['presented']['result'] = $total;
		$this->_result[$key]['connect']['result'] = $answered;
		$this->_result[$key]['average_wait_time']['result'] = $awt;
		$this->_result[$key]['qos']['result'] = $qos;
		$this->_result[$key]['deterred_on_close']['result'] = $closed;
		$this->_result[$key]['deterred_on_saturation']['result'] = $saturated;
		$this->_result[$key]['abandon']['result'] = $abandon;
		$this->_result[$key]['blocking']['result'] = $blocking;
		$this->_result[$key]['timeout']['result'] = $timeout;
		$this->_result[$key]['home_rated']['result'] = $hr;
	}
}

?>
