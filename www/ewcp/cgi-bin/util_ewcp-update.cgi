#!/bin/sh

. ./common.sh

nice_start "Updating Eboda web control panel"

#ewcp updating
cd /tmp/hdd/root
wget http://eboda-hd-for-all-500.googlecode.com/files/ewcp-latest.zip
[ $? == 0 ] || nice_exit 1  
if [ -d ewcp ]
then
        echo ewcp already existing, removing it
        rm -rf ewcp
fi
unzip -o ewcp-latest.zip
rm ewcp-latest.zip

sh /opt/etc/init.d/S99ewcp

nice_exit 0 



