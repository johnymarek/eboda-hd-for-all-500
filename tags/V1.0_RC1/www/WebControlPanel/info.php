<strong>Astone Media Player - System Information</strong>

<?
	print "<pre>" . shell_exec("cat /proc/version") . "</pre>";
?></BR>

<strong>CPU Info</strong><?
	print "<pre>" . shell_exec("cat /proc/cpuinfo") . "</pre>";
?></BR>

<strong>Memory Info</strong><?
	print "<pre>" . shell_exec("cat /proc/meminfo") . "</pre>";
?></BR>

<strong>Disk Mounts</strong><?
	print "<pre>" . shell_exec("mount") . "</pre>";
?></BR>