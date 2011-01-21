#!/bin/sh

#activate swap partition (otherwire you risk to block the box

swapsize=`grep SwapTotal /proc/meminfo | tr -s ' ' | cut -d ' ' -f 2`
partition=`fdisk -l | grep "Linux swap" | cut -d ' ' -f 1`
psize=`fdisk -l | grep "Linux swap" | tr -s ' ' | cut -d ' ' -f 4`

echo !!!!!!!!!!!!!!!!!!
echo ! Your swap size is $swapsize kB. 
echo ! Your swap partition size is $psize kB

if [ $swapsize -gt $psize ]
then
	echo ! Probably swap partition is used: $partition
	echo ! Start script will restored
	echo ! waiting 5 seconds \(press CTRL+C to stop\)
	sleep 5
else
	echo ! Everything looks ok, swap partition probably already deactivated
	exit 2
fi


cmd="/sbin/swapoff $partition"

sed -e "/^#BEGIN CBS/,/^#END CBS/d" /usr/local/etc/rcS > /tmp/tmpfile$$
if [ $? -eq 0 ]
then
                cp /tmp/tmpfile$$ /usr/local/etc/rcS
                echo Swap partition unconfigured from auto startup
else
        echo error on sed
fi
rm /tmp/tmpfile$$ 


$cmd
if [ $? -eq 0 ]
then
	echo Swap partition now deactivated \(reboot not required\)
else
    	echo Cannot deactivate swap partition, please reboot
    	echo Will reboot in 5 seconds \(press CTRL+C to stop\)
    	sleep 5
    	reboot
fi
    	                                                                                                   
