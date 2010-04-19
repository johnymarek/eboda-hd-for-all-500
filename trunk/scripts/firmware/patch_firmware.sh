#!/bin/sh

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

mkdir unpacked_install
[ $? -eq 0 ] || exit cannot create dir please start from a clean directory

cd unpacked_install/
tar xvf ../install.img
cd package2/

mkdir unpacked_root
[ $? -eq 0 ] || exit cannot create dir please start from a clean directory

cd unpacked_root/
unyaffs ../yaffs2_1.img

mkdir opt

sed -ie '/^root/c\
root::0:0:root:/usr/local/etc/root:/bin/sh' etc/passwd

cd ..
rm yaffs2_1.img
mkyaffs2image unpacked_root/ yaffs2_1.img
rm -rf unpacked_root/

mkdir unpacked_etc
[ $? -eq 0 ] || exit cannot create dir please start from a clean directory

cd unpacked_etc/
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

