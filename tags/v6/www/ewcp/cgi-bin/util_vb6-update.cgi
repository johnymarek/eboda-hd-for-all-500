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
SERIAL=0
VERSION=v0.0


wget http://eboda-hd-for-all-500.googlecode.com/files/scripts-latest-version.txt
[ $? == 0 ] || nice_exit 1  
. ./scripts-latest-version.txt
. ./scripts/scripts-version.txt

if [ $LATEST_SERIAL -gt $SERIAL ]
then
    echo "Latest version available is ${LATEST_VERSION}, you have $VERSION, updating !!!"

wget http://eboda-hd-for-all-500.googlecode.com/files/scripts-latest.zip
[ $? == 0 ] || nice_exit 2

rm -rf scripts/*

unzip -o scripts-latest.zip
rm scripts-latest.zip

else
    echo "You are already running the latest version ($VERSION)"
fi

nice_exit 0 
