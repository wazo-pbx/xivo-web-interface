<?php

#
# XiVO Web-Interface
# Copyright (C) 2006-2016  Avencall
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

require_once(dwho_file::joinpath(DWHO_PATH_ROOT,'datastorage','helper','table.inc'));

abstract class xivo_accesswebservice_abstract_sql extends dwho_datastorage_helper_table
{
	var $_table	= 'accesswebservice';
	var $_primary	= array('id' => 0);
	var $_disable	= 'disable';
	var $_unique	= 'name';

	public function __construct(&$dso,$param=array())
	{
		parent::_init($dso,$param);
	}

}

?>
