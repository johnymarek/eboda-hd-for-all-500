#!/bin/sh


. ./common.sh

nice_start "Updating vb6 scripts"


. /usr/local/etc/storage

if [ ! -d $storage ]
then 
    echo Cannot find storage $storage. Exiting
    mount
    nice_exit 1
else
    echo Storage $storage found
fi


#vb6 scripts to HDD
cd $storage
wget http://eboda-hd-for-all-500.googlecode.com/files/scripts-latest.zip
[ $? == 0 ] || nice_exit 2

rm -rf scripts/*

unzip -o scripts-latest.zip
rm scripts-latest.zip

nice_exit 0 
