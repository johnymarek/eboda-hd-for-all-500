#!/bin/sh

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

if [ ! -d $1/src/Resource ]
then
    echo resources not found, repository incomplete
    exit 1
fi

if [ ! -d $1/src/bin ]
then
    echo bin not found, repository incomplete
    exit 1
fi

if [ ! -d $1/src/image ]
then
    echo mage not found, repository incomplete
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
tar xvf ../install.img

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

# opt directory for optware
mkdir opt

#home dir for root part 1
sed -i -e '/^root/c\
root::0:0:root:/usr/local/etc/root:/bin/sh' etc/passwd

## traducere + font + servicii
#cp  $1/src/Resource/* usr/local/bin/Resource 

#doar font
cp  $1/src/Resource/ARIALUNI.TTF usr/local/bin/Resource 



# screensaver + skinpack
#cp  $1/src/Resource/bmp/* usr/local/bin/Resource/bmp 
#cp  $1/src/image/* usr/local/bin/image 

# awk
cp  $1/src/bin/* usr/bin

# eboda web control panel
mkdir tmp_orig/www/cgi-bin/ewcp
cp  $1/www/cgi/* tmp_orig/www/cgi-bin/ewcp
cp $1/www/ewcp.html tmp_orig/www/
chmod +x tmp_orig/www/cgi-bin/ewcp/*


# /opt
dir=`pwd`
cd $1/src/
tar cvf ${dir}/opt.tar --exclude mplayer --exclude .svn opt
cd ${dir}
zip opt.zip opt.tar
rm opt.tar

# cgi-bin
cp $1/scripts/feeds/scripts_vb6/cgi-bin/mf/* tmp_orig/www/cgi-bin/
cp $1/scripts/feeds/scripts_vb6/cgi-bin/vb6/* tmp_orig/www/cgi-bin/
chmod +x tmp_orig/www/cgi-bin/*

# menu
cp -r $1/scripts/feeds/scripts_vb6/menu/* usr/local/bin/scripts/
#rename weather menu pictures
mv usr/local/bin/IMS_Modules/Weather/image/weather_focus.jpg usr/local/bin/IMS_Modules/Weather/image/weather_focus_en.jpg
mv usr/local/bin/IMS_Modules/Weather/image/weather_unfocus.jpg usr/local/bin/IMS_Modules/Weather/image/weather_unfocus_en.jpg
# scripts
dir=`pwd`
cd $1/scripts/feeds/scripts_vb6/
tar cvf ${dir}/scripts.tar --exclude .svn scripts
cd ${dir}
zip scripts.zip scripts.tar
rm scripts.tar

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


# creating our startup script to install opt stuff if not in
echo '#!/bin/sh
#BEGIN CBA_OPT_STARTUP
# wait HDD to start (should be no issue if no internal HDD) and run rcS from opt if present

#TODO find what to check instead root which exists even if not mounted?

n=1
mount | grep HDD1
while [ $? -ne 0 ] ; do
sleep 3
[ $n -gt 30 ] && break
let n+=1
echo "#waiting for hdd.."
mount | grep HDD1
done

if [ $n -gt 30 ]
then
	echo HDD not mounted, probably not existing
else
#HDD online
# check if .../opt installed from us, if not, unpack
if [ ! -f /tmp/hdd/root/opt/.modified_full_firmware ]
then
	rm -rf /tmp/hdd/root/opt/
	mkdir /tmp/hdd/root/opt/
	cd /tmp/hdd/root/
	unzip -o /opt.zip 
	tar xvf opt.tar
	rm opt.tar
	touch /tmp/hdd/root/opt/.modified_full_firmware
fi
# check if .../scripts from us, if not, unpack
if [ ! -f /tmp/hdd/volumes/HDD1/scripts/.modified_full_firmware ]
then
        rm -rf /tmp/hdd/volumes/HDD1/scripts/
        mkdir /tmp/hdd/volumes/HDD1/scripts/
        cd /tmp/hdd/volumes/HDD1/
        unzip -o /scripts.zip
	tar xvf scripts.tar
        rm scripts.tar
        touch /tmp/hdd/volumes/HDD1/scripts/.modified_full_firmware
fi

opt_startup=/tmp/hdd/root/opt/etc/init.d/rcS

# standard startup
[ -f $opt_startup ] && /bin/sh $opt_startup

fi
#END CBA_OPT_STARTUP' > rcoptS

chmod +x rcoptS

echo '
[ -f /usr/local/etc/rcoptS ] && sh /usr/local/etc/rcoptS' >> rcS


rm ../usr.local.etc.tar.bz2
tar jcvf ../usr.local.etc.tar.bz2 *
cd ..
rm -rf unpacked_etc/

cd ..
mv ../install.img ../install.img.orig
tar cvf ../install.img *
cd ..
ls -l

