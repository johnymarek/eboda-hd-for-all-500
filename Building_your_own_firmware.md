# Introduction #

Original Firmware from E-boda is not always well configured by default. And part of this configuration cannot be "repaired" after firmware installation. For this a procedure to modify firmware is usefull.


# Details #

## Requirements ##

You will need:
  * A PC with linux (real PC or a VmWare player with Linux image is good)
  * yaffs utils (from http://www.yaffs.net/)
    * you will need to compile the utils directly from sources if package not present on your linux distro
  * unyaffs util (from http://code.google.com/p/unyaffs/)
  * you can get required binaries from http://eboda-hd-for-all-500.googlecode.com/files/yaffs_utils.tbz and unpack them somewhere in your PATH ($HOME/bin for example)

## Unpack ##
  * recommended to start with a directory containing just the firmware you want to modify
```
bash-3.2$ ls
HD_for_all_500_ver_v7.0.18.r3617.rar
```
  * unrar the image
```
bash-3.2$ unrar x HD_for_all_500_ver_v7.0.18.r3617.rar 

UNRAR 3.71 beta 1 freeware      Copyright (c) 1993-2007 Alexander Roshal


Extracting from HD_for_all_500_ver_v7.0.18.r3617.rar

Extracting  install.img                                               OK 
All OK
```

  * unpack the image in a new directory
```
bash-3.2$ mkdir unpacked_install
bash-3.2$ cd unpacked_install/
bash-3.2$ tar xvf ../install.img 
FormatHDDAfterUpgrade_boiaoj230jtljaf9.txt
FormatHDDOnly_boiaoj230jtljaf9.txt
arial.ttf
audio_firmware.install.bin
busybox
configuration.xml
flash_erase
install_a
mkfs.jffs2
mkntfs
mkyaffs2image
nandwrite
package2/
package2/video_firmware.bin
package2/bluecore.audio
package2/usr.local.etc.tar.bz2
package2/vmlinux.develop.avhdd.mars.nand.bin
package2/yaffs2_1.img
video_firmware.install.bin
```

  * directory layout is this
```
bash-3.2$ tree 
.
|-- FormatHDDAfterUpgrade_boiaoj230jtljaf9.txt
|-- FormatHDDOnly_boiaoj230jtljaf9.txt
|-- arial.ttf
|-- audio_firmware.install.bin
|-- busybox
|-- configuration.xml
|-- flash_erase
|-- install_a
|-- mkfs.jffs2
|-- mkntfs
|-- mkyaffs2image
|-- nandwrite
|-- package2
|   |-- bluecore.audio
|   |-- usr.local.etc.tar.bz2
|   |-- video_firmware.bin
|   |-- vmlinux.develop.avhdd.mars.nand.bin
|   `-- yaffs2_1.img
`-- video_firmware.install.bin

1 directory, 18 files
```
  * the interesting part is in package2 directory, especially **yaffs2\_1.img** that is the root image
```
bash-3.2$ cd package2/
```
## Modify ##
### Modify root image ###
  * preparation
```
bash-3.2$ mkdir unpacked_root
bash-3.2$ cd unpacked_root/
bash-3.2$ unyaffs ../yaffs2_1.img 
```
  * directory layout is
```
bash-3.2$ tree -L 1
.
|-- Test.fat
|-- bin
|-- dev
|-- etc
|-- lib
|-- linuxrc -> bin/busybox
|-- mnt
|-- proc
|-- sbin
|-- sys
|-- tmp
|-- tmp_orig
|-- usr
|-- var -> tmp/
`-- vmlinux

12 directories, 3 files
```
  * OPTIONAL: create /opt directory (to be overmounted for optware)
```
mkdir opt
```
  * OPTIONAL: do whatever else you need (for example add home directory for root, directory has to be created in `/usr/local/etc` )
```
bash-3.2$ sed -ie '/^root/c\
root::0:0:root:/usr/local/etc/root:/bin/sh' etc/passwd
```
  * package
```
bash-3.2$ cd ..
bash-3.2$ rm yaffs2_1.img 
bash-3.2$ mkyaffs2image unpacked_root/ yaffs2_1.img
mkyaffs2image: image building tool for YAFFS2 built Apr 15 2010
Processing directory unpacked_root/ into image file yaffs2_1.img
Object 257, unpacked_root//mnt is a directory
Object 258, unpacked_root//mnt/hdc is a directory
....
Object 1460, unpacked_root//sbin/halt is a symlink to "../bin/busybox"
Object 1461, unpacked_root//sbin/insmod is a symlink to "../bin/busybox"
Object 1462, unpacked_root//sys is a directory
Operation complete.
1206 objects in 116 directories
40980 NAND pages
bash-3.2$ rm -rf unpacked_root/
```


### Modify `/usr/local/etc` image ###
  * preparation
```
bash-3.2$ mkdir unpacked_etc
bash-3.2$ cd unpacked_etc/
bash-3.2$ tar jxvf ../usr.local.etc.tar.bz2 
configsamba
....
ppp/pppoe.conf
profile
rcS
sata_mars.ko
```

  * OPTIONAL: make your own modifications here (for example create home directory for root)
```
bash-3.2$ mkdir root
```

  * package
```
bash-3.2$ rm ../usr.local.etc.tar.bz2 
bash-3.2$ tar jcvf ../usr.local.etc.tar.bz2 *
configsamba
....
sata_mars.ko
bash-3.2$ cd ..
bash-3.2$ rm -rf unpacked_etc/
```

## Pack ##
  * now we can package everything back (we will keep and rename old image for reference)
```
bash-3.2$ cd ..
bash-3.2$ mv ../install.img ../install.img.orig
bash-3.2$ tar cvf ../install.img *
FormatHDDAfterUpgrade_boiaoj230jtljaf9.txt
FormatHDDOnly_boiaoj230jtljaf9.txt
arial.ttf
audio_firmware.install.bin
busybox
configuration.xml
flash_erase
install_a
mkfs.jffs2
mkntfs
mkyaffs2image
nandwrite
package2/
package2/bluecore.audio
package2/video_firmware.bin
package2/vmlinux.develop.avhdd.mars.nand.bin
package2/usr.local.etc.tar.bz2
package2/yaffs2_1.img
video_firmware.install.bin
```
  * you can clean up and just go and try your new image
```
bash-3.2$ cd ..
bash-3.2$ ls -l
total 233936
-rw-r--r-- 1 cipibad avahi-autoipd  34590651 Apr 19 13:30 HD_for_all_500_ver_v7.0.18.r3617.rar
-rw-r--r-- 1 cipibad avahi-autoipd 102348800 Apr 19 14:07 install.img
-rw-r--r-- 1 cipibad avahi-autoipd 102348816 Mar 30 11:08 install.img.orig
drwxr-xr-x 3 cipibad avahi-autoipd      4096 Apr 19 13:35 unpacked_install
```
  * firmware for both mediaplayer versions can be found on download section http://code.google.com/p/eboda-hd-for-all-500/downloads/list
  * scripts used to build firmware are here: http://code.google.com/p/eboda-hd-for-all-500/source/browse/#svn/trunk/scripts/firmware