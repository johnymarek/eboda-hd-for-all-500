# Rtorrent Installation #

Rtorrent is a promising torrent client for embedded. Still not very stable ...

For the moment I got a stable configuration on 500 version only when **swap is activated** (see http://code.google.com/p/eboda-hd-for-all-500/wiki/SwapOn) and only one torrent is downloaded at a time. For 500plu situation may be different.

Also take extra care when updating firmware while rtorrent installed: you need to disable rtorrent before (chmod -x /opt/etc/init.d/S90rtorrent) otherwise it may freeze the MP and you can enable it after new firmware is started and you decide to keep it.

Telnet to your media player with optware package installed(this is already installed if you have firmware from this page) and execute the following command:
```
wget http://eboda-hd-for-all-500.googlecode.com/files/rtorrent-install.sh && sh rtorrent-install.sh && rm rtorrent-install.sh
```

You will be able to manage your torrents at addresses(replace MP\_IP with your mplayer IP address):
http://MP_IP:8081/rutorrent/ or http://MP_IP:8081/rtgui/