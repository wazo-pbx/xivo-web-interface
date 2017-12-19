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

$url = &$this->get_module('url');
$menu = &$this->get_module('menu');


?>
<div class="navbar-header">
	<a class="navbar-brand" href="/">
		<div id="logo"><?=$url->img_html('img/xivo/xivo_logo.png',XIVO_SOFT_LABEL);?></div>
	</a>
</div>
<div class="collapse navbar-collapse">
	<ul class="nav navbar-nav">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<?=$this->bbf('mn_top_services');?><span class="caret"></span>
			</a>
		  <ul class="dropdown-menu">
	      <li><?=$url->href_html($this->bbf('mn_sub_top_services_ipbx'),'service/ipbx');?></li>
			  <li><?=$url->href_html($this->bbf('mn_sub_top_services_cti'),'cti/general');?></li>
			  <li><?=$url->href_html($this->bbf('mn_sub_top_services_callcenter'),'callcenter');?></li>
			  <li><?=$url->href_html($this->bbf('mn_sub_top_services_monitoring'),'xivo');?></li>
			  <li role="separator" class="divider"></li>
			  <li><?=$url->href_html($this->bbf('mn_sub_top_services_stats'),'graphs');?></li>
			  <li><?=$url->href_html($this->bbf('mn_sub_top_services_statistiques'),'statistics');?></li>
	  	</ul>
		</li>
		<li><?=$url->href_html($this->bbf('mn_top_configuration'),'xivo/configuration');?></li>
		<li><?=$url->href_html($this->bbf('mn_top_help'),'xivo/help');?></li>
		<li><?=$url->href_html($this->bbf('mn_top_contact'),'xivo/contact');?></li>
	</ul>
	<?php $this->file_include('bloc/menu/top/user/loginbox'); ?>
</div>
