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

require_once(dwho_file::joinpath(XIVO_PATH_OBJECT,'application','abstract','datastorage','sql.inc'));

class xivo_application_service_asterisk_voicemail_sql extends xivo_application_abstract_datastorage_sql
{
	var $_table	= array('voicemail'	=> '',
	'context'	=> '');

	function get_all($disable=null,$order=null,$limit=null)
	{
		$this->_dso->new_select($this->_table['voicemail']);

		if (defined('ENTITY_FILTER_CONTEXTS'))
			$this->_dso->wherein('context', explode(',', ENTITY_FILTER_CONTEXTS), $this->_table['voicemail']);

		$this->_dso->innerjoin($this->_table['context'],
				      $this->_table['voicemail'].'.context = '.$this->_table['context'].'.name');

		$this->_dso->innerjoin('entity',
				      'entity.name = '.$this->_table['context'].'.entity',
						null,
						array('entity_displayname' => 'displayname'));

		$this->_dso->new_order($order,null,$this->_table['voicemail']);
		$this->_dso->limit($limit);

		$r = $this->_dso->select_all();

		$this->_dso->reset_group();
		$this->_dso->reset_order();
		$this->_dso->reset_limit();

		if(($this->_cnt = $this->_dso->select_distinct_count_singlecolumn(
							null,
							'uniqueid',
							$this->_table['voicemail'])) === false
		|| isset($r[0]) === false)
			$r = false;

		return($r);
	}

	function search($value,$disable=null,$order=null,$limit=null)
	{
		$this->_cnt = 0;

		if(dwho_has_len($value) === false)
			return(false);

		$this->_dso->new_select($this->_table['voicemail']);

		$this->_dso->wherecontain('fullname',$value,true,$this->_table['voicemail']);
		$this->_dso->orwherecontain('mailbox',$value,true,$this->_table['voicemail']);
		$this->_dso->orwherecontain('email',$value,true,$this->_table['voicemail']);
		$this->_dso->aggregate_where();

		if (defined('ENTITY_FILTER_CONTEXTS'))
			$this->_dso->wherein('context', explode(',', ENTITY_FILTER_CONTEXTS), $this->_table['voicemail']);

		$this->_dso->innerjoin($this->_table['context'],
				      $this->_table['voicemail'].'.context = '.$this->_table['context'].'.name');

		$this->_dso->innerjoin('entity',
				      'entity.name = '.$this->_table['context'].'.entity',
						null,
						array('entity_displayname' => 'displayname'));

		$this->_dso->new_order($order,null,$this->_table['voicemail']);
		$this->_dso->limit($limit);

		$r = $this->_dso->select_all();

		$this->_dso->reset_order();
		$this->_dso->reset_limit();

		if(($this->_cnt = $this->_dso->select_count(null,'uniqueid',$this->_table['voicemail'])) === false
		|| isset($r[0]) === false)
			$r = false;

		return($r);
	}
}

?>
