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
wget http://eboda-hd-for-all-500.googlecode.com/files/cb3pp-latest.zip
[ $? == 0 ] || nice_exit 2

rm -rf cb3pp/*

unzip -o cb3pp-latest.zip
rm cb3pp-latest.zip



nice_exit 0 
