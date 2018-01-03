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

$form = &$this->get_module('form');

?>

<div id="sr-agentgroup" class="b-infos b-form">
	<h4 class="sb-top xspan"><a href="./"><?=$this->bbf('title_parent_name');?></a><span class="text-muted"> > </span><?=$this->bbf('title_content_name');?></h4>
	<div class="sb-content">
<form class="form-horizontal" action="#" method="post" accept-charset="utf-8" onsubmit="dwho.form.select('it-queue');">

<?=$form->hidden(array('name' => DWHO_SESS_NAME,'value' => DWHO_SESS_ID));?>
<?=$form->hidden(array('name' => 'act','value' => 'add'));?>
<?=$form->hidden(array('name' => 'fm_send','value' => 1));?>

<?php
	$this->file_include('bloc/callcenter/settings/agents/form');
?>

<?=$form->submit(array('name' => 'submit','id' => 'it-submit','value' => $this->bbf('fm_bt-save')));?>

</form>
	</div>
	<div class="sb-foot xspan"></div>
</div>
