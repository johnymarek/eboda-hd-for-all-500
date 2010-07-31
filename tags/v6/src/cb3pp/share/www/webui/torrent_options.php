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
$globalinfo["torrentId"] = intval(_isset($_REQUEST,"t",0));
$globalinfo['page'] = intval(_isset($_REQUEST,'pg',0));
$globalinfo["btpdControl"] = new btpdControl($globalinfo["APP_HOME"]);

$stdGetFields = array(
				);

//Setup info
$setup = tr_sessionAccessor();
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
	if(isset($_REQUEST['action-delete']))
	{
		tr_torrentRemove($tor_IdList);
		Header("Location: ".$globalinfo["scriptIndex"]."?t=".$globalinfo["torrentId"]."&pg=".$globalinfo["page"]);
		exit;
	}
	else if(isset($_REQUEST['action-start'])) tr_torrentStart($tor_IdList);
	else if(isset($_REQUEST['action-stop']))  tr_torrentStop($tor_IdList);
	else if(isset($_REQUEST['action-save']))
	{
	}

	Header("Location: ".$globalinfo["scriptName"]."?t=".$globalinfo["torrentId"]."&pg=".$globalinfo["page"]);
	exit;
}

//###########################################################
// Interface
//###########################################################

// Free Space info
parseFreespace($globalinfo);

//if we requested torrent info
//Torrent info
$torrents = tr_torrentAccessor($stdGetFields, array($globalinfo["torrentId"]));
if( !$torrents) _error("Torrent not found or deleted");
if( !is_array($torrents) ) $torrents = array();

//Speed info
parseSpeeds($globalinfo,$torrents);

require_once('templates/torrent_options.tmpl.php');

exit(0);
?>