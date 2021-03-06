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

require_once(dwho_file::joinpath(XIVO_PATH_OBJECT,'user','abstract.inc'));

class xivo_user_user extends xivo_user_abstract
{
	public function __construct()
	{
		parent::__construct();

		$this->_load_config(XIVO_PATH_OBJECT.DWHO_SEP_DIR.'user');
		$this->_load_dso();

		if(is_object($this->_dso) === false)
			trigger_error('Invalid datastorage in '.__CLASS__,E_USER_ERROR);

		$this->load_by_session();
	}
}

?>
