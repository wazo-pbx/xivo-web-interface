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

$array = array();

$array['type'] = array();
$array['type']['user'] = array();
$array['type']['user']['name'] = 'user';
$array['type']['user']['destination'] = true;
$array['type']['user']['supervisable'] = true;

$array['type']['group'] = array();
$array['type']['group']['name'] = 'group';
$array['type']['group']['destination'] = true;
$array['type']['group']['supervisable'] = false;

$array['type']['queue'] = array();
$array['type']['queue']['name'] = 'queue';
$array['type']['queue']['destination'] = true;
$array['type']['queue']['supervisable'] = false;

$array['type']['meetme'] = array();
$array['type']['meetme']['name'] = 'meetme';
$array['type']['meetme']['destination'] = true;
$array['type']['meetme']['supervisable'] = true;

$array['type']['custom'] = array();
$array['type']['custom']['name'] = 'custom';
$array['type']['custom']['destination'] = true;
$array['type']['custom']['supervisable'] = true;

$array['type']['featuremap-automixmon'] = array();
$array['type']['featuremap-automixmon']['category'] = 'extension-general';
$array['type']['featuremap-automixmon']['name'] = 'featuremap-automixmon';
$array['type']['featuremap-automixmon']['extension'] = true;

$array['type']['extenfeatures-phonestatus'] = array();
$array['type']['extenfeatures-phonestatus']['category'] = 'extension-general';
$array['type']['extenfeatures-phonestatus']['name'] = 'extenfeatures-phonestatus';
$array['type']['extenfeatures-phonestatus']['extension'] = true;

$array['type']['extenfeatures-recsnd'] = array();
$array['type']['extenfeatures-recsnd']['category'] = 'extension-general';
$array['type']['extenfeatures-recsnd']['name'] = 'extenfeatures-recsnd';
$array['type']['extenfeatures-recsnd']['extension'] = true;

$array['type']['extenfeatures-callrecord'] = array();
$array['type']['extenfeatures-callrecord']['category'] = 'extension-general';
$array['type']['extenfeatures-callrecord']['name'] = 'extenfeatures-callrecord';
$array['type']['extenfeatures-callrecord']['extension'] = true;
$array['type']['extenfeatures-callrecord']['supervisable'] = true;
$array['type']['extenfeatures-callrecord']['progfunckey'] = true;

$array['type']['extenfeatures-incallfilter'] = array();
$array['type']['extenfeatures-incallfilter']['category'] = 'extension-general';
$array['type']['extenfeatures-incallfilter']['name'] = 'extenfeatures-incallfilter';
$array['type']['extenfeatures-incallfilter']['extension'] = true;
$array['type']['extenfeatures-incallfilter']['supervisable'] = true;
$array['type']['extenfeatures-incallfilter']['progfunckey'] = true;

$array['type']['extenfeatures-enablednd'] = array();
$array['type']['extenfeatures-enablednd']['category'] = 'extension-general';
$array['type']['extenfeatures-enablednd']['name'] = 'extenfeatures-enablednd';
$array['type']['extenfeatures-enablednd']['extension'] = true;
$array['type']['extenfeatures-enablednd']['supervisable'] = true;
$array['type']['extenfeatures-enablednd']['progfunckey'] = true;

$array['type']['extenfeatures-pickup'] = array();
$array['type']['extenfeatures-pickup']['category'] = 'extension-general';
$array['type']['extenfeatures-pickup']['name'] = 'extenfeatures-pickup';
$array['type']['extenfeatures-pickup']['extension'] = true;

$array['type']['extenfeatures-calllistening'] = array();
$array['type']['extenfeatures-calllistening']['category'] = 'extension-general';
$array['type']['extenfeatures-calllistening']['name'] = 'extenfeatures-calllistening';
$array['type']['extenfeatures-calllistening']['extension'] = true;

$array['type']['extenfeatures-directoryaccess'] = array();
$array['type']['extenfeatures-directoryaccess']['category'] = 'extension-general';
$array['type']['extenfeatures-directoryaccess']['name'] = 'extenfeatures-directoryaccess';
$array['type']['extenfeatures-directoryaccess']['extension'] = true;

$array['type']['extenfeatures-bsfilter'] = array();
$array['type']['extenfeatures-bsfilter']['category'] = 'extension-general';
$array['type']['extenfeatures-bsfilter']['name'] = 'extenfeatures-bsfilter';
$array['type']['extenfeatures-bsfilter']['extension'] = false;
$array['type']['extenfeatures-bsfilter']['supervisable'] = true;

$array['type']['featuremap-blindxfer'] = array();
$array['type']['featuremap-blindxfer']['category'] = 'extension-transfers';
$array['type']['featuremap-blindxfer']['name'] = 'featuremap-blindxfer';
$array['type']['featuremap-blindxfer']['extension'] = true;

$array['type']['featuremap-atxfer'] = array();
$array['type']['featuremap-atxfer']['category'] = 'extension-transfers';
$array['type']['featuremap-atxfer']['name'] = 'featuremap-atxfer';
$array['type']['featuremap-atxfer']['extension'] = true;

$array['type']['extenfeatures-fwdundoall'] = array();
$array['type']['extenfeatures-fwdundoall']['category'] = 'extension-forwards';
$array['type']['extenfeatures-fwdundoall']['name'] = 'extenfeatures-fwdundoall';
$array['type']['extenfeatures-fwdundoall']['extension'] = true;

$array['type']['extenfeatures-fwdrna'] = array();
$array['type']['extenfeatures-fwdrna']['category'] = 'extension-forwards';
$array['type']['extenfeatures-fwdrna']['name'] = 'extenfeatures-fwdrna';
$array['type']['extenfeatures-fwdrna']['extension'] = true;
$array['type']['extenfeatures-fwdrna']['destination'] = true;
$array['type']['extenfeatures-fwdrna']['supervisable'] = true;
$array['type']['extenfeatures-fwdrna']['progfunckey'] = true;

$array['type']['extenfeatures-fwdbusy'] = array();
$array['type']['extenfeatures-fwdbusy']['category'] = 'extension-forwards';
$array['type']['extenfeatures-fwdbusy']['name'] = 'extenfeatures-fwdbusy';
$array['type']['extenfeatures-fwdbusy']['extension'] = true;
$array['type']['extenfeatures-fwdbusy']['destination'] = true;
$array['type']['extenfeatures-fwdbusy']['supervisable'] = true;
$array['type']['extenfeatures-fwdbusy']['progfunckey'] = true;

$array['type']['extenfeatures-fwdunc'] = array();
$array['type']['extenfeatures-fwdunc']['category'] = 'extension-forwards';
$array['type']['extenfeatures-fwdunc']['name'] = 'extenfeatures-fwdunc';
$array['type']['extenfeatures-fwdunc']['extension'] = true;
$array['type']['extenfeatures-fwdunc']['destination'] = true;
$array['type']['extenfeatures-fwdunc']['supervisable'] = true;
$array['type']['extenfeatures-fwdunc']['progfunckey'] = true;

$array['type']['extenfeatures-enablevm'] = array();
$array['type']['extenfeatures-enablevm']['category'] = 'extension-voicemail';
$array['type']['extenfeatures-enablevm']['name'] = 'extenfeatures-enablevm';
$array['type']['extenfeatures-enablevm']['extension'] = true;
$array['type']['extenfeatures-enablevm']['supervisable'] = true;
$array['type']['extenfeatures-enablevm']['progfunckey'] = true;

$array['type']['extenfeatures-vmusermsg'] = array();
$array['type']['extenfeatures-vmusermsg']['category'] = 'extension-voicemail';
$array['type']['extenfeatures-vmusermsg']['name'] = 'extenfeatures-vmusermsg';
$array['type']['extenfeatures-vmusermsg']['extension'] = true;

$array['type']['extenfeatures-vmuserpurge'] = array();
$array['type']['extenfeatures-vmuserpurge']['category'] = 'extension-voicemail';
$array['type']['extenfeatures-vmuserpurge']['name'] = 'extenfeatures-vmuserpurge';
$array['type']['extenfeatures-vmuserpurge']['extension'] = true;

$array['type']['extenfeatures-agentstaticlogtoggle'] = array();
$array['type']['extenfeatures-agentstaticlogtoggle']['category'] = 'extension-agent';
$array['type']['extenfeatures-agentstaticlogtoggle']['name'] = 'extenfeatures-agentstaticlogtoggle';
$array['type']['extenfeatures-agentstaticlogtoggle']['extension'] = false;
$array['type']['extenfeatures-agentstaticlogtoggle']['supervisable'] = true;
$array['type']['extenfeatures-agentstaticlogtoggle']['destination'] = true;
$array['type']['extenfeatures-agentstaticlogtoggle']['progfunckey'] = true;

$array['type']['extenfeatures-agentstaticlogin'] = array();
$array['type']['extenfeatures-agentstaticlogin']['category'] = 'extension-agent';
$array['type']['extenfeatures-agentstaticlogin']['name'] = 'extenfeatures-agentstaticlogin';
$array['type']['extenfeatures-agentstaticlogin']['extension'] = false;
$array['type']['extenfeatures-agentstaticlogin']['supervisable'] = true;
$array['type']['extenfeatures-agentstaticlogin']['destination'] = true;
$array['type']['extenfeatures-agentstaticlogin']['progfunckey'] = true;

$array['type']['extenfeatures-agentstaticlogoff'] = array();
$array['type']['extenfeatures-agentstaticlogoff']['category'] = 'extension-agent';
$array['type']['extenfeatures-agentstaticlogoff']['name'] = 'extenfeatures-agentstaticlogoff';
$array['type']['extenfeatures-agentstaticlogoff']['extension'] = false;
$array['type']['extenfeatures-agentstaticlogoff']['supervisable'] = true;
$array['type']['extenfeatures-agentstaticlogoff']['destination'] = true;
$array['type']['extenfeatures-agentstaticlogoff']['progfunckey'] = true;

$array['type']['generalfeatures-parkext'] = array();
$array['type']['generalfeatures-parkext']['category'] = 'extension-parking';
$array['type']['generalfeatures-parkext']['name'] = 'generalfeatures-parkext';
$array['type']['generalfeatures-parkext']['extension'] = true;

$array['type']['generalfeatures-parkpos'] = array();
$array['type']['generalfeatures-parkpos']['category'] = 'extension-parking';
$array['type']['generalfeatures-parkpos']['name'] = 'generalfeatures-parkpos';
$array['type']['generalfeatures-parkpos']['destination'] = true;
$array['type']['generalfeatures-parkpos']['supervisable'] = true;
$array['type']['generalfeatures-parkpos']['extension'] = true;

$array['type']['extenfeatures-paging'] = array();
$array['type']['extenfeatures-paging']['destination'] = true;
$array['type']['extenfeatures-paging']['name'] = 'extenfeatures-paging';
$array['type']['extenfeatures-paging']['category'] = 'extension-paging';

$array['element'] = array();

$array['element']['iduserfeatures'] = array();
$array['element']['iduserfeatures']['default'] = 0;
$array['element']['iduserfeatures']['forcedef'] = true;

$array['element']['fknum'] = array();
$array['element']['fknum']['value'] = range(1,250);
$array['element']['fknum']['default'] = 1;

$array['element']['exten'] = array();
$array['element']['exten']['default'] = '';
$array['element']['exten']['null'] = true;

$array['element']['typeextenumbers'] = array();
$array['element']['typeextenumbers']['value'] = array('extenfeatures','featuremap','generalfeatures');
$array['element']['typeextenumbers']['default'] = '';
$array['element']['typeextenumbers']['null'] = true;

$array['element']['typevalextenumbers'] = array();
$array['element']['typevalextenumbers']['default'] = '';
$array['element']['typevalextenumbers']['null'] = true;

$array['element']['typeextenumbersright'] = array();
$array['element']['typeextenumbersright']['value'] = array('agent',
							   'group',
							   'meetme',
							   'queue',
							   'user',
							   'paging');
$array['element']['typeextenumbersright']['default'] = '';
$array['element']['typeextenumbersright']['null'] = true;

$array['element']['typevalextenumbersright'] = array();
$array['element']['typevalextenumbersright']['default'] = '';
$array['element']['typevalextenumbersright']['null'] = true;

$array['element']['label'] = array();
$array['element']['label']['default'] = '';
$array['element']['label']['null'] = true;

$array['element']['supervision'] = array();
$array['element']['supervision']['value'] = array(0,1);
$array['element']['supervision']['default'] = 0;
$array['element']['supervision']['set'] = true;

$array['element']['progfunckey'] = array();
$array['element']['progfunckey']['value'] = array(0,1);
$array['element']['progfunckey']['default'] = 0;
$array['element']['progfunckey']['set'] = true;

$array['filter'] = array();
$array['filter']['iduserfeatures'] = array('cast' => 'ulongint');
$array['filter']['fknum'] = array('cast' => 'uint','between' => array(1,250));
$array['filter']['exten'] = array('set' => false,'chk' => 2,'maxlen' => 40,'regexp' => '/^[0-9\*#]+$/');
$array['filter']['typeextenumbers'] = array('set' => false,'chk' => 2,'key' => array('extenfeatures','featuremap','generalfeatures'));
$array['filter']['typevalextenumbers'] = array('set' => false,'chk' => 2,'maxlen' => 255,'cast' => 'sgraph');
$array['filter']['typeextenumbersright'] = array(
				'set'	=> false,
				'chk'	=> 2,
				'key'	=> $array['element']['typeextenumbersright']['value']);
$array['filter']['typevalextenumbersright'] = array('set' => false,'chk' => 2,'maxlen' => 255,'cast' => 'sgraph');
$array['filter']['label'] = array('set' => false,'chk' => 2,'maxlen' => 32,'cast' => 'sgraph');
$array['filter']['supervision'] = array('bool' => true);
$array['filter']['progfunckey'] = array('bool' => true);

?>
