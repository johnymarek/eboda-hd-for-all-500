# Samba installation #

**Atention: You will need to disable "Network Services" before.**

Samba provided by extension package is a little old and a little slow. At least for me version 3 of samba from optware was running faster.

Also, the install script will scan for USB devices mounted and will export them through samba (so if you want to export a USB disk by samba, just take care to plug it in during install).

Install procedure is the standard one for scripts:

```
wget http://eboda-hd-for-all-500.googlecode.com/files/samba-install.sh && sh samba-install.sh && rm samba-install.sh
```