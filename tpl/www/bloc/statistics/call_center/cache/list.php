<?php

#
# XiVO Web-Interface
# Copyright (C) 2006-2011  Proformatique <technique@proformatique.com>
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
$dhtml->write_js('');

$act = $this->get_var('act');
$idconf = $this->get_var('ifconf');
$conf = $this->get_var('conf');
$listtype = $this->get_var('listtype');
$dbeg = $this->get_var('dbeg');
$dend = $this->get_var('dend');

$dencache = ($dend != 0) ? $this->bbf('fm_description_cache-with_end',array($dend)) : $this->bbf('fm_description_cache-without_end'); 

?>
	
<div class="b-infos b-form">
	<h3 class="sb-top xspan">
		<span class="span-left">&nbsp;</span>
		<span class="span-center"><?=$this->bbf('title_content_name',array($conf['name']));?></span>
		<span class="span-right">&nbsp;</span>
	</h3>
	<div class="sb-content">
		<div class="sb-list">		
		<p>
<?php 
	if (is_null($dbeg) === false):
?>
			<label id="lb-description" for="it-description"><?=$this->bbf('fm_description_cache',array($dbeg,$dencache));?></label>
<?php 
	endif; 
?>
		</p>
		
		<form action="#" method="get" accept-charset="utf-8">
			<?=$form->hidden(array('name' => 'act','value' => $act))?>
			<?=$form->hidden(array('name' => 'idconf','value' => $idconf))?>
			<?php
				echo	$form->select(array('desc' => $this->bbf('conf_axetype'),
								'name'		=> 'type',
							    'id'		=> 'it-conf-type',
							    'browse'	=> 'type',
				  				'labelid'	=> 'type',
							    'empty'		=> $this->bbf('fm_type-default'),
				    			'key'		=> false,
							    'bbf'		=> 'fm_type-opt',
							    'bbfopt'	=> array('argmode'	=> $listtype),
							    'selected'	=> $this->get_var('type')),
						      	$listtype);
			?>
		</form>
		
		<fieldset id="it-cache-generation-all" class="tab_cache_generation b-nodisplay">
			<legend><?=$this->bbf('cache_generation_processing');?></legend>
			<h1><?=$this->bbf('wait_during_traitment');?></h1>
			<p><h1 id="restitle-all"></h1></p>
			<div id="progressbarWrapper" style="height:10px; " class="ui-widget-default">
				<div id="resprogressbar-all" style="height:100%;"></div>
			</div>
			<p><div id="rescacheinfos-all"></div></p>
			<p><div id="reshttprequest-all"></div></p>
		</fieldset>
		<div id="it-cache-success-all" class="tab_cache_generation b-nodisplay">
			<h1><?=$this->bbf('cache_generation_success');?></h1>
			<p><h1 id="ressuccess-all"></h1></p>
		</div>
		
<?php 
	if (($type = $this->get_var('type')) === null):
		echo null;
	elseif(($list = $this->get_var('list'.$type)) === null
	|| $list === false
	|| ($nb = count($list)) === 0):
		echo $this->bbf('no_type_in_conf-opt',array($this->bbf('fm_type-opt',array($type))));
	else:
?>
		<div id="t-list-obj">
		<table cellspacing="0" cellpadding="0" border="0">
		<thead>
		<tr class="sb-top">
			<th class="th-left"><?=$this->bbf('col_cache_name')?></th>
			<th class="th-center"><?=$this->bbf('col_cache_status')?></th>
			<th class="th-right"><?=$this->bbf('col_action')?></th>
		</tr>
		</thead>
		<tbody id="disp">
<?php
		for ($i=0;$i<$nb;$i++):
			$ref = $list[$i];
			$mod = ($i % 2) + 1;
				
			$id = $ref['id'];
			$keyfile = $ref['keyfile'];
			$identity = $ref['identity'];
			
			$basecache = DWHO_PATH_CACHE_STATS.DWHO_SEP_DIR.'cache';
			$dir = $basecache.DWHO_SEP_DIR.
					$idconf.DWHO_SEP_DIR.
					$type.DWHO_SEP_DIR.
					$keyfile;
			
			if (($r = dwho_file::read_d($dir,'file',FILE_R_OK)) === false
			|| empty($r) === true):
			    $infoscache = $this->bbf('cache_noexist');
			else:
			    sort($r);
			    $nbfile = count($r);		    
			    $filefisrt = $r[0];
			    $filelast = $r[$nbfile-1];			    
			    $infoscache = $this->bbf('cache_exist-nbfile',array($nbfile));
		    endif;
?>
		<tr class="sb-content l-infos-<?=$mod?>on2"  title="<?=dwho_alttitle($identity)?>"
	    onmouseover="this.tmp = this.className; this.className = 'sb-content l-infos-over';"
	    onmouseout="this.className = this.tmp;">
			<td class="td-left"><?=$identity?></td>
			<td class="td-center">&nbsp;<?=$infoscache?></td>
			<td class="td-right">
				<form action="#" method="post" accept-charset="utf-8" 
					onsubmit="init_cache('<?=$keyfile?>');make_gener_cache('<?=$keyfile?>');return(false);">
					<!-- 		
					<input type="submit" name="genercache" id="bt-gcache-<?=$keyfile?>" value="<?=$this->bbf('bt-cache_generation',array($identity))?>" />
					 -->
					<div id="gcache-<?=$keyfile?>">					
						<input type="image" src="/img/site/button/restart.gif" title="<?=$this->bbf('bt-cache_generation',array($identity))?>" id="bt-gcache-<?=$keyfile?>" />
					</div>
				</form>
			</td>
		</tr>
		<tr id="cache-infos-<?=$keyfile?>" class="sb-content l-infos-<?=$mod?>on2 b-nodisplay cache-infos">
			<td colspan="3" class="td-single">
			<dl>
				<div id="it-cache-generation-<?=$keyfile?>" class="tab_cache_generation b-nodisplay">
					<h1><?=$this->bbf('wait_during_traitment');?></h1>
					<p><h1 id="restitle-<?=$keyfile?>"></h1></p>
					<div id="progressbarWrapper" style="height:10px; " class="ui-widget-default">
						<div id="resprogressbar-<?=$keyfile?>" style="height:100%;"></div>
					</div>
					<p><div id="rescacheinfos-<?=$keyfile?>"></div></p>
					<p><div id="reshttprequest-<?=$keyfile?>"></div></p>
				</div>
				<div id="it-cache-success-<?=$keyfile?>" class="tab_cache_generation b-nodisplay">
					<h1><?=$this->bbf('cache_generation_success');?></h1>
					<p><div id="ressuccess-<?=$keyfile?>"></div></p>
				</div>
			</dl>
			</td>
		</tr>
<?php 
		endfor;
?>
		</tbody>
		<tfoot>
		<tr>
			<td class="td-left" colspan="2">&nbsp;<?=$this->bbf('cache_generation_all')?></td>
			<td class="td-right">
				<form action="#" method="post" accept-charset="utf-8" 
					onsubmit="init_cache('all');make_gener_cache('all');return(false);">
					<!--
					<input type="submit" name="genercache" value="<?=$this->bbf('bt-cache_generation_all')?>" />	
					 -->
					<div id="gcache-all">					
						<input type="image" src="/img/site/button/restart.gif" title="<?=$this->bbf('bt-cache_generation_all')?>" id="bt-gcache-all" />				
					</div>
				</form>
			</td>
		</tr>
		</tfoot>
		</table>
		</div>
<?php 
	endif; 
?>
		</div>
	</div>
	<div class="sb-foot xspan">
		<span class="span-left">&nbsp;</span>
		<span class="span-center">&nbsp;</span>
		<span class="span-right">&nbsp;</span>
	</div>
</div>
<script type="text/javascript">	
dwho.dom.set_onload(function() {
	dwho.dom.add_event('change',
			   dwho_eid('it-conf-type'),
			   function(){this.form.submit();});
});
<?php 
if (($type = $this->get_var('type')) !== null
&& ($listmonth = $this->get_var('listmonth')) !== null) :
	
	$js_listmonth_firstday = array();
	$js_listmonth_lastday = array();
	$js_listmonth_timestamp = array();

	foreach ($listmonth as $month)
	{
		array_push($js_listmonth_firstday,$month['time']);
		array_push($js_listmonth_timestamp,date('Y-m-d',$month['time']));
		$lastday = mktime(23, 59, 59, date('m',$month['time']) + 1, 0, date('Y',$month['time']));
		array_push($js_listmonth_lastday,$lastday);
	}
?>
var listmonthtimestamp = new Array('<?=implode('\',\'',$js_listmonth_timestamp)?>');
var listmonthfirstday = new Array('<?=implode('\',\'',$js_listmonth_firstday)?>');
var listmonthlastday = new Array('<?=implode('\',\'',$js_listmonth_lastday)?>');
this.total = listmonthtimestamp.length;

function init_cache(idtype)
{
	this.counter = 0;
	this.start = this.start2 = (new Date).getTime();
	this.avg = new Array();
	
	dwho_eid('it-cache-success-all').style.display = 'none';
	
	if (idtype == 'all')
	{
		dwho_eid('it-cache-generation-all').style.display = 'block';
		dwho_eid('t-list-obj').style.display = 'none';
	}
	else
	{
		dwho_eid('it-cache-generation-'+idtype).style.display = 'block';
	}
}

function xivo_gener_cache(idconf,dbeg,dend,type,idtype)
{
	var idt=idtype;
	if (idtype == 'all') {idt = null;}
	new dwho.http('/statistics/ui.php/call_center/genercache/',
				{
					'callbackcomplete': function(httpRequest) 
						{
							make_gener_cache(idtype,httpRequest);
						},
					'method': 'get',
					'cache': false
				},
				{
					'idconf': idconf,
					'dbeg': dbeg,
					'dend': dend,
					'type': type,
					'idtype': idt
				},
				true);
	this.counter++;
}

function make_gener_cache(idtype,httpRequest)
{	
	var pct = ( (this.counter / this.total) * 100);
	
	if (this.counter >= this.total)
		return gener_on_success(idtype);

	var i = this.counter;
	var dprocess = listmonthtimestamp[i];
	var date = dprocess.split('-');
	var year = date[0];
	var day = date[2];
	var month = date[1];
	var humandate = year + '-' + month;// + '-' + day;	
	var diff = (new Date).getTime() - this.start;
	var diff2 = (new Date).getTime() - this.start2;
	this.avg.push(diff2);
	
	var objectProcessing = (idtype == 'all') ? '<?=$this->bbf("object_all")?>' : idtype;	
	var remaining_time = Math.round((average(this.avg) * (this.total - this.counter)) / 1000);
	
	infos = '';
	infos += '<p>';
	infos += '<b>' + humandate + '</b> <?=$this->bbf("in_progress")?>';
	infos += '........... ';
	infos += ' <?=$this->bbf("process_last_time_traitment")?> ' + Math.round(diff2 / 1000) + 's';
	infos += '</p>';
	infos += '<?=$this->bbf("process_total_time")?> ' + Math.round(diff / 1000) + 's';
	infos += '<br>';
	infos += '<?=$this->bbf("process_remaining_time")?> ' + remaining_time + 's';
	
	if (idtype == 'all')
	{
		if (httpRequest)
			dwho_eid('reshttprequest-all').innerHTML = nl2br(httpRequest.responseText); 
		dwho_eid('rescacheinfos-all').innerHTML = infos;
		//dwho_eid('restitle-all').innerHTML = '<?=$this->bbf('object_processing')?> ' + objectProcessing;
		$(function() {$("#resprogressbar-all").progressbar({value: pct});});
	}
	else
	{
		if (httpRequest)
			dwho_eid('reshttprequest-'+idtype).innerHTML = nl2br(httpRequest.responseText); 
	    dwho_eid('cache-infos-'+idtype).style.display = 'table-row';								   
		dwho_eid('gcache-'+idtype).innerHTML = '<?=$this->bbf('bt-wait-submit')?>'					   
		//dwho_eid('bt-gcache-'+idtype).disabled = true;
		//dwho_eid('bt-gcache-'+idtype).value = '<?=$this->bbf('bt-wait-submit')?>';
		dwho_eid('rescacheinfos-'+idtype).innerHTML = infos;
		//dwho_eid('restitle-'+idtyp).innerHTML = '<?=$this->bbf('object_processing')?> ' + objectProcessing;
		$(function() {$("#resprogressbar-"+idtype).progressbar({value: pct});});
	}

	xivo_gener_cache('<?=$idconf?>',listmonthfirstday[i],listmonthlastday[i],'<?=$type?>',idtype);

	this.start2 = (new Date).getTime();
}

function average(arr)
{
   var items = arr.length
   var sum = 0
   for (var i = 0; i < items;i++)
      sum += arr[i]
   return (sum/items)
}

function nl2br (str) 
{
	return str.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1 <br> $2');
}

function gener_on_success(idtype)
{
	if (idtype == 'all')
	{
<?php 
		$nb = count($list);
		for ($i=0;$i<$nb;$i++):
			$ref = $list[$i];
			$id = $ref['id'];
			$keyfile = $ref['keyfile'];
?>
		var res = '<img  src="/img/site/button/ok.gif" alt="<?=$this->bbf('bt-success-submit')?>" />';
		dwho_eid('gcache-<?=$keyfile?>').innerHTML = res;// + ' <?=$this->bbf('bt-success-submit')?>';
		//dwho_eid('bt-gcache-<?=$keyfile?>').disabled = true;
		//dwho_eid('bt-gcache-<?=$keyfile?>').value = '<?=$this->bbf('bt-success-submit')?>';
<?php 
		endfor;
?>
		var res = '<img  src="/img/site/button/ok.gif" alt="<?=$this->bbf('bt-success-submit')?>" />';
		dwho_eid('gcache-all').innerHTML = res;// + ' <?=$this->bbf('bt-success-submit')?>';
		//dwho_eid('bt-gcache-all').disabled = true;
		//dwho_eid('bt-gcache-all').value = '<?=$this->bbf('bt-success-submit')?>';
		dwho_eid('it-cache-generation-all').style.display = 'none'; 
		dwho_eid('it-cache-success-all').style.display = 'block';
		dwho_eid('t-list-obj').style.display = 'block';
		dwho_eid('t-list-obj').style.width = '100%';
	}
	else
	{
		var res = '<img  src="/img/site/button/ok.gif" alt="<?=$this->bbf('bt-success-submit')?>" />';
		dwho_eid('gcache-'+idtype).innerHTML = res;// + '<?=$this->bbf('bt-success-submit')?>';
		//dwho_eid('bt-gcache-'+idtype).value = '<?=$this->bbf('bt-success-submit')?>';
		dwho_eid('it-cache-generation-'+idtype).style.display = 'none';
		dwho_eid('it-cache-success-'+idtype).style.display = 'block';	
	    dwho_eid('cache-infos-'+idtype).style.display = 'none';	
	}
}
<?php 
endif;
?>
</script>