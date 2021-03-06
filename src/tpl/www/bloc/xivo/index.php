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

$dhtml = &$this->get_module('dhtml');
$dhtml->write_js('dwho.dom.set_onload(dwho.dom.set_confirm_uri_onchild,\'services\');
 				setInterval("xivo_monitoring_get_all()",2000);');

?>

<div id="system-infos" class="b-infos">
	<h3 class="sb-top xspan">
		<span class="span-left">&nbsp;</span>
		<span class="span-center"><?=$this->bbf('title_content_name');?></span>
		<span class="span-right">&nbsp;</span>
	</h3>

	<div id="box_infos" style="position: absolute;z-index: 100;margin-left: 200px;width: 500px;height: 150px;background: #eee;border: 1px solid #333;display: none;;
		opacity: 0.9;filter: alpha(opacity=90);font-size: 12px;padding: 10px;text-align: center;font-weight: bold;">
		&nbsp;
	</div>

	<div class="sb-content sb-list" id="monitoring">
		<div id="systems"><?php include(XIVO_PATH_ROOT.DIRECTORY_SEPARATOR.'tpl/ui/xivo/monitoring/systems.php'); ?></div>
		<div id="memstats"><?php include(XIVO_PATH_ROOT.DIRECTORY_SEPARATOR.'tpl/ui/xivo/monitoring/memstats.php'); ?></div>
		<div id="services"><?php include(XIVO_PATH_ROOT.DIRECTORY_SEPARATOR.'tpl/ui/xivo/monitoring/services.php'); ?></div>
	</div>
	
	<div class="sb-foot xspan">
		<span class="span-left">&nbsp;</span>
		<span class="span-center">&nbsp;</span>
		<span class="span-right">&nbsp;</span>
	</div>
</div>
