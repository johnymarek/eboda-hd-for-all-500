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

# traducere + font + servicii
cp  $1/src/Resource/* usr/local/bin/Resource 

# screensaver + skinpack
cp  $1/src/Resource/bmp/* usr/local/bin/Resource/bmp 
cp  $1/src/image/* usr/local/bin/image 

# awk
cp  $1/src/bin/* usr/bin

# eboda web control panel
mkdir tmp_orig/www/cgi-bin/ewcp
cp  $1/www/cgi/* tmp_orig/www/cgi-bin/ewcp

# /opt
cp -r $1/src/opt/* opt/

# cgi-bin
cp $1/scripts/feeds/scripts_vb6/cgi-bin/mf/* tmp_orig/www/cgi-bin/
cp $1/scripts/feeds/scripts_vb6/cgi-bin/vb6/* tmp_orig/www/cgi-bin/


# menu
cp -r $1/scripts/feeds/scripts_vb6/menu/* usr/local/bin/scripts/


cd ..
rm yaffs2_1.img
mkyaffs2image unpacked_root yaffs2_1.img 

rm -rf unpacked_root/

mkdir unpacked_etc
[ $? -eq 0 ] || exit cannot create dir please start from a clean directory


cd unpacked_etc/

tar jxvf ../usr.local.etc.tar.bz2 *
mkdir root
rm ../usr.local.etc.tar.bz2
tar jcvf ../usr.local.etc.tar.bz2 *
cd ..
rm -rf unpacked_etc/

cd ..
mv ../install.img ../install.img.orig
tar cvf ../install.img *
cd ..
ls -l

