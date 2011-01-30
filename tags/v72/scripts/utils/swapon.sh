#!/bin/sh

#activate swap partition (otherwire you risk to block the box

swapsize=`grep SwapTotal /proc/meminfo | tr -s ' ' | cut -d ' ' -f 2`
partition=`fdisk -l | grep "Linux swap" | cut -d ' ' -f 1`
psize=`fdisk -l | grep "Linux swap" | tr -s ' ' | cut -d ' ' -f 4`

echo !!!!!!!!!!!!!!!!!!
echo ! Your swap size is $swapsize kB. 
echo ! Your swap partition size is $psize kB

if [ $swapsize -lt $psize ]
then
	echo ! Probably swap partition not used
	echo ! Start script will be modified to activate 
	echo ! on partition $partition
	echo ! waiting 5 seconds \(press CTRL+C to stop\)
	sleep 5
else
	echo ! Everything looks ok, swap partition probably already activated
	exit 2
fi


slp="sleep 30; #required to detect HDD"



cmd="/sbin/swapon $partition"

sed -e "/^#BEGIN CBS/,/^#END CBS/d" /usr/local/etc/rcS > /tmp/tmpfile$$
if [ $? -eq 0 ]
then
        sed -e "\$a\\
#BEGIN CBS\\
n=1\\
while [ ! -e $partition ] ; do\\
sleep 3\\
[ \$n -gt 30 ] && break\\
let n+=1\\
echo '#waiting for hdd..'\\
echo \$n\\
done\\
$cmd\\
#END CBS" /tmp/tmpfile$$ > /tmp/tmpfile2$$
        if [ $? -eq 0 ]
            	then
                cp /tmp/tmpfile2$$ /usr/local/etc/rcS
                echo Swap partition configured for auto startup
        else
		echo error on sed
        fi
else
        echo error on sed
fi
rm /tmp/tmpfile$$ /tmp/tmpfile2$$


$cmd
if [ $? -eq 0 ]
then
	echo Swap partition now activated \(reboot not required\)
else
    	echo Cannot activate swap partition, please reboot
    	echo Will reboot in 5 seconds \(press CTRL+C to stop\)
    	sleep 5
    	reboot
fi
    	                                                                                                   
