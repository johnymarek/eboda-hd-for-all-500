<?php

/***************************************************************

	This file is part of BTPD Web/Gaya GUI
	Copyright: Shurup <shurup@gmail.com>

	BTPD Web/Gaya GUI is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	BTPD Web/Gaya GUI is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with BTPD Web/Gaya GUI; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA


****************************************************************/

require_once("class.BEncodeLib.php");
require_once("class.btpdControl.php");
require_once("utils.php");

//###########################################################
// Init
//###########################################################

$globalinfo = getStartupconfig();
$globalinfo['page'] = intval(_isset($_REQUEST,'pg',0));
$globalinfo["btpdControl"] = new btpdControl($globalinfo["APP_HOME"]);

$stdGetSetupFields = array();
$stdGetFields = array(
				);

//Setup info
$setup = tr_sessionAccessor($stdGetSetupFields);
$session = parseSession($setup);

//Stats
/*
$globalinfo['stats'] = tr_sessionStats();
*/

//###########################################################
// Actions
//###########################################################

if( isset($_REQUEST['list']) ) // Received a command
{
	$tor_IdList = parse_torrent_list($_REQUEST['list']);
	if(isset($_REQUEST['action-delete']))     tr_torrentRemove($tor_IdList);
	else if(isset($_REQUEST['action-start'])) tr_torrentStart($tor_IdList);
	else if(isset($_REQUEST['action-stop']))  tr_torrentStop($tor_IdList);
	else if(isset($_REQUEST['action-save']))
	{
	}

	Header("Location: ".$globalinfo["scriptName"]."?t=".$globalinfo["torrentId"]."&pg=".$globalinfo["page"]);
	exit;
}
else if( isset($_REQUEST['action-delete-all']) )
{
	tr_torrentRemoveAll();
	Header("Location: ".$globalinfo["scriptName"]."?t=".$globalinfo["torrentId"]."&pg=".$globalinfo["page"]);
	exit;
}
else if( isset($_REQUEST['action-start-all']) )
{
	tr_torrentStartAll();
	Header("Location: ".$globalinfo["scriptName"]."?t=".$globalinfo["torrentId"]."&pg=".$globalinfo["page"]);
	exit;
}
else if( isset($_REQUEST['action-stop-all']) )
{
	tr_torrentStopAll();
	Header("Location: ".$globalinfo["scriptName"]."?t=".$globalinfo["torrentId"]."&pg=".$globalinfo["page"]);
	exit;
}
else if(isset($_REQUEST['action-upload']))
{
	/**
	  * Basis for upload-action is a code from PHP BTPD Control panel.
	  */
	/**
	  * class.btpdWebControl.php
	  * @package PHP BTPD Control panel
	  */
	/**
	  * @author Volkov Sergey
	  * @version 0.1
	  * @package PHP BTPD Control panel
	  */

	if( !is_uploaded_file($_FILES['fFile']['tmp_name']) ) _error("Cannot find uploaded file.");
	$torrent_content = file_get_contents($_FILES['fFile']['tmp_name']);
	$bencoder = new BEncodeLib();
	$torrent_info = $bencoder->bdecode($torrent_content);
	if( !is_array($torrent_info["info"]) ) _error("Invalid torrent file - 'info' section not found.");

	$torrent_name = $torrent_info["info"]["name"];

	//if torrent is one file only (not set "files" array) then download directly to folder
	//otherwise make subfolder and download there
	if( isset($torrent_info["info"]["files"]) && count($torrent_info["info"]["files"]) )
		$directory = $session["download-dir"]."/".$torrent_name;
	else
		$directory = $session["download-dir"];

	@mkdir($directory);
	if( !is_dir($directory) ) _error("Unable create download directory.");

	//@symlink($directory, $session["download-dir"]."/".$torent_name);
	$result = $globalinfo["btpdControl"]->btpd_add_torrent($torrent_content, $directory, $torrent_info["info"]["name"]);
	if( $result['code'] != 0 ) _error("Error occured: ".$globalinfo["btpdControl"]->get_btpd_error($result['code']));

	if( $_REQUEST["fAutoStart"] == 1 )
	{
		$result = $globalinfo["btpdControl"]->btpd_start_torrent($result['num']);
		if( $resilt['code'] != 0 ) _error("Error occured: ".$globalinfo["btpdControl"]->get_btpd_error($result['code']));
	}

	Header("Location: ".$globalinfo["scriptName"]."?t=".$globalinfo["torrentId"]."&pg=".$globalinfo["page"]);
	exit;
}

//###########################################################
// Interface
//###########################################################

// Free Space info
parseFreespace($globalinfo);

//Torrent info
$torrents = tr_torrentAccessor($stdGetFields);
if( !is_array($torrents) ) $torrents = array();

//##############################################
//sort by status and name
//##############################################
switch( $session["sort-order"] )
{
	case 4: $arr_order = array(0=>0,2=>1,4=>2,3=>3,1=>4); break;
	case 3: $arr_order = array(0=>0,2=>1,1=>2,3=>3,4=>4); break;
	case 2: $arr_order = array(4=>0,1=>1,3=>2,0=>3,2=>4); break;
	case 1: $arr_order = array(3=>0,1=>1,0=>2,2=>3,4=>4); break;
	case 0: default: $arr_order = array(3=>0,1=>1,4=>2,0=>3,2=>4); break;
}
function sortTorrents($a, $b)
{
	global $arr_order;
	if( $arr_order[$a[btpdControl::STATE]] == $arr_order[$b[btpdControl::STATE]] ) return strcmp($a[btpdControl::NAME], $b[btpdControl::NAME]);
    return ($arr_order[$a[btpdControl::STATE]] < $arr_order[$b[btpdControl::STATE]]) ? -1 : 1;
}
usort($torrents, 'sortTorrents');
//##############################################
//##############################################

//Pagination
$globalinfo['actTor']   = count($torrents);
$globalinfo['fromTor']  = $globalinfo['page'] * $globalinfo['perPage'] + 1;
if( $globalinfo['fromTor'] > $globalinfo['actTor'] ) $globalinfo['fromTor'] = $globalinfo['page'] = 0;
$globalinfo['toTor']    = $globalinfo['page'] * $globalinfo['perPage'] + $globalinfo['perPage'];
$globalinfo['nextpage'] = min(ceil($globalinfo['actTor']/$globalinfo['perPage']), $globalinfo['page']+1);
$globalinfo['prevpage'] = max(0, $globalinfo['page']-1);

if( $globalinfo['toTor'] > $globalinfo['actTor'] )  $globalinfo['toTor'] = $globalinfo['actTor'];
if( $globalinfo['toTor'] >= $globalinfo['actTor'] ) $globalinfo['nextpage'] = 0;

$globalinfo['torrenOfset'] = $globalinfo['page']?$globalinfo['page'] * $globalinfo['perPage']:0;

//Speed info
parseSpeeds($globalinfo,$torrents);

require_once('templates/index.tmpl.php');

exit(0);
?>