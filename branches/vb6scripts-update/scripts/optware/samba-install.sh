#!/bin/sh

#check if already installed by us
# done by cipibad, take good care of it


#check if internal HDD present
if [ ! -d /tmp/hdd/volumes/HDD1 -o ! -d /tmp/hdd/root ]
then 
	echo Cannot find internal HDD standard installation. Exiting
	mount
	exit 3
else
	echo Internal HDD found, continuing
fi
	

#install optware
if [ -f /tmp/hdd/root/opt/bin/ipkg-opt ]
then
	echo  -e "You already installed optware, good show!\nI will execute an update"
    	/tmp/hdd/root/opt/bin/ipkg-opt update
else
      	echo -e "Optware is not installed... Please do installt it\n"
	exit 1
      
fi

#install transmission

/tmp/hdd/root/opt/bin/ipkg-opt install samba


echo configuring samba
cat > /opt/etc/samba/smb.conf <<EOF
[global]
workgroup = WORKGROUP
guest account = nobody
security = share
browseable = yes
guest ok = yes
guest only = no
log level = 1
max log size = 100
encrypt passwords = yes
dns proxy = no
netbios name = venus
server string = E-Boda HD for all
socket options = TCP_NODELAY IPTOS_LOWDELAY SO_KEEPALIVE SO_SNDBUF=8192
interfaces = eth0

[HDD1]
path=/tmp/hdd/volumes/HDD1
read only = no
writeable = yes
browseable = yes
public = yes

#down here place for usb mounts
#USB_MOUNTS


EOF


for i in `mount | grep usb | cut -d ' ' -f 3`
do echo found $i
shortname=`echo $i | cut -d '/' -f 4`

cat >>/opt/etc/samba/smb.conf <<EOF
[$shortname]
path=$i
read only = no
writeable = yes
browseable = yes
public = yes

EOF
done



sed -i -e '/^samba_active=0/c\
samba_active=1' /opt/etc/init.d/S08samba
echo samba activated


/opt/etc/init.d/S08samba restart
