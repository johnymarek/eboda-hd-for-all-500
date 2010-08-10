#!/bin/sh


. ./common.sh

nice_start "Updating apps"


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


cd $storage

SERIAL=0
[ -f ${storage}/cb3pp-version.txt ] && . ${storage}/cb3pp-version.txt
DISK_SERIAL=${SERIAL}

wget http://eboda-hd-for-all-500.googlecode.com/files/cb3pp-version.txt -O cb3pp-version-new.txt
[ $? == 0 ] || nice_exit 1  

[ -f ./cb3pp-version-new.txt ] && . ./cb3pp-version-new.txt

if [ ${SERIAL} -gt ${DISK_SERIAL} ]
then
    echo "Latest version available is ${SERIAL}, you have $DISK_SERIAL, updating !!!"


    wget http://eboda-hd-for-all-500.googlecode.com/files/cb3pp-latest.zip
    [ $? == 0 ] || nice_exit 2
    
    rm -rf cb3pp/*
    
    unzip -o cb3pp-latest.zip
    rm cb3pp-latest.zip
    
    cp $storage/ewcp/S99ewcp /cb3pp/etc/init.d/S99ewcp
    sh /cb3pp/etc/init.d/S99ewcp

    mv cb3pp-version-new.txt cb3pp-version.txt
else
    echo "You are already running the latest version ($SERIAL)"
fi


nice_exit 0 
