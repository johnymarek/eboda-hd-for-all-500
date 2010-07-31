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

SERIAL=0
VERSION=v0.0


wget http://eboda-hd-for-all-500.googlecode.com/files/ewcp-latest-version.txt
[ $? == 0 ] || nice_exit 1  
. ./ewcp-latest-version.txt
. ./ewcp/ewcp-version.txt

if [ $LATEST_SERIAL -gt $SERIAL ]
then
    echo "Latest version available is ${LATEST_VERSION}, you have $VERSION, updating !!!"

    wget http://eboda-hd-for-all-500.googlecode.com/files/ewcp-latest.zip
    
    [ $? == 0 ] || nice_exit 1  
    
    rm -rf ewcp/*
    
    unzip -o ewcp-latest.zip
    rm ewcp-latest.zip
    
    cp $storage/ewcp/S99ewcp /cb3pp/etc/init.d/S99ewcp
    sh /cb3pp/etc/init.d/S99ewcp
else
    echo "You are already running the latest version ($VERSION)"
fi
nice_exit 0 



