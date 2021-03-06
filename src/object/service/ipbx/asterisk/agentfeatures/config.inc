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

$array['element'] = array();

$array['element']['numgroup'] = array();
$array['element']['numgroup']['default'] = '';

$array['element']['firstname'] = array();
$array['element']['firstname']['default'] = '';

$array['element']['lastname'] = array();
$array['element']['lastname']['default'] = '';

$array['element']['number'] = array();
$array['element']['number']['default'] = '';

$array['element']['passwd'] = array();
$array['element']['passwd']['default'] = '';

$array['element']['context'] = array();
$array['element']['context']['default'] = '';

$array['element']['language'] = array();
$array['element']['language']['value'] = dwho_i18n::get_supported_language_list();
$array['element']['language']['default'] = '';

$array['element']['autologoff'] = array();
$array['element']['autologoff']['value'] = array(0,5,10,15,20,25,30,35,40,45,50,55,60);
$array['element']['autologoff']['default'] = 0;
$array['element']['autologoff']['setdef'] = true;

$array['element']['description'] = array();
$array['element']['description']['default'] = '';

$array['element']['preprocess_subroutine'] = array();
$array['element']['preprocess_subroutine']['default'] = '';
$array['element']['preprocess_subroutine']['null'] = true;

$array['filter'] = array();
$array['filter']['numgroup'] = array('cast' => 'uint','between' => array(1,63));
$array['filter']['number'] = array('regexp' => '/^[0-9\*#]+$/','minlen' => 1,'maxlen' => 40);
$array['filter']['passwd'] = array('set' => false,'chk' => 2,'regexp' => '/^[0-9\*#]+$/','minlen' => 1,'maxlen' => 40);
$array['filter']['firstname'] = array('set' => false,'chk' => 2,'maxlen' => 128,'cast' => 'sgraph');
$array['filter']['lastname'] = array('set' => false,'chk' => 2,'maxlen' => 128,'cast' => 'sgraph');
$array['filter']['context'] = array('callback' => 'xivo_service_asterisk::chk_context');
$array['filter']['language'] = array('set' => false,'chk' => 2,'maxlen' => 5,'key' => dwho_i18n::get_supported_language_list());
$array['filter']['autologoff'] = array('cast' => 'uint','between' => array(0,60,5));
$array['filter']['description'] = array('set' => false,'chk' => 2,'maxlen' => 1000,'cast' => 'sgraph_crlf_tab','eol' => true);
$array['filter']['preprocess_subroutine'] = array('set' => false,'chk' => 2,'callback' => 'xivo_service_asterisk::chk_context');

?>
