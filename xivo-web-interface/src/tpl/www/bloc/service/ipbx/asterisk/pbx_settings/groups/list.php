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
$act   = $this->get_var('act');
$sort  = $this->get_var('sort');

$page = $url->pager($pager['pages'],
		    $pager['page'],
		    $pager['prev'],
		    $pager['next'],
		    'service/ipbx/pbx_settings/groups',
		    array('act' => $act));

?>
<div class="b-list">
<?php
	if($page !== ''):
		echo '<div class="b-page">',$page,'</div>';
	endif;
?>
<form action="#" name="fm-group-list" method="post" accept-charset="utf-8">
<?php
	echo	$form->hidden(array('name'	=> DWHO_SESS_NAME,
				    'value'	=> DWHO_SESS_ID)),

		$form->hidden(array('name'	=> 'act',
				    'value'	=> $act)),

		$form->hidden(array('name'	=> 'page',
				    'value'	=> $pager['page']));
?>
<table id="table-main-listing">
	<tr class="sb-top">
		<th class="th-left xspan"><span class="span-left">&nbsp;</span></th>
		<th class="th-center">
			<span class="title <?= $sort[1]=='name'?'underline':''?>">
				<?= $this->bbf('col_name');?></span>
<?php
	echo	$url->href_html(
					$url->img_html('img/updown.png', $this->bbf('col_sort_name'), 'border="0"'),
					'service/ipbx/pbx_settings/groups',
					array('act'	=> 'list', 'sort' => 'name'),
					null,
					$this->bbf('col_sort_name'));
?>
		</th>
		<th class="th-center">
			<span class="title <?= $sort[1]=='number'?'underline':''?>">
				<?= $this->bbf('col_number');?></span>
<?php
	echo	$url->href_html(
					$url->img_html('img/updown.png', $this->bbf('col_sort_number'), 'border="0"'),
					'service/ipbx/pbx_settings/groups',
					array('act'	=> 'list', 'sort' => 'number'),
					null,
					$this->bbf('col_sort_number'));
?>
		</th>
		<th class="th-center">
				<?= $this->bbf('col_number-users');?>
		</th>
		<th class="th-center col-action"><?=$this->bbf('col_action');?></th>
		<th class="th-right xspan"><span class="span-right">&nbsp;</span></th>
	</tr>
<?php
	if(($list = $this->get_var('list')) === false || ($nb = count($list)) === 0):
?>
	<tr class="sb-content">
		<td colspan="6" class="td-single"><?=$this->bbf('no_group');?></td>
	</tr>
<?php
	else:
		for($i = 0;$i < $nb;$i++):

			$ref = &$list[$i];

			if($ref['commented'] === true):
				$icon = 'disable';
			else:
				$icon = 'enable';
			endif;
?>
	<tr onmouseover="this.tmp = this.className; this.className = 'sb-content l-infos-over';"
	    onmouseout="this.className = this.tmp;"
	    class="sb-content l-infos-<?=(($i % 2) + 1)?>on2">
		<td class="td-left">
			<?=$form->checkbox(array('name'		=> 'groups[]',
						 'value'	=> $ref['id'],
						 'label'	=> false,
						 'id'		=> 'it-groups-'.$i,
						 'checked'	=> false,
						 'paragraph'	=> false));?></td>
		<td class="txt-left" title="<?=dwho_alttitle($ref['name']);?>">
			<label for="it-groups-<?=$i?>" id="lb-groups-<?=$i?>">
<?php
				echo	$url->img_html('img/site/flag/'.$icon.'.gif',null,'class="icons-list"'),
					dwho_trunc($ref['name'],25,'...',false);
?>
			</label>
		</td>
		<td><?=(dwho_has_len($ref['number']) === true ? $ref['number'] : '-')?></td>
		<td class="nbqmember"><?=$ref['nb_qmember']?></td>
		<td class="td-right" colspan="2">
<?php
		echo	$url->href_html($url->img_html('img/site/button/edit.gif',
						       $this->bbf('opt_modify'),
						       'border="0"'),
					'service/ipbx/pbx_settings/groups',
					array('act'	=> 'edit',
					      'id'	=> $ref['id']),
					null,
					$this->bbf('opt_modify')),"\n",
			$url->href_html($url->img_html('img/site/button/delete.gif',
						       $this->bbf('opt_delete'),
						       'border="0"'),
					'service/ipbx/pbx_settings/groups',
					array('act'	=> 'delete',
					      'id'	=> $ref['id'],
					      'page'	=> $pager['page']),
					'onclick="return confirm(\''.$dhtml->escape($this->bbf('opt_delete_confirm')).'\');"
					 id="toto"',
					$this->bbf('opt_delete'));
?>
		</td>
	</tr>
<?php
		endfor;
	endif;
?>
	<tr class="sb-foot">
		<td class="td-left xspan b-nosize"><span class="span-left b-nosize">&nbsp;</span></td>
		<td class="td-center" colspan="4"><span class="b-nosize">&nbsp;</span></td>
		<td class="td-right xspan b-nosize"><span class="span-right b-nosize">&nbsp;</span></td>
	</tr>
</table>
</form>
<?php
	if($page !== ''):
		echo '<div class="b-page">',$page,'</div>';
	endif;
?>
</div>
