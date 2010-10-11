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
$globalinfo['refreshTime'] = 0;

$stdGetSetupFields = array(
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

if(isset($_REQUEST['action-save']))
{
	//Init
	$stdSetFields = array();

	//DL rate
	$stdSetFields["speed-limit-down"] = intval($_REQUEST["fDlRate"]);
	$stdSetFields["speed-limit-down-enabled"] = $stdSetFields["speed-limit-down"]?1:0;

	//UL rate
	$stdSetFields["speed-limit-up"] = intval($_REQUEST["fUlRate"]);
	$stdSetFields["speed-limit-up-enabled"] = $stdSetFields["speed-limit-up"]?1:0;

	//Port
	$stdSetFields["port"] = intval($_REQUEST["fPort"]);

	//Max connections
	$stdSetFields["peer-limit"] = intval($_REQUEST["fMaxConnections"]);

	//Max upload peers
	$stdSetFields["max-upload-peers"] = intval($_REQUEST["fMaxUlPeers"]);

	//Empty start
	$stdSetFields["empty-start"] = intval($_REQUEST["fEmptyStart"]);

	//Download path
	$stdSetFields["download-dir"] = trim(strip_tags($_REQUEST["fDownloadDir"]));
	if( empty($stdSetFields["download-dir"]) || !file_exists($stdSetFields["download-dir"]) || !is_dir($stdSetFields["download-dir"]) )
		$stdSetFields["download-dir"] = $session["download-dir"];

	//Sort order
	$stdSetFields["sort-order"] = intval($_REQUEST["sortOrder"]);

	$result = tr_sessionMutator($stdSetFields);

	Header("Location: ".$globalinfo["scriptName"]."?t=".$globalinfo["torrentId"]);
	exit;
}

//###########################################################
// Interface
//###########################################################

// Free Space info
parseFreespace($globalinfo);

//Speed info
parseSpeeds($globalinfo,$torrents);

require_once('templates/setup.tmpl.php');
exit(0);
?>