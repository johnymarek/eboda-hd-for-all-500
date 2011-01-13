#!/bin/sh



function patch_firmware()
{

if [ $# -ne 4 ]
then
    echo 4 arguments expected by function patch_firmware IMAGE_FILE, svn-repo absolute path, \[500|500a|500mini|500minia|500plus\], SDK version \[2|3\]
    exit 1
fi

IMAGE_FILE=$1
SVN_REPO=$2
VERSION=$3
SDK=$4
TEA="no"

if [ ${VERSION} = "500a" ]
then
    USE_EBODA_INSTALL="yes";
    TEA="YES";
fi

if [ ${VERSION} = "500minia" ]
then
    USE_EBODA_INSTALL="yes";
    TEA="YES";
fi


if [ ${VERSION} = "500a" -o ${VERSION} = "500minia" -o ${VERSION} = "500" -o ${VERSION} = "500mini" -o ${VERSION} = "500plus" ]
then
    echo Patching firmware variant ${VERSION}
else
    echo Wrong firmware variant
    exit 1
fi

if [ ${SDK} = "2" -o ${SDK} = "3" ]
then
    echo Patching SDK version ${SDK}
else
    echo Wrong firmware variant
    exit 1
fi


####################
# CHECKING prequisites
#

#checking original firmware presence

[ -f ${IMAGE_FILE} ] || ( echo "Original install.img not found" &&  exit 3 )
echo Original install.img not found, continuing


if [ -d ${SVN_REPO}/.svn ]
then
    echo SVN dir ${SVN_REPO} found, continuing
else
    echo  Wrong argument given, please suppply absolute path to SVN directory in first argument
    exit 1
fi

#checking Resources and other directories presence
if [ ! -d ${SVN_REPO}/src/${VERSION}/Resource ]
then
    echo Resources not found, repository incomplete
    exit 1
fi

if [ ! -d ${SVN_REPO}/src/bin ]
then
    echo bin not found, repository incomplete
    exit 1
fi

if [ ! -d ${SVN_REPO}/src/${VERSION}/image ]
then
    echo image not found, repository incomplete
    exit 1
fi
echo "All resources and directories found, continuing"

#cheking unyaffs tools
which unyaffs >/dev/null
if [ $? -eq 1 ]
then
    echo 'required tool unyaffs not in PATH, please update PATH or copy unyaffs binary in "/usr/bin"'
    exit
fi

which mkyaffs2image >/dev/null
if [ $? -eq 1 ]
then
    echo 'required tool unyaffs not in PATH, please update PATH or copy mkyaffs2image binary in "/usr/bin"'
    exit
fi
echo unyaffs tools apre present

#
# CHECKING prequisites
####################


####################
# modifying firmware


# unpack img
mkdir unpacked_install
[ $? -eq 0 ] || exit 'cannot create "unpacked_install" dir please start from a clean directory'

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

if [ ${SDK} = "2" ]
then
    unyaffs ../yaffs2_1.img
elif [ ${SDK} = "3" ]
then
    if [ $TEA = "YES" ]
    then
	tea -d -i ../squashfs1.upg -o ../squashfs1.img -k 12345678195454322338264935438139
	rm ../squashfs1.upg
    fi
    unsquashfs ../squashfs1.img 
    cd squashfs-root
fi


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

# and rss_ex requirements
mkdir rss_ex
ln -s ../etc/translate/rss usr/local/bin/rss

# and scripts for me to play
mkdir scripts

# and xLive for me to play
mkdir xLive

# and utilities for me to play
mkdir utilities



#home dir for root part 1
sed -i -e '/^root/c\
root::0:0:root:/usr/local/etc/root:/bin/sh' etc/passwd

# traducere + font
#cp  ${SVN_REPO}/src/${VERSION}/Resource/*.str usr/local/bin/Resource 
cp  ${SVN_REPO}/src/${VERSION}/Resource/*.TTF usr/local/bin/Resource 

# screensaver + skinpack
# keeping original files
#cp  ${SVN_REPO}/src/${VERSION}/Resource/bmp/* usr/local/bin/Resource/bmp 
#cp  ${SVN_REPO}/src/${VERSION}/image/* usr/local/bin/image 

# awk
cp  ${SVN_REPO}/src/bin/* usr/bin
chmod +x usr/bin/*

# eboda web control panel
dir=`pwd`
cd ${SVN_REPO}/www/
find ewcp | grep -v .svn | grep -v '~' | zip -9 ${dir}/ewcp.zip -@
cp ewcp-version.txt ${dir}/ewcp-version.txt
cd $dir

# /cb3pp
dir=`pwd`
cd ${SVN_REPO}/src/
find cb3pp | grep -v .svn | grep -v '~'  | zip -9 ${dir}/cb3pp.zip -@
cp cb3pp-version.txt ${dir}/cb3pp-version.txt
cd $dir

# IMS menu
if [ ${SDK} = "2" ]
then
    cp ${SVN_REPO}/src/${VERSION}/menu/menu.rss usr/local/bin/scripts/
    [ -d usr/local/bin/scripts/image ] || mkdir usr/local/bin/scripts/image
    cp ${SVN_REPO}/src/${VERSION}/menu/image/* usr/local/bin/scripts/image/
elif [ ${SDK} = "3" ]
then
    
    echo to complete
fi
#rss_ex

#www
cp ${SVN_REPO}/scripts/feeds/rss_ex/rss_ex/www/cgi-bin/* tmp_orig/www/cgi-bin/
chmod +x tmp_orig/www/cgi-bin/*

[ -d tmp_orig/www/bin/ ] || mkdir tmp_orig/www/bin/
cp ${SVN_REPO}/scripts/feeds/rss_ex/rss_ex/www/bin/* tmp_orig/www/bin/
chmod +x tmp_orig/www/bin/*

#[ -d tmp_orig/www/img/ ] || mkdir tmp_orig/www/img/
#cp ${SVN_REPO}/scripts/feeds/rss_ex/rss_ex/www/img/* tmp_orig/www/img/


#media translate
# no space in firmware, latest version will be downloaded from internet
# dir=`pwd`
cd ${SVN_REPO}/scripts/feeds/zero_version/rss_ex/
find rss_ex/ | grep -v .svn | grep -v '~' | grep -v 'www' | zip -9 ${dir}/rss_ex.zip -@
cp rss_ex-version.txt ${dir}/rss_ex-version.txt
cd ${dir}


# vb6 bin
# bin is in /scripts/bin


# vb6 cgi-bin
cp ${SVN_REPO}/scripts/feeds/scripts_vb6/scripts/cgi-bin/* tmp_orig/www/cgi-bin/
chmod +x tmp_orig/www/cgi-bin/*


# vb6 scripts
# no space in firmware, latest version will be downloaded from internet
# dir=`pwd`
cd ${SVN_REPO}/scripts/feeds/zero_version/scripts_vb6/
find scripts | grep -v .svn | grep -v '~' | grep -v 'cgi-bin' | zip -9 ${dir}/scripts.zip -@
cp scripts-version.txt ${dir}/scripts-version.txt
cd ${dir}

# xLive
#out because no space.
#I should make script to take-it from internet!
#dir=`pwd`
cd ${SVN_REPO}/scripts/feeds/zero_version/xLive
find xLive | grep -v .svn | grep -v '~' | zip -9 ${dir}/xLive.zip -@
cp xLive-version.txt ${dir}/xLive-version.txt
cd ${dir}

#patch DvdPlayer binary

#bspatch oldfile newfile patchfile
if [ ${VERSION} = "500mini" ]
then

    bspatch usr/local/bin/DvdPlayer usr/local/bin/DvdPlayer.patched ${SVN_REPO}/src/500mini/DvdPlayer.bspatch
    mv usr/local/bin/DvdPlayer.patched usr/local/bin/DvdPlayer 
    chmod +x usr/local/bin/DvdPlayer
fi

#packaging root back
if [ ${SDK} = "2" ]
then
    cd ..
    rm yaffs2_1.img
    mkyaffs2image unpacked_root yaffs2_1.img 
elif [ ${SDK} = "3" ]
then
    mksquashfs * ../../squashfs1.img -b 65536
    cd  ..
    if [ $TEA = "YES" ]
    then
	tea -e -i ../squashfs1.img -o ../squashfs1.upg -k 12345678195454322338264935438139
	rm ../squashfs1.img
    fi
    cd ..
fi


rm -rf unpacked_root/

#unpacking /usr/local/etc
mkdir unpacked_etc
[ $? -eq 0 ] || exit cannot create dir please start from a clean directory


cd unpacked_etc/

tar jxvf ../usr.local.etc.tar.bz2

#root home part 2
mkdir root

#rss_ex
ln -s  /rss_ex translate


# keep this to be mine
# later update to come for external images of xtreamer
# cp ${SVN_REPO}/src/${VERSION}/etc/rcS .

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
[ -d ${storage}/rss_ex ] || mkdir ${storage}/rss_ex
[ -d ${storage}/ewcp ] || mkdir ${storage}/ewcp
[ -d ${storage}/xLive ] || mkdir ${storage}/xLive

if [ ! -f /cb3pp/.overmounted ];then
    echo overmount start
    mount -o bind ${storage}/cb3pp /cb3pp
    touch /cb3pp/.overmounted
    echo overmount end
fi

if [ ! -f /xLive/.overmounted ];then
    echo overmount start
    mount -o bind ${storage}/xLive /xLive
    touch /xLive/.overmounted
    echo overmount end
fi


if [ ! -f /rss_ex/.overmounted ];then
    echo overmount start
    mount -o bind ${storage}/rss_ex /rss_ex
    touch /rss_ex/.overmounted
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

	[ -f  ${storage}/cb3pp/etc/init.s/S99ewcp ] || cp  ${storage}/ewcp/S99ewcp  ${storage}/cb3pp/etc/init.d
        chmod +x ${storage}/cb3pp/etc/init.d/S99ewcp
fi


# check if .../rss_ex from us, if not, unpack
SERIAL=0
 [ -f ${storage}/rss_ex-version.txt ] && . ${storage}/rss_ex-version.txt
DISK_SERIAL=${SERIAL}
[ -f /rss_ex-version.txt ] && . /rss_ex-version.txt

if [ ${SERIAL} -gt ${DISK_SERIAL} -o ! -f /rss/menuEx.rss ]
then
        rm -rf ${storage}/rss_ex/*
        cd ${storage}
        unzip -o /rss_ex.zip
	cp /rss_ex-version.txt ${storage}/rss_ex-version.txt
fi


# check if .../scripts from us, if not, unpack
SERIAL=0
 [ -f ${storage}/scripts-version.txt ] && . ${storage}/scripts-version.txt
DISK_SERIAL=${SERIAL}
[ -f /scripts-version.txt ] && . /scripts-version.txt

if [ ${SERIAL} -gt ${DISK_SERIAL} -o ! -f /scripts/menu.rss ]
then
        rm -rf ${storage}/scripts/*
        cd ${storage}
        unzip -o /scripts.zip
	cp /scripts-version.txt ${storage}/scripts-version.txt
fi



# check if .../xLive from us, if not, unpack
SERIAL=0
 [ -f ${storage}/xLive-version.txt ] && . ${storage}/xLive-version.txt
DISK_SERIAL=${SERIAL}
[ -f /xLive-version.txt ] && . /xLive-version.txt

if [ ${SERIAL} -gt ${DISK_SERIAL} -o ! -f /xLive/menu.rss ]
then
        rm -rf ${storage}/xLive/*
        cd ${storage}
        unzip -o /xLive.zip
	cp /xLive-version.txt ${storage}/xLive-version.txt
fi



# check if .../ewcp installed from us, if not, unpack
SERIAL=0
 [ -f ${storage}/ewcp-version.txt ] && . ${storage}/ewcp-version.txt
DISK_SERIAL=${SERIAL}
[ -f /ewcp-version.txt ] && . /ewcp-version.txt

if [ ${SERIAL} -gt ${DISK_SERIAL} -o ${SERIAL} -eq 0 ]
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


#addind my startup to standard startup procedure
echo '
[ -f /usr/local/etc/rccb3ppS ] && sh /usr/local/etc/rccb3ppS &' >> rcS

#packing back /usr/local/etc
rm ../usr.local.etc.tar.bz2
tar jcvf ../usr.local.etc.tar.bz2 *
cd ..
rm -rf unpacked_etc/

#packing the normal image

cd ..

#copy eboda installer
rm install_*
cp ${SVN_REPO}/src/${VERSION}/install/install_a .

#patch size
sed -i -e 's#<sizeBytesMin>0x3000000</sizeBytesMin>#<sizeBytesMin>0x0800000</sizeBytesMin>#g' configuration.xml


mv ../${IMAGE_FILE} ../${IMAGE_FILE}.orig
tar cvf ../${IMAGE_FILE} *
cd ..
ls -l

}
