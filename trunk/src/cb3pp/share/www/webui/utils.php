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

function _error($_msg)
{
    global $globalinfo;

    $globalinfo["error_message"] = $_msg;
    require_once('templates/error.tmpl.php');
    exit(0);
}
/*
function parseTorrentFiles($_torrent)
{
    $files = array();

    if( is_array($_torrent["files"]) ) $files = $_torrent["files"];

    foreach($files AS $key => $file)
    {
        $files[$key]["substrName"] = basename($files[$key]["name"]);

        $files[$key]["totalSize"]  = file_getLength($file)/1024;
        $files[$key]["totalSize"]  = $files[$key]["totalSize"]>999?number_format($files[$key]["totalSize"]/1024,1)."MB":number_format($files[$key]["totalSize"],1)."KB";

        $files[$key]["completed"]  = file_getBytesCompleted($file)/1024;
        $files[$key]["completed"]  = $files[$key]["completed"]>999?number_format($files[$key]["completed"]/1024,1)."MB":number_format($files[$key]["completed"],1)."KB";

        $files[$key]["wanted"]     = $_torrent["wanted"][$key];
        $files[$key]["priorities"] = $_torrent["priorities"][$key];
        $files[$key]["priorityName"] = file_getPriorityName($files[$key]["priorities"], $files[$key]["wanted"]);

        $files[$key]["percCompleted"] = round(file_getBytesCompleted($file)/file_getLength($file) * 100);
    }

    return $files;
}

function parseTorrentPeers($_torrent)
{
    $peers = array();

    if( is_array($_torrent["peers"]) ) $peers = $_torrent["peers"];

    foreach($peers AS $key => $peer)
    {
        $peers[$key]["rx"] = number_format(_isset($peer, 'rateToClient')/1024,1);
        $peers[$key]["tx"] = number_format(_isset($peer, 'rateToPeer')/1024,1);
    }

    return $peers;
}

function file_getPriorityName($p, $w){
    if( !$w ) return "skip";
    switch($p)
    {
        case 1: return "high"; break;
        case -1: return "low"; break;
        case 0: default: return "normal"; break;
    }
}

function file_getBytesCompleted($t) {
    return _isset($t, 'bytesCompleted', 0);
}

function file_getLength($t) {
    return _isset($t, 'length', 0);
}
*/
function getStartupconfig()
{
    $globalinfo = array(
        'APP_NAME'      => 'BTPD',
        'APP_INI'       => '/usr/local/etc/root/btpd.ini',
        'APP_RESTART'   => '/cb3pp/etc/init.d/S99btpd15 restart',
        'APP_HOME'      => '/usr/local/etc/root/.btpd',
        'scriptName'    => basename($_SERVER["PHP_SELF"]),
        'scriptSetup'   => 'setup.php',
        'scriptIndex'   => 'index.php',
        'scriptOptions' => 'torrent_options.php',
        'scriptFiles'   => 'torrent_files.php',
        'scriptPeers'   => 'torrent_peers.php',
        'imgPath'       => 'file:///opt/sybhttpd/localhost.images/hd',
        'perPage'       => 4,
        'perPage2'      => 8,
        'totalup'       => 0,
        'totaldown'     => 0,
        'torrentId'     => 0,
        'refreshTime'   => 60,
        'page'          => 0,
        'page2'         => 0,
        'isGaya'        => is_numeric(stripos($_SERVER["HTTP_USER_AGENT"], "Syabas"))?true:false
        );

    if( !$globalinfo['isGaya'] )
    {
        $globalinfo['imgPath']  = 'images';
        $globalinfo['perPage']  = 20;
        $globalinfo['perPage2'] = 40;
    }

    return $globalinfo;
}

function parseSession($_setup)
{
    global $globalinfo;

    $arrTmp = file_exists($globalinfo["APP_INI"])?parse_ini_file($globalinfo["APP_INI"]):array();

    $session = array(
                "download-dir"     => _isset($arrTmp,"DownloadDir","/share/Download"),
                "peer-limit"       => _isset($arrTmp,"MaxPeers",0),
                "port"             => _isset($arrTmp,"Port",8881),
                "max-upload-peers" => _isset($arrTmp,"MaxUploads",-1),
                "empty-start"      => _isset($arrTmp,"EmptyStart",0),
                "speed-limit-down" => _isset($arrTmp,"DownloadLimit",0),
                "speed-limit-up"   => _isset($arrTmp,"UploadLimit",0),
                "sort-order"       => _isset($arrTmp,"SortOrder",0),
                "version"          => "0.15",
                "ini"              => $arrTmp
        );

    return $session;
}

function parseTorrent($_torrent, $_extended = false)
{
    $torrent = array(
        'id'            => tor_getId($_torrent),
        'name'          => tor_getName($_torrent),
        'status'        => tor_getStatus($_torrent),
        'totalSize'     => number_format(tor_getTotalSize($_torrent)/1024/1024,1),
        'completed'     => number_format(tor_getCompleted($_torrent)/1024/1024,1),
        'percCompleted' => number_format((tor_getCompleted($_torrent)/tor_getTotalSize($_torrent))*100,1),
        'rx'            => number_format(tor_getDownloadRate($_torrent)/1024,1),
        'tx'            => number_format(tor_getUploadRate($_torrent)/1024,1),
        //'peers'         => tor_getPeerCount($_torrent),
        'peers'         => tor_getConnectedPeerCount($_torrent),
        //'avail'         => number_format(tor_getAvailable($_torrent),1),
        'ratio'         => number_format(tor_getRatio($_torrent), 2),
        'eta'           => tor_getEta($_torrent),
        'selected'      => false
        );

    if( $_extended )
    {
        $torrent['peersSendingToUs']   = tor_getSendingPeerCount($_torrent);
        $torrent['peersGettingFromUs'] = tor_getGettingPeerCount($_torrent);
        $torrent['maxConnectedPeers']  = tor_getMaxPeerCount($_torrent);
        $torrent['speed-limit-down']   = tor_speedLimitDown($_torrent);
        $torrent['speed-limit-up']     = tor_speedLimitUp($_torrent);
        $torrent['errors']             = _isset($_torrent,btpdControl::TRERR,0);
        $torrent['piecesDownloaded']   = _isset($_torrent,btpdControl::PCGOT,0);
        $torrent['piecesTotal']        = _isset($_torrent, btpdControl::PCCOUNT,0);
        $torrent['piecesSeen']         = _isset($_torrent, btpdControl::PCSEEN,0);
        $torrent['avail']              = number_format(tor_getAvailable($_torrent),1);

        $torrent['hash']               = unpack('H*', _isset($_torrent,btpdControl::IHASH,0));
        $torrent['hash']               = $torrent['hash'][1];
    }

    $torrent['progress_done_width']    = ceil($torrent['percCompleted']);
    $torrent['progress_notdone_width'] = 100 - $torrent['progress_done_width'];

    if( $torrent['progress_done_width'] >= 100 )
    {
        $torrent['progress_left_border']   = 'progressGreen2LeftBorder.png';
        $torrent['progress_right_border']  = 'progressGreen2RightBorder.png';
        $torrent['progress_done_image']    = 'progressGreen2.png';
        $torrent['progress_notdone_image'] = 'progressLightGrey.png';
    }
    else
    {
        $torrent['progress_left_border']   = 'progressBlue2LeftBorder.png';
        $torrent['progress_right_border']  = 'progressDarkBlueRightBorder.png';
        $torrent['progress_done_image']    = 'progressBlue2.png';
        $torrent['progress_notdone_image'] = 'progressDarkBlue.png';
    }

    switch( $torrent['status'] )
    {
        case 'Downloading':
            $torrent['iconStatus'] = 'iconDownload.png';
            break;
        case 'Seeding':
            $torrent['iconStatus'] = 'iconUpload.png';
            break;
        case 'Stopped':
            $torrent['iconStatus'] = $torrent['progress_done_width'] >= 100 ? 'iconCompleted.png' : 'iconStopped.png';
            break;
        default:
            $torrent['iconStatus'] = 'iconUnknown.png';
            break;
    }

    return $torrent;
}

function parseSpeeds(&$_arr,&$torrents)
{
    if( !is_array($torrents) ) return;
    foreach( $torrents AS $oneTorrent )
    {
        $_arr['totaldown'] += tor_getDownloadRate($oneTorrent);
        $_arr['totalup'] += tor_getUploadRate($oneTorrent);
    }
}

function parseFreespace(&$_arr)
{
    exec(' df -h | grep HARD_DISK | awk \'{ print $4":"$5}\'', $output);
    list($_arr['freespace'], $_arr['usedspaceproc']) = explode(':', implode('',$output));
    $_arr['freespace'] = trim($_arr['freespace']);
    $_arr['usedspaceproc'] = 100 - intval(substr(trim($_arr['usedspaceproc']),0,-1));
}

function duration($seconds) {

    $years = floor($seconds/60/60/24/365);
    $days = floor($seconds/60/60/24)%365;
    $hours = $seconds/60/60%24;
    $mins = $seconds/60%60;
    $secs = $seconds%60;

        $duration='';

        if($years>0) {
            $duration .= $years." years ".$days." days";
        } else {
            if($days>0) {
                $duration .= $days." days ".$hours." hours";
            } else {
                if ($hours > 0) {
                    $duration .= $hours."hours ".$mins." minutes";
                } else {
                    if ($mins > 0) {
                        $duration .= $mins." minutes ".$secs." seconds";
                    } else {
                        $duration .= $secs." seconds";
                    }

                }
        }
        }

        if($secs<0) $duration = '-';

    return $duration;
}

function parse_torrent_list($_list) {
    $list = array();
    if( !is_array($_list) ) $_list = array();

    foreach( $_list AS $i )
    {
        if( !is_numeric($i) ) continue;
        $list[] = $i;
    }
    return $list;
}

function _isset($t, $key, $no = -1) {
    return isset($t[$key]) ? $t[$key] : $no;
}
/*
function has_flag($flags, $flag_check) {
        return(($flags & $flag_check) == $flag_check);
}
*/
function tor_getId($t) {
    return _isset($t, btpdControl::NUM);
}

function tor_getName($t) {
    return _isset($t, btpdControl::NAME);
}

function tor_getStatus($t) {
    if(!isset($t[btpdControl::STATE]))
        return(-1);

    $tr_torrent_status = array(0 => 'Stopped',
                             1 => 'Verifying',
                             2 => 'Stopped',
                             3 => 'Downloading',
                             4 => 'Seeding'
                            );
    return $tr_torrent_status[$t[btpdControl::STATE]];
}

function tor_getTotalSize($t) {
    return doubleval(_isset($t, btpdControl::CSIZE, 0));
}

function tor_getCompleted($t) {
    return doubleval(_isset($t, btpdControl::CGOT, 0));
}

function tor_getDownloadRate($t) {
    return _isset($t, btpdControl::RATEDWN);
}

function tor_getUploadRate($t) {
    return _isset($t, btpdControl::RATEUP);
}
/*
function tor_getPeerCount($t) {
    return _isset($t, 'peersKnown');
}
*/
function tor_getConnectedPeerCount($t) {
    return _isset($t, btpdControl::PCOUNT);
}

function tor_getSendingPeerCount($t) {
    return 0;
}

function tor_getGettingPeerCount($t) {
    return 0;
}

function tor_getMaxPeerCount($t) {
    return 0;
}

function tor_speedLimitDown($t) {
    return 0;
}

function tor_speedLimitUp($t) {
    return 0;
}

function tor_getAvailable($t)
{
    $piecesTotal = _isset($t, btpdControl::PCCOUNT,0);
    $piecesSeen  = _isset($t, btpdControl::PCSEEN,0);

    return ($piecesSeen*100/$piecesTotal);
}

function tor_getRatio($t) {

    return round(_isset($t,btpdControl::TOTUP,0) / _isset($t,btpdControl::CSIZE,0),2);
}
/*
function tor_getUploaded($t) {
    return _isset($t, 'uploadedEver');
}

function tor_getProgress($t) {
    if(isset($t['sizeWhenDone'], $t['haveUnchecked'], $t['haveValid']))
    return((($t['haveUnchecked']+$t['haveValid'])/$t['sizeWhenDone'])*100);
}
*/
function tor_getEta($t) {
    return '';
}
/*
function stat_getTorrentCount($s) {
    return _isset($s, 'torrentCount', 0);
}
*/

function tr_torrentAccessor($fields = '', $ids = '')
{
    global $globalinfo;

    if( is_array($ids) ) $ids = $ids[0];

    $r = $globalinfo["btpdControl"]->btpd_list_torrents($ids);

    return($r['code']==0 ? $r['result'] : FALSE);
}

function tr_sessionAccessor($fields='')
{
    return array();
}
function tr_torrentRemove($ids)
{
    global $globalinfo;

    if( !is_array($ids) ) return;

    foreach( $ids AS $id )
    {
        $r = $globalinfo["btpdControl"]->btpd_del_torrent($id);
        /*if( $r['code'] != 0 )
        {
            return "Error occured: ".$globalinfo["btpdControl"]->get_btpd_error($r['code']);
        }*/
    }
}

function tr_torrentStart($ids)
{
    global $globalinfo;

    if( !is_array($ids) ) return;

    foreach( $ids AS $id )
    {
        $r = $globalinfo["btpdControl"]->btpd_start_torrent($id);
        /*if( $r['code'] != 0 )
        {
            return "Error occured: ".$globalinfo["btpdControl"]->get_btpd_error($r['code']);
        }*/
    }
}

function tr_torrentStop($ids)
{
    global $globalinfo;

    if( !is_array($ids) ) return;

    foreach( $ids AS $id )
    {
        $r = $globalinfo["btpdControl"]->btpd_stop_torrent($id);
        /*if( $r['code'] != 0 )
        {
            return "Error occured: ".$globalinfo["btpdControl"]->get_btpd_error($r['code']);
        }*/
    }
}

function tr_torrentRemoveAll()
{
    global $globalinfo;

    $torrents = tr_torrentAccessor();
    if( !is_array($torrents) ) return;

    $tor_IdList = array();
    foreach( $torrents AS $_torrent ) $tor_IdList[] = tor_getId($_torrent);

    tr_torrentRemove($tor_IdList);
}

function tr_torrentStartAll()
{
    global $globalinfo;

    $torrents = tr_torrentAccessor();
    if( !is_array($torrents) ) return;

    $tor_IdList = array();
    foreach( $torrents AS $_torrent ) $tor_IdList[] = tor_getId($_torrent);

    tr_torrentStart($tor_IdList);
}

function tr_torrentStopAll()
{
    global $globalinfo;

    $torrents = tr_torrentAccessor();
    if( !is_array($torrents) ) return;

    $tor_IdList = array();
    foreach( $torrents AS $_torrent ) $tor_IdList[] = tor_getId($_torrent);

    tr_torrentStop($tor_IdList);
}

function tr_sessionMutator($fields)
{
    global $globalinfo, $session;

    $arrIniSave = array();
    foreach( $session AS $key => $val )
    {
        switch($key)
        {
            case "download-dir":
                $arrIniSave["DownloadDir"] = $fields["download-dir"];
                break;
            case "sort-order":
                $arrIniSave["SortOrder"] = $fields["sort-order"];
                break;
            case "peer-limit":
                $arrIniSave["MaxPeers"] = is_numeric($fields["peer-limit"])?$fields["peer-limit"]:0;
                break;
            case "port":
                $arrIniSave["Port"] = is_numeric($fields["port"])?$fields["port"]:0;
                break;
            case "max-upload-peers":
                $arrIniSave["MaxUploads"] = is_numeric($fields["max-upload-peers"])?($fields["max-upload-peers"]>=0?$fields["max-upload-peers"]:-1):0;
                break;
            case "empty-start":
                $arrIniSave["EmptyStart"] = empty($fields["empty-start"])?0:1;
                break;
            case "speed-limit-down":
                $arrIniSave["DownloadLimit"] = is_numeric($fields["speed-limit-down"])?$fields["speed-limit-down"]:0;
                break;
            case "speed-limit-up":
                $arrIniSave["UploadLimit"] = is_numeric($fields["speed-limit-up"])?$fields["speed-limit-up"]:0;
                break;
        }
    }

    //write INI
    $result = doSaveIni($globalinfo["APP_INI"], $arrIniSave);
    if( $result == false ) return false;

    //restart
    exec($globalinfo["APP_RESTART"]);

    return true;
}

function doSaveIni($file_name, $arrIniSave)
{
    if( !file_exists($file_name) || is_dir($file_name) ) _error("INI file doesn't exist");
    else if( !is_writeable($file_name) )                 _error("INI file is not writeable");

    $file_name_tmp = $file_name.".tmp";

    //write to temp file
    $fd = fopen($file_name_tmp, "w");
    if( !$fd ) return false;
    foreach( $arrIniSave AS $key => $val ) fwrite($fd, $key."=".$val."\n");
    fclose($fd);

    //test
    $arrTemp = parse_ini_file($file_name_tmp);
    $is_ok = true;
    foreach( $arrIniSave AS $key => $val )
    {
        if( $arrTemp[$key] != $val )
        {
            $is_ok = false;
            break;
        }
    }
    if( !$is_ok )
    {
        //erase temp
        @unlink($file_name_tmp);

        return false;
    }

    //replace ini with temp
    exec("cp -f $file_name_tmp $file_name");
    exec("chmod 666 $file_name");

    //erase temp
    @unlink($file_name_tmp);

    return true;
}

function tor_parseContentAsHtml($key, $val)
{
    $val = trim($val);

    switch( strtolower(trim($key)) )
    {
        case "creation date": $val = date("Y-m-d H:i:s", $val); break;
        case "piece length": case "length": $val = number_format(doubleval($val)/1024/1024,1)."MB"; break;
        case "pieces": $val = "<i>&lt;skipped binary data&gt;</i>"; break;
        default: $val = htmlspecialchars($val);
    }

    return $val;
}

function tor_getContentAsHtmlList($t)
{
    if( !is_array($t) ) return;

    $result = "<ul>";
    foreach( $t AS $key => $val )
    {
        $result .= "<li>".htmlspecialchars(ucfirst(strtolower($key))).":";
        $result .= is_array($val)?tor_getContentAsHtmlList($val):tor_parseContentAsHtml($key, $val);
    }
    $result .= "</ul>";

    return $result;
}

?>
