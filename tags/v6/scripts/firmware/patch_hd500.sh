#!/bin/sh

IMAGE_FILE=install.img

[ -f ${IMAGE_FILE} ] || exit

if [ $# -ne 1 ]
then
    
    echo SVN dir not found, please supply
    exit 1
fi
echo SVN dir: $1
if [ -d $1/.svn ]
then

    echo SVN dir found
else
    echo SVN dir not found, please supply
    exit 1
fi

if [ ! -d $1/src/500/Resource ]
then
    echo resources not found, repository incomplete
    exit 1
fi

if [ ! -d $1/src/bin ]
then
    echo bin not found, repository incomplete
    exit 1
fi

if [ ! -d $1/src/500/image ]
then
    echo image not found, repository incomplete
    exit 1
fi

echo Checking if tool are present ....
which unyaffs >/dev/null
if [ $? -eq 1 ]
then
    echo 'required tool unyaffs not in PATH'
    exit
fi

which mkyaffs2image >/dev/null
if [ $? -eq 1 ]
then
    echo 'required tool unyaffs not in PATH'
    exit
fi
echo Checking OK

#
# unpack img
mkdir unpacked_install
[ $? -eq 0 ] || exit cannot create dir please start from a clean directory

cd unpacked_install/
tar xvf ../${IMAGE_FILE}

#
# go to package 2
cd package2/

#
# unpack root
mkdir unpacked_root
[ $? -eq 0 ] || exit cannot create dir please start from a clean directory

cd unpacked_root/
unyaffs ../yaffs2_1.img

#
#modify root

# in last version e-boda makes /opt symlink to /usr/local/etc and mess-up my optware !!!
rm -f opt

# cb3pp directory for apps
mkdir cb3pp

# ewcp directory for apps
mkdir ewcp

# and opt for other people to play
mkdir opt

# and scripts for me to play
mkdir scripts

# and xLive9 for me to play
mkdir xLive9

# and utilities for me to play
mkdir utilities


#home dir for root part 1
sed -i -e '/^root/c\
root::0:0:root:/usr/local/etc/root:/bin/sh' etc/passwd

# traducere + font
#cp  $1/src/500/Resource/*.str usr/local/bin/Resource 
cp  $1/src/500/Resource/*.TTF usr/local/bin/Resource 

# screensaver + skinpack
# keeping original files
#cp  $1/src/500/Resource/bmp/* usr/local/bin/Resource/bmp 
#cp  $1/src/500/image/* usr/local/bin/image 

# awk
cp  $1/src/bin/* usr/bin
chmod +x usr/bin/*

# eboda web control panel
dir=`pwd`
cd $1/www/
find ewcp | grep -v .svn | grep -v '~' | zip -9 ${dir}/ewcp.zip -@
cp ewcp-version.txt ${dir}/ewcp-version.txt
cd $dir

# /cb3pp
dir=`pwd`
cd $1/src/
find cb3pp | grep -v .svn | grep -v '~'  | zip -9 ${dir}/cb3pp.zip -@
cp cb3pp-version.txt ${dir}/cb3pp-version.txt
cd $dir

# cgi-bin
cp $1/scripts/feeds/scripts_vb6/cgi-bin/mf/* tmp_orig/www/cgi-bin/
cp $1/scripts/feeds/scripts_vb6/cgi-bin/vb6/* tmp_orig/www/cgi-bin/
chmod +x tmp_orig/www/cgi-bin/*

# menu
cp -r $1/src/500/menu/* usr/local/bin/scripts/

# scripts
dir=`pwd`
cd $1/scripts/feeds/scripts_vb6/
find scripts | grep -v .svn | grep -v '~' | zip -9 ${dir}/scripts.zip -@
cp scripts-version.txt ${dir}/scripts-version.txt
cd ${dir}

cd ..
rm yaffs2_1.img
mkyaffs2image unpacked_root yaffs2_1.img 

rm -rf unpacked_root/

mkdir unpacked_etc
[ $? -eq 0 ] || exit cannot create dir please start from a clean directory


cd unpacked_etc/

tar jxvf ../usr.local.etc.tar.bz2
mkdir root
#

# keep this to be mine
# later update to come for external images of xtreamer
# cp $1/src/500/etc/rcS .

# creating our startup script to install cb3pp stuff if not in
echo '#!/bin/sh
#BEGIN CBA_CB3PP_STARTUP
# wait storage to be mounted
if [ -f /usr/local/etc/use_storage ]
then

	mount_pattern=`cat /usr/local/etc/use_storage`
else
	mount_pattern=scsi
fi
#TODO find what to check instead root which exists even if not mounted?

n=1
mount | grep ${mount_pattern}
while [ $? -ne 0 ] ; do
sleep 3
[ $n -gt 30 ] && break
let n+=1
echo "#waiting for hdd.."
mount | grep ${mount_pattern}
done

if [ $n -gt 30 ]
then
	echo no storage found, nothing to do ...
else
#storage online !! go go go

storage=`mount | grep ${mount_pattern} | tr -s " " | cut -d " " -f 3 | head -n 1`
echo "storage=$storage" > /usr/local/etc/storage

#remount RW
mount -o rw,remount $storage


storage="$storage/zapps"
echo "storage=$storage" > /usr/local/etc/storage

#check if overmount dirs present 
[ -d ${storage}] || mkdir ${storage}
[ -d ${storage}/cb3pp ] || mkdir ${storage}/cb3pp
[ -d ${storage}/scripts ] || mkdir ${storage}/scripts
[ -d ${storage}/ewcp ] || mkdir ${storage}/ewcp

if [ ! -f /cb3pp/.overmounted ];then
    echo overmount start
    mount -o bind ${storage}/cb3pp /cb3pp
    touch /cb3pp/.overmounted
    echo overmount end
fi


if [ ! -f /scripts/.overmounted ];then
    echo overmount start
    mount -o bind ${storage}/scripts /scripts
    touch /scripts/.overmounted
    echo overmount end
fi

if [ ! -f /ewcp/.overmounted ];then
    echo overmount start
    mount -o bind ${storage}/ewcp /ewcp
    touch /ewcp/.overmounted
    echo overmount end
fi


# check if .../cb3pp installed from us, if not, unpack
SERIAL=0
 [ -f ${storage}/cb3pp-version.txt ] && . ${storage}/cb3pp-version.txt
DISK_SERIAL=${SERIAL}
[ -f /cb3pp-version.txt ] && . /cb3pp-version.txt

if [ ${SERIAL} -gt ${DISK_SERIAL} ]
then
	rm -rf  ${storage}/cb3pp/*
	cd ${storage}
	unzip -o /cb3pp.zip 
	cp /cb3pp-version.txt ${storage}/cb3pp-version.txt
fi


# check if .../scripts from us, if not, unpack
SERIAL=0
 [ -f ${storage}/scripts-version.txt ] && . ${storage}/scripts-version.txt
DISK_SERIAL=${SERIAL}
[ -f /scripts-version.txt ] && . /scripts-version.txt

if [ ${SERIAL} -gt ${DISK_SERIAL} ]
then
        rm -rf ${storage}/scripts/*
        cd ${storage}
        unzip -o /scripts.zip
	cp /scripts-version.txt ${storage}/scripts-version.txt
fi

# check if .../ewcp installed from us, if not, unpack
SERIAL=0
 [ -f ${storage}/ewcp-version.txt ] && . ${storage}/ewcp-version.txt
DISK_SERIAL=${SERIAL}
[ -f /ewcp-version.txt ] && . /ewcp-version.txt

if [ ${SERIAL} -gt ${DISK_SERIAL} ]
then
        rm -rf ${storage}/ewcp/*
        cd  ${storage}
        unzip -o /ewcp.zip
	cp /ewcp-version.txt ${storage}/ewcp-version.txt

	[ -f  ${storage}/cb3pp/etc/init.s/S99ewcp ] || cp  ${storage}/ewcp/S99ewcp  ${storage}/cb3pp/etc/init.d
        chmod +x ${storage}/cb3pp/etc/init.d/S99ewcp
fi

cb3pp_startup=/cb3pp/etc/init.d/rcS

# standard startup
[ -f $cb3pp_startup ] && /bin/sh $cb3pp_startup

fi
#END CBA_CB3PP_STARTUP' > rccb3ppS
chmod +x rccb3ppS

echo '
[ -f /usr/local/etc/rccb3ppS ] && sh /usr/local/etc/rccb3ppS &' >> rcS


rm ../usr.local.etc.tar.bz2
tar jcvf ../usr.local.etc.tar.bz2 *
cd ..
rm -rf unpacked_etc/

cd ..
mv ../${IMAGE_FILE} ../${IMAGE_FILE}.orig
tar cvf ../${IMAGE_FILE} *
cd ..
ls -l

