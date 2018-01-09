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

$form	 = &$this->get_module('form');
$dhtml 	 = &$this->get_module('dhtml');

$info = $this->get_var('info');
$element = $this->get_var('element');

?>

<div class="b-infos b-form">
<breadcrumb
        page="<?=$this->bbf('title_content_name');?>">
</breadcrumb>

<div class="sb-content">
<form action="#" method="post" accept-charset="utf-8">

<div id="sb-part-first">
<?php

	echo	$form->hidden(array('name'	=> DWHO_SESS_NAME,
				    'value'	=> DWHO_SESS_ID)),

		$form->hidden(array('name'	=> 'fm_send',
				    'value'	=> 1)),

		$form->text(array('desc'	=> $this->bbf('fm_max_call_duration'),
				  'name'	=> 'max_call_duration',
				  'labelid'	=> 'max_call_duration',
				  'size'	=> 15,
				  'value'	=> $info['max_call_duration'],
				  'default'	=> $element['max_call_duration']['default'],
				  'help'    => $this->bbf('fm_help-max_call_duration'),
				  'error'   => $this->bbf_args('max_call_duration',
				      $this->get_var('error', 'max_call_duration'))
            ));
?>
</div>
<?php

echo	$form->submit(array('name'	=> 'submit',
			    'id'	=> 'it-submit',
			    'value'	=> $this->bbf('fm_bt-save')));

?>
</form>
	</div>
	<div class="sb-foot xspan"></div>
