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
[ -f ${storage}/ewcp-version.txt ] && . ${storage}/ewcp-version.txt
DISK_SERIAL=${SERIAL}

wget http://eboda-hd-for-all-500.googlecode.com/files/ewcp-version.txt -O ewcp-version-new.txt
[ $? == 0 ] || nice_exit 1  

[ -f ./ewcp-version-new.txt ] && . ./ewcp-version-new.txt

if [ ${SERIAL} -gt ${DISK_SERIAL} ]
then
    echo "Latest version available is ${SERIAL}, you have $DISK_SERIAL, updating !!!"

    wget http://eboda-hd-for-all-500.googlecode.com/files/ewcp-latest.zip
    
    [ $? == 0 ] || nice_exit 1  
    
    rm -rf ewcp/*
    
    unzip -o ewcp-latest.zip
    rm ewcp-latest.zip
    
    cp $storage/ewcp/S99ewcp /cb3pp/etc/init.d/S99ewcp
    sh /cb3pp/etc/init.d/S99ewcp
    mv ewcp-version-new.txt ewcp-version.txt


else
    echo "You are already running the latest version ($SERIAL)"
fi
nice_exit 0 



