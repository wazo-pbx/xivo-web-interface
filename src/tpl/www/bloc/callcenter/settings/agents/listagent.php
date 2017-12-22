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
$form = &$this->get_module('form');
$dhtml = &$this->get_module('dhtml');

$pager = $this->get_var('pager');
$act = $this->get_var('act');
$group = $this->get_var('group');

if(($search = (string) $this->get_var('search')) !== '') {
	$param['search'] = $search;
}

$page = $url->pager(
		$pager['pages'],
		$pager['page'],
		$pager['prev'],
		$pager['next'],
		'callcenter/settings/agents',
		array('act'		=> $act,
			'group'	=> $group));

?>
<div id="sr-agent" class="b-list">
<?php
	if($page !== ''):
		echo '<div class="b-page">',$page,'</div>';
	endif;
?>
<form action="#" name="fm-agents-list" method="post" accept-charset="utf-8">
<?php
	echo	$form->hidden(array('name'	=> DWHO_SESS_NAME,
			'value'	=> DWHO_SESS_ID)),
	$form->hidden(array('name'	=> 'act', 'value'	=> $act)),
	$form->hidden(array('name'	=> 'page', 'value'	=> $pager['page'])),
	$form->hidden(array('name'	=> 'group', 'value'	=> $group)),
	$form->hidden(array('name' => 'search','value' => ''));
?>
<table class="table table-condensed table-striped table-hover table-bordered" id="table-main-listing">
	<tr class="sb-top">
		<th class="th-left xspan"><span class="span-left">&nbsp;</span></th>
		<th class="th-center"><?=$this->bbf('col_fullname');?></th>
		<th class="th-center"><?=$this->bbf('col_number');?></th>
		<th class="th-center"><?=$this->bbf('col_entity');?></th>
		<th class="th-center"><?=$this->bbf('col_passwd');?></th>
		<th class="th-center col-action"><?=$this->bbf('col_action');?></th>
		<th class="th-right xspan"><span class="span-right">&nbsp;</span></th>
	</tr>
<?php
	if(($list = $this->get_var('list')) === false || ($nb = count($list)) === 0):
?>
	<tr class="sb-content">
		<td colspan="7" class="td-single"><?=$this->bbf('no_agent');?></td>
	</tr>
<?php
	else:
		for($i = 0;$i < $nb;$i++):

			$ref = &$list[$i];
?>
	<tr onmouseover="this.tmp = this.className; this.className = 'sb-content l-infos-over';"
	    onmouseout="this.className = this.tmp;"
	    class="sb-content l-infos-<?=(($i % 2) + 1)?>on2">
		<td class="td-left">
			<?=$form->checkbox(array('name'		=> 'agents[]',
						 'value'	=> $ref['agentfeatures']['id'],
						 'label'	=> false,
						 'id'		=> 'it-agents-'.$i,
						 'checked'	=> false,
						 'paragraph'	=> false));?>
		</td>
		<td class="txt-left" title="<?=dwho_alttitle($ref['agentfeatures']['fullname']);?>">
			<label for="it-agents-<?=$i?>" id="lb-agents-<?=$i?>">
<?php
				echo dwho_htmlen(dwho_trunc($ref['agentfeatures']['fullname'],25,'...',false));
?>
			</label>
		</td>
		<td><?=$ref['agentfeatures']['number']?></td>
		<td class="col_entity"><?=$ref['entity_displayname']?></td>
		<td><?=(dwho_has_len($ref['agentfeatures']['passwd']) === true ? $ref['agentfeatures']['passwd'] : '-')?></td>
		<td class="td-right" colspan="2">
<?php
		echo	$url->href_html($url->img_html('img/site/button/edit.gif',
						       $this->bbf('opt_modify'),
						       'border="0"'),
					'callcenter/settings/agents',
					array('act'	=> 'editagent',
					      'group'	=> $ref['agentfeatures']['numgroup'],
					      'id'	=> $ref['agentfeatures']['id']),
					null,
					$this->bbf('opt_modify')),"\n",
			$url->href_html($url->img_html('img/site/button/delete.gif',
						       $this->bbf('opt_delete'),
						       'border="0"'),
					'callcenter/settings/agents',
					array('act'	=> 'deleteagent',
					      'group'	=> $ref['agentfeatures']['numgroup'],
					      'id'	=> $ref['agentfeatures']['id'],
					      'page'	=> $pager['page']),
					'onclick="return(confirm(\''.$dhtml->escape($this->bbf('opt_delete_confirm')).'\'));"',
					$this->bbf('opt_delete'));
?>
		</td>
	</tr>
<?php
		endfor;
	endif;
?>
</table>
</form>
<?php
	if($page !== ''):
		echo '<div class="b-page">',$page,'</div>';
	endif;
?>
</div>
