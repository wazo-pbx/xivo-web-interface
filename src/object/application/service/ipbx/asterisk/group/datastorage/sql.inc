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

class xivo_application_service_asterisk_group_sql extends xivo_application_abstract_datastorage_sql
{
	var $_table	= array(
				'groupfeatures'	=> '',
				'context'	=> '',
				'queue'		=> '',
				'queuemember'	=> '');

	function get_all($disable=null,$order=null,$limit=null,$value=null)
	{
		$this->_dso->new_select($this->_table['groupfeatures']);

		$this->_dso->innerjoin($this->_table['queue'],
				       $this->_table['groupfeatures'].'.name = '.$this->_table['queue'].'.name',
				       null,
				       array('commented','category'));

		$this->_dso->leftjoin($this->_table['queuemember'],
				      $this->_table['groupfeatures'].'.name = '.$this->_table['queuemember'].'.queue_name',
				      null,
				      array('nb_qmember' => 'COUNT('.$this->_table['queuemember'].'.userid)'));

		$this->_dso->where(array('deleted' => 0),$this->_table['groupfeatures']);

		if($disable !== null)
		{
			$commented = array('commented' => intval((bool) $disable));
			$this->_dso->andwhere($commented,$this->_table['queue']);
			$this->_dso->andwhere($commented,$this->_table['queuemember']);
		}

		if (defined('ENTITY_FILTER_CONTEXTS'))
			$this->_dso->wherein('context', explode(',', ENTITY_FILTER_CONTEXTS), $this->_table['groupfeatures']);

		$this->_dso->new_group('name',$this->_table['groupfeatures']);
		// PG compat:: must add all columns in SELECT
		$this->_dso->add_group('id',$this->_table['groupfeatures']);
		$this->_dso->add_group('number',$this->_table['groupfeatures']);
		$this->_dso->add_group('context',$this->_table['groupfeatures']);
		$this->_dso->add_group('transfer_user',$this->_table['groupfeatures']);
		$this->_dso->add_group('transfer_call',$this->_table['groupfeatures']);
		$this->_dso->add_group('write_caller',$this->_table['groupfeatures']);
		$this->_dso->add_group('write_calling',$this->_table['groupfeatures']);
		$this->_dso->add_group('timeout',$this->_table['groupfeatures']);
		$this->_dso->add_group('preprocess_subroutine',$this->_table['groupfeatures']);
		$this->_dso->add_group('deleted',$this->_table['groupfeatures']);
		$this->_dso->add_group('commented',$this->_table['queue']);
		$this->_dso->add_group('category',$this->_table['queue']);


		if(dwho_has_len($value) === true)
		{
			$this->_dso->aggregate_where();
			$this->_dso->wherecontain('name',$value,true,$this->_table['groupfeatures']);
			$this->_dso->orwherecontain('number',$value,true,$this->_table['groupfeatures']);
			$this->_dso->aggregate_where();
		}

		$this->_dso->innerjoin($this->_table['context'],
				      $this->_table['groupfeatures'].'.context = '.$this->_table['context'].'.name');

		$this->_dso->innerjoin('entity',
				      'entity.name = '.$this->_table['context'].'.entity',
						null,
						array('entity_displayname' => 'displayname'));
		$this->_dso->add_group('id','entity');

		$this->_dso->new_order($order,null,$this->_table['groupfeatures']);
		$this->_dso->limit($limit);

		$r = $this->_dso->select_all();

		$this->_dso->reset_group();
		$this->_dso->reset_order();
		$this->_dso->reset_limit();

		if(($this->_cnt = $this->_dso->select_distinct_count_singlecolumn(
							null,
							'id',
							$this->_table['groupfeatures'])) === false
		|| isset($r[0]) === false)
			$r = false;

		return($r);
	}

	function search($value,$disable=null,$order=null,$limit=null)
	{
		$this->_cnt = 0;

		if(dwho_has_len($value) === false)
			return(false);

		return($this->get_all($disable,$order,$limit,$value));
	}
}

?>
