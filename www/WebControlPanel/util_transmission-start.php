<?
	shell_exec("/opt/etc/init.d/S91transmission start");
?>
Transmission daemon started.

Current stats:
<?
	print "<pre>" . shell_exec("/tmp/hdd/volumes/HDD1/transmission/config/settings.json") . "</pre>";
?>