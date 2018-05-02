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

$form = &$this->get_module('form');
$url = &$this->get_module('url');

$info = $this->get_var('info');

?>

<div class="b-infos b-form">
<h3 class="sb-top xspan">
	<span class="span-left">&nbsp;</span>
	<span class="span-center"><?=$this->bbf('title_content_name');?></span>
	<span class="span-right">&nbsp;</span>
</h3>

<div class="sb-content">
<form action="#" method="post" accept-charset="utf-8">

<div id="sb-part-first">
<?php
echo	$form->hidden(array('name'	=> DWHO_SESS_NAME,
				    'value'	=> DWHO_SESS_ID)),

		$form->hidden(array('name'	=> 'fm_send',
				    'value'	=> 1));
?>
	<fieldset id="cti-contexts_services">
		<legend><?=$this->bbf('cti-contexts-directories');?></legend>
		<div id="contexts_services" class="fm-paragraph fm-description">
<?=
	$form->jq_select(array('paragraph'	=> false,
						   'label'		=> false,
						   'name'		=> 'directories[]',
						   'id'		=> 'it-directorieslist',
						   'selected'	=> $info['directoriz']['slt'],
						   'key'		=> false),
					 $info['directoriz']['list']);
?>
		</div>
	</fieldset>
</div>

<div class="fm-paragraph fm-description"><p><?=$this->bbf('need-wazo-dird-restart');?></p></div>

<?php

echo	$form->submit(array('name'	=> 'submit',
			    'id'	=> 'it-submit',
			    'value'	=> $this->bbf('fm_bt-save')));

?>
</form>
	</div>
	<div class="sb-foot xspan">
		<span class="span-left">&nbsp;</span>
		<span class="span-center">&nbsp;</span>
		<span class="span-right">&nbsp;</span>
	</div>
</div>
