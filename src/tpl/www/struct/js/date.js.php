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

?>

var xivo_date_prev = '<?=$this->escape($this->bbf('fm_bt-previous'));?>';
var xivo_date_next = '<?=$this->escape($this->bbf('fm_bt-next'));?>';

var xivo_date_month = [
	'<?=$this->escape($this->bbf('date_month','january'));?>',
	'<?=$this->escape($this->bbf('date_month','february'));?>',
	'<?=$this->escape($this->bbf('date_month','march'));?>',
	'<?=$this->escape($this->bbf('date_month','april'));?>',
	'<?=$this->escape($this->bbf('date_month','may'));?>',
	'<?=$this->escape($this->bbf('date_month','jun'));?>',
	'<?=$this->escape($this->bbf('date_month','july'));?>',
	'<?=$this->escape($this->bbf('date_month','august'));?>',
	'<?=$this->escape($this->bbf('date_month','september'));?>',
	'<?=$this->escape($this->bbf('date_month','october'));?>',
	'<?=$this->escape($this->bbf('date_month','november'));?>',
	'<?=$this->escape($this->bbf('date_month','december'));?>'];

var xivo_date_month_short = [
	'<?=substr($this->escape($this->bbf('date_month','january')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_month','february')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_month','march')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_month','april')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_month','may')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_month','jun')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_month','july')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_month','august')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_month','september')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_month','october')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_month','november')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_month','december')),0,3);?>'];

var xivo_date_day = [
	'<?=$this->escape($this->bbf('date_day','sunday'));?>',
	'<?=$this->escape($this->bbf('date_day','monday'));?>',
	'<?=$this->escape($this->bbf('date_day','tuesday'));?>',
	'<?=$this->escape($this->bbf('date_day','wesnesday'));?>',
	'<?=$this->escape($this->bbf('date_day','thursday'));?>',
	'<?=$this->escape($this->bbf('date_day','friday'));?>',
	'<?=$this->escape($this->bbf('date_day','saturday'));?>'];

var xivo_date_day_min = [
	'<?=substr($this->escape($this->bbf('date_day','sunday')),0,2);?>',
	'<?=substr($this->escape($this->bbf('date_day','monday')),0,2);?>',
	'<?=substr($this->escape($this->bbf('date_day','tuesday')),0,2);?>',
	'<?=substr($this->escape($this->bbf('date_day','wesnesday')),0,2);?>',
	'<?=substr($this->escape($this->bbf('date_day','thursday')),0,2);?>',
	'<?=substr($this->escape($this->bbf('date_day','friday')),0,2);?>',
	'<?=substr($this->escape($this->bbf('date_day','saturday')),0,2);?>'];

var xivo_date_day_short = [
	'<?=substr($this->escape($this->bbf('date_day','sunday')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_day','monday')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_day','tuesday')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_day','wesnesday')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_day','thursday')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_day','friday')),0,3);?>',
	'<?=substr($this->escape($this->bbf('date_day','saturday')),0,3);?>'];
	