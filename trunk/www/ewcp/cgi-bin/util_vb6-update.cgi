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

SERIAL=0
[ -f ${storage}/scripts-version.txt ] && . ${storage}/scripts-version.txt
DISK_SERIAL=${SERIAL}

wget http://eboda-hd-for-all-500.googlecode.com/files/scripts-version.txt -O scripts-version-new.txt
[ $? == 0 ] || nice_exit 1  

[ -f ./scripts-version-new.txt ] && . ./scripts-version-new.txt

if [ ${SERIAL} -gt ${DISK_SERIAL} ]
then
    echo "Latest version available is ${SERIAL}, you have $DISK_SERIAL, updating !!!"


wget http://eboda-hd-for-all-500.googlecode.com/files/scripts-latest.zip
[ $? == 0 ] || nice_exit 2

rm -rf scripts/*

unzip -o scripts-latest.zip
rm scripts-latest.zip

    mv scripts-version-new.txt scripts-version.txt

else
    echo "You are already running the latest version ($SERIAL)"
fi

nice_exit 0 
