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
$cat = $this->get_var('cat');

$page = $url->pager($pager['pages'],
		    $pager['page'],
		    $pager['prev'],
		    $pager['next'],
		    'service/ipbx/pbx_services/musiconhold',
		    array('act' => $act,'cat' => $cat));

?>
<div class="b-list">
<?php
	if($page !== ''):
		echo '<div class="b-page">',$page,'</div>';
	endif;
?>
<table class="table table-condensed table-striped table-bordered" id="table-main-listing">
	<tr class="sb-top">
		<th class="th-left xspan"><span class="span-left">&nbsp;</span></th>
		<th class="th-center"><?=$this->bbf('col_file');?></th>
		<th class="th-center col-action"><?=$this->bbf('col_action');?></th>
		<th class="th-right xspan"><span class="span-right">&nbsp;</span></th>
	</tr>
<?php
	if(($list = $this->get_var('list')) === false || ($nb = count($list)) === 0):
?>
	<tr class="sb-content">
		<td colspan="4" class="td-single"><?=$this->bbf('no_file');?></td>
	</tr>
<?php
	else:
		for($i = $pager['beg'],$j = 0; $i < $pager['end'] && $i < $pager['total'];$i++,$j++):

			$ref = &$list[$i];
?>
	<tr onmouseover="this.tmp = this.className; this.className = 'sb-content l-infos-over';"
	    onmouseout="this.className = this.tmp;"
	    class="sb-content l-infos-<?=(($j % 2) + 1)?>on2">
		<td class="td-left txt-left curpointer"
		    colspan="2"
		    onclick="location.href = dwho.dom.node.firstchild(this);">
			<?=$url->href_html($ref,
					   'service/ipbx/pbx_services/musiconhold',
					   array('act'	=> 'download',
						 'cat'	=> $cat,
						 'id'	=> $ref,
						 'page'	=> $pager['page']));?>
		</td>
		<td class="td-right" colspan="2">
<?php
			echo	$url->href_html($url->img_html('img/site/button/edit.gif',
							       $this->bbf('opt_modify'),
							       'border="0"'),
						'service/ipbx/pbx_services/musiconhold',
						array('act'	=> 'editfile',
						      'cat'	=> $cat,
						      'id'	=> $ref),
						null,
						$this->bbf('opt_modify')),"\n",
				$url->href_html($url->img_html('img/site/button/delete.gif',
							       $this->bbf('opt_delete'),
							       'border="0"'),
						'service/ipbx/pbx_services/musiconhold',
						array('act'	=> 'deletefile',
						      'cat'	=> $cat,
						      'id'	=> $ref,
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
<?php
	if($page !== ''):
		echo '<div class="b-page">',$page,'</div>';
	endif;
?>
</div>
