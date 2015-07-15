# optware installation #
Originally created for the Linksys NSLU2 Unslung firmware, Optware is the name of the additional software packages available for Linux running on MIPS architecture. Optware can be used on both, 500 and 500plus.

This script can be used either to install optware either to recover optware after firmware upgrade.

**Important**: You will need a firmware modified (either the one from Downloads section http://code.google.com/p/eboda-hd-for-all-500/downloads/list either one with space on root partition like the one from vb6 http://forum.softpedia.com/index.php?showtopic=640751)

Usage of the script is simple, you need to open a telnet connection to your MP and then execute the following command:
```
$wget http://eboda-hd-for-all-500.googlecode.com/files/optware-install.sh && sh optware-install.sh && rm optware-install.sh
Connecting to eboda-hd-for-all-500.googlecode.com[209.85.135.82]:80
optware-install.sh   100% |*****************************|  4075       00:00 ETA
Internal HDD found, continuing
....
Successfully terminated.
Finished
Optware is OK now. We will reboot in 10 seconds, press CTRL+C to stop
```

Now you can enjoy any package in optware repository.