# Introduction #

There are the modification of E-Boda official firmware to get a nice mix of features for users that wants to play with linux running on it, but also to be able to run just everything right after installation.

Below are the intentions, for a list of features inside of a specific firmware check thet firmware specific web page (that you find on Project Home)


# Details #

The modifications are done by a single bash script (http://code.google.com/p/eboda-hd-for-all-500/source/browse/trunk/scripts/firmware/patch_firmware_full_500.sh) and they are:

  * /usr/local/etc/root directory is created to be used as home for root
  * corrected Romanian and English languages by Mtz
  * services (btpd/samba/unicgi)
  * screensaver + skinpack
  * working awk
  * eboda web control panel (web interface for management)

  * vb6 + XTreamer scripts
  * lighttpd+php+rtorrent
  * in /cb3pp and a selection of application is installed there - lighttpd,php,rtorrent,web interfaces for rtorrent.
  * /opt directory is created so it can be mounted later from HDD and used

  * it contains archived versions of applications+scripts+ewcp
  * all of them will be extracted after power-on first storage device if not already there (so full functionality with SD card or USB storage)