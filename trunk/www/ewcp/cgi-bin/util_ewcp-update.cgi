#!/bin/sh

. ./common.sh

nice_start "Updating Eboda web control panel"


#check if storage
. /usr/local/etc/storage

if [ ! -d $storage ]
then 
    echo Cannot find storage $storage. Exiting
    mount
    nice_exit 1
else
    echo Storage $storage found
fi


#ewcp updating
cd $storage
wget http://eboda-hd-for-all-500.googlecode.com/files/ewcp-latest.zip

[ $? == 0 ] || nice_exit 1  

rm -rf ewcp/*

unzip -o ewcp-latest.zip
rm ewcp-latest.zip

cp ewcp/S99ewcp /cb3pp/etc/init.d/S99ewcp
sh /cb3pp/etc/init.d/S99ewcp

nice_exit 0 



