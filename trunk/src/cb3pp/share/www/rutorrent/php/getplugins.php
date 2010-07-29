<?php

require_once( "util.php" );
require_once( "settings.php" );

function pluginsSort($a, $b)
{ 
	$lvl1 = (float) $a["info"]["runlevel"];
	$lvl2 = (float) $b["info"]["runlevel"];
	if($lvl1>$lvl2)
		return(1);
	if($lvl1<$lvl2)	
		return(-1);
	return( 0 );
}

function getFlag($permissions,$pname,$fname)
{
	$ret = true;
	if(array_key_exists($pname,$permissions) &&
		array_key_exists($fname,$permissions[$pname]))
		$ret = $permissions[$pname][$fname];
	else
	if(array_key_exists("default",$permissions) &&
		array_key_exists($fname,$permissions["default"]))
		$ret = $permissions["default"][$fname];
	return($ret);
}

function getPluginInfo( $name, $permissions )
{
        $info = array();
	$fname = "../plugins/".$name."/plugin.info";
	if(is_readable($fname))
	{
		$lines = file($fname);
		foreach($lines as $line)
		{
			$fields = explode(":",$line,2);
			if(count($fields)==2)
			{
				$value = addcslashes(trim($fields[1]),"\\\'\"\n\r\t");
				$field = trim($fields[0]); 
				switch($field)
				{
					case "author":
					case "description":
					case "remote":
					{
						$info[$field] = $value;
						break;
					}
					case "need_rtorrent":
					{
						$info[$field] = intval($value);
						break;
					}
					case "version":
					case "runlevel":
					{
						$info[$field] = floatval($value);
						break;
					}
				}
			}
		}
		if(!array_key_exists("need_rtorrent",$info))
			$info["need_rtorrent"] = 1;
		if(!array_key_exists("runlevel",$info))
			$info["runlevel"] = 10.0;
		if(!array_key_exists("description",$info))
			$info["description"] = "";
		if(!array_key_exists("author",$info))
			$info["author"] = "unknown";
		if(!array_key_exists("remote",$info))
			$info["remote"] = "ok";
		$perms = 0;
		if($permissions!==false)
		{
			if(!getFlag($permissions,$name,"enabled"))
				return(false);
			$flags = array(
				"canChangeToolbar" 	=> 0x0001,
				"canChangeMenu" 	=> 0x0002,
				"canChangeOptions"	=> 0x0004,
				"canChangeTabs"		=> 0x0008,
				"canChangeColumns"	=> 0x0010,
				);
			foreach($flags as $flagName=>$flagVal)
				if(!getFlag($permissions,$name,$flagName))
					$perms|=$flagVal;
		}
		$info["perms"] = $perms;
	}
	return(array_key_exists("version",$info) ? $info : false);
}

function findEXE( $exe )
{
	$path = explode(":", getenv('PATH'));
	foreach($path as $tryThis)
	{
		$fname = $tryThis . '/' . $exe;
		if(is_executable($fname))
			return($fname);
	}
	return(false);
}

function findRemoteEXE( $exe, $err, &$remoteRequests )
{
	$st = getSettingsPath().'/';
	if(!is_file($st.$exe))
	{
		if(!array_key_exists($exe,$remoteRequests))
		{
			$path=realpath(dirname('.'));
			$req = new rXMLRPCRequest(new rXMLRPCCommand("execute", array( "sh", "-c", escapeshellarg(addslash($path)."test.sh")." ".$exe." ".escapeshellarg($st))));
			$req->run();
		}
		$remoteRequests[$exe][] = $err;
	}
}

function testRemoteRequests($remoteRequests)
{
	$jResult = "";
	$st = getSettingsPath().'/';
	foreach($remoteRequests as $exe=>$errs)
	{
		$file = $st.$exe.".founded";
		if(!is_file($file))
		{
			foreach($errs as $err)
				$jResult.=$err;
		}
		else
			@unlink($file);
	}
	return($jResult);
}

$jResult = "theWebUI.deltaTime = new Date().getTime() - ".time()."*1000;\n";
$access = getConfFile('access.ini');
if(!$access)
	$access = "../conf/access.ini";
$permissions = parse_ini_file($access);
$settingsFlags = array(
	"showDownloadsPage" 	=> 0x0001,
	"showConnectionPage" 	=> 0x0002,
	"showBittorentPage"	=> 0x0004,
	"showAdvancedPage"	=> 0x0008,
	"showPluginsTab"	=> 0x0010,
	"canChangeULRate"	=> 0x0020,
	"canChangeDLRate"	=> 0x0040,
	"canChangeTorrentProperties"	=> 0x0080,
);
$perms = 0;
foreach($settingsFlags as $flagName=>$flagVal)
	if(array_key_exists($flagName,$permissions) && $permissions[$flagName])
		$perms|=$flagVal;
$jResult .= "theWebUI.showFlags = ".$perms.";\n";
$jResult .= "theURLs.XMLRPCMountPoint = '".$XMLRPCMountPoint."';\n";
$jResult.="theWebUI.systemInfo = {};\ntheWebUI.systemInfo.php = { canHandleBigFiles : ".((PHP_INT_SIZE<=4) ? "false" : "true")." };\n";

if($handle = opendir('../plugins')) 
{
	ignore_user_abort(true);
	set_time_limit(0);
	@chmod('/tmp',0777);
	if(!function_exists('preg_match_all'))
		$jResult.="log(theUILang.PCRENotFound);";
	else
	{
		$theSettings = new rTorrentSettings();
		$theSettings->obtain();
		if(!$theSettings->linkExist)
		{
			$jResult.="log(theUILang.badLinkTorTorrent);";
			$jResult.="theWebUI.systemInfo.rTorrent = { started: false, version : '?', libVersion : '?' };\n";
		}
		else
		{
			$jResult.="theWebUI.systemInfo.rTorrent = { started: true, version : '".$theSettings->version."', libVersion : '".$theSettings->libVersion."' };\n";
	        	if($do_diagnostic)
	        	{
	        	        $up = getUploadsPath();
	        	        $st = getSettingsPath();
				@chmod($up,0777);
				@chmod($st,0777);
				@chmod('./test.sh',0755);
	        		if(!isUserHavePermission($theSettings->myuid,$theSettings->mygid,$up,0x0007))
					$jResult.="log(theUILang.badUploadsPath+' (".$up.")');";
	        		if(!isUserHavePermission($theSettings->myuid,$theSettings->mygid,$st,0x0007))
        			        $jResult.="log(theUILang.badSettingsPath+' (".$st.")');";
				if(!empty($theSettings->session))
				{
					if(($theSettings->uid<0) || ($theSettings->gid<0))
						$jResult.="log(theUILang.badSessionPath+' (".$theSettings->session.")');";
					else
					{
						if(!isUserHavePermission($theSettings->uid,$theSettings->gid,$up,0x0007))
							$jResult.="log(theUILang.badUploadsPath2+' (".$up.")');";
						if(!isUserHavePermission($theSettings->uid,$theSettings->gid,$st,0x0007))
							$jResult.="log(theUILang.badSettingsPath2+' (".$st.")');";
						if(!isUserHavePermission($theSettings->uid,$theSettings->gid,'./test.sh',0x0005))
							$jResult.="log(theUILang.badTestPath+' (".realpath('./test.sh').")');";
					}
				}
				if($theSettings->badXMLRPCVersion)
					$jResult.="log(theUILang.badXMLRPCVersion);";
			}
		}
		$plg = getConfFile('plugins.ini');
		if(!$plg)
			$plg = "../conf/plugins.ini";
		$permissions = parse_ini_file($plg,true);
		$init = array();
		while(false !== ($file = readdir($handle)))
		{
			if($file != "." && $file != ".." && is_dir('../plugins/'.$file))
			{
				$info = getPluginInfo( $file, $permissions );
				if($info!==false)
				{
				        if(!$theSettings->linkExist && $info["need_rtorrent"])
						continue;
				        if(!isLocalMode())
				        {
				        	if($info["remote"]=="error")
						{
							$jResult.="log('".$file.": '+theUILang.errMustBeInSomeHost);";
							continue;
						}
				        	if($do_diagnostic && ($info["remote"]=="warning"))
							$jResult.="log('".$file.": '+theUILang.warnMustBeInSomeHost);";
				        }
					$js = "../plugins/".$file."/init.js";
	                	        if(!is_readable($js))
						$js = NULL;
        		                $php = "../plugins/".$file."/init.php";
					if(!is_readable($php))
						$php = NULL;
					$init[] = array( "js" => $js, "php" => $php, "info" => $info, "name" => $file );
				}
			}
		} 
		usort($init,"pluginsSort");
		$remoteRequests = array();
		foreach($init as $plugin)
		{
		        $jEnd = '';
		        $pInfo = $plugin["info"];
			$jResult.="(function () { var plugin = new rPlugin( '".$plugin["name"]."',".$pInfo["version"].
				",'".$pInfo["author"]."','".$pInfo["description"]."',".$pInfo["perms"]." );\n";
			if($plugin["php"])
				require_once( $plugin["php"] );
			else
				$theSettings->registerPlugin($plugin["name"]);
			if($plugin["js"])
			{
				$jResult.=file_get_contents($plugin["js"]);
				$jResult.="\n";
			}
			$jResult.=$jEnd;
			$jResult.="\n})();";
		}
		$jResult.=testRemoteRequests($remoteRequests);
		$theSettings->store();
	}
	closedir($handle);
}
if(!ini_get("zlib.output_compression"))
	header("Content-Length: ".strlen($jResult));
header("Content-Type: application/javascript; charset=UTF-8");
echo $jResult;

?>