#!/bin/sh


echo this script will automagically download/compile and prepare 3pp selection by cipibad for realtek based players
echo the binaries cand be included in any custom firmware

PATH=/cb3pp/bin:$PATH
export PATH

# set clean to true to make clean for all packages
CLEAN=true


#ssl for btpd
openssl=false

lighttpd=false
pcre=false
php=true


btpd=false


#!!!!!! do not use apache for now !!!!!
apache=false

rutorrent=false
rtgui=false

iconv=false
libxml2=false
xmlrpc=false

expat=false

curl=false
dtach=false
libsigc=false
libtorrent=false
ncurses=false
rtorrent=false
#!!!!!! do not use transmission for now !!!!
transmission=false

smbd=false

strip=false
#
# !!!!! tricks
#

# sudo mount -o bind /usr/local/toolchain_mipsel/ /mnt/toolchain_build/buildroot/build_mipsel_nofpu/staging_dir/mipsel-linux-uclibc/

# #TODO
# # here copy some toolchain libs to /.../lib

#  cp /mnt/toolchain_build/buildroot/build_mipsel_nofpu/staging_dir/mipsel-linux-uclibc/lib/libstdc++.so.6 /cb3pp/lib

# # cp /mnt/toolchain_build/buildroot/build_mipsel_nofpu/staging_dir/mipsel-linux-uclibc/lib/libstdc++.so.6 target/cb3pp/lib

#  cp /mnt/toolchain_build/buildroot/build_mipsel_nofpu/staging_dir/mipsel-linux-uclibc/lib/libm.so.0 /cb3pp/lib

# # cp /mnt/toolchain_build/buildroot/build_mipsel_nofpu/staging_dir/mipsel-linux-uclibc/lib/libm.so.0 target/cb3pp/lib


#  cp /mnt/toolchain_build/buildroot/build_mipsel_nofpu/staging_dir/mipsel-linux-uclibc/lib/libgcc_s.so.1 /cb3pp/lib

# cp /mnt/toolchain_build/buildroot/build_mipsel_nofpu/staging_dir/mipsel-linux-uclibc/lib/libgcc_s.so.1 target/cb3pp/lib


# cp  /cb3pp/lib

# cp  target/cb3pp/lib


#
# global variables setup
#

cipibad=/cb3pp


source=`pwd`/source/${cipibad}

compile=`pwd`/compile
patches=`pwd`/patches

target=`pwd`/target/${cipibad}

downloads=`pwd`/downloads
download_cmd=wget

[ -d $target ]		|| mkdir -p $target
[ -d $downloads ]	|| mkdir -p $downloads
[ -d $compile ]		|| mkdir -p $compile
[ -d $target/lib ]	|| mkdir -p $target/lib
[ -d $target/bin ]	|| mkdir -p $target/bin
[ -d $target/sbin ]	|| mkdir -p $target/sbin



#
# download of all packages
#

cd $downloads

# openssl-0.9.7g
$openssl && ( [ -f openssl-0.9.7g.tar.gz ] || $download_cmd http://www.openssl.org/source/openssl-0.9.7g.tar.gz )

# libiconv-1.10
$iconv && ( [ -f libiconv-1.10.tar.gz ] || $download_cmd http://ftp.gnu.org/pub/gnu/libiconv/libiconv-1.10.tar.gz )

# libxml2-2.6.20
$libxml2 && ( [ -f libxml2-2.6.20.tar.gz ] || $download_cmd http://xmlsoft.org/sources/old/libxml2-2.6.20.tar.gz )


# xmlrpc-1.06.27.tgz
$xmlrpc && (  [ -f xmlrpc-1.12.00.tgz ] || $download_cmd http://xmlrpc-c.svn.sourceforge.net/viewvc/xmlrpc-c/release_number/1.12.00.tar.gz?view=tar -O xmlrpc-1.12.00.tgz)


# expat-2.0.0.tar.gz
$expat && (  [ -f expat-2.0.0.tar.gz ] || $download_cmd http://sourceforge.net/projects/expat/files/expat/2.0.0/expat-2.0.0.tar.gz/download )
# pcre-4.4.tar.gz
$pcre && (  [ -f pcre-4.4.tar.gz ] || $download_cmd http://sourceforge.net/projects/pcre/files/pcre/4.4/pcre-4.4.tar.gz/download )
# php-5.0.5.tar.gz
$php && (  [ -f php-5.1.6.tar.gz ] || $download_cmd http://museum.php.net/php5/php-5.1.6.tar.gz )
# lighttpd-1.4.15.tar.gz
$lighttpd && (  [ -f lighttpd-1.4.15.tar.gz ] || $download_cmd http://download.lighttpd.net/lighttpd/releases-1.4.x/lighttpd-1.4.15.tar.gz )

$apache && (  [ -f apache_1.3.37.tar.gz ] || $download_cmd http://archive.apache.org/dist/httpd/apache_1.3.37.tar.gz )


$curl && (  [ -f curl-7.14.0.tar.gz ] || $download_cmd http://curl.haxx.se/download/curl-7.14.0.tar.gz )

$dtach && (  [ -f dtach-0.8.tar.gz ] || $download_cmd http://sourceforge.net/projects/dtach/files/dtach/0.8/dtach-0.8.tar.gz/download )

$libsigc && (  [ -f libsigc++-2.0.18.tar.gz ] || $download_cmd http://ftp.gnome.org/pub/GNOME/sources/libsigc++/2.0/libsigc++-2.0.18.tar.gz )

$libtorrent && (  [ -f libtorrent-0.12.5.tar.gz ] || $download_cmd http://libtorrent.rakshasa.no/downloads/libtorrent-0.12.5.tar.gz )

$ncurses && (  [ -f ncurses-5.7.tar.gz ] || $download_cmd http://ftp.gnu.org/gnu/ncurses/ncurses-5.7.tar.gz )

$rtorrent && (  [ -f rtorrent-0.8.5.tar.gz ] || $download_cmd http://libtorrent.rakshasa.no/downloads/rtorrent-0.8.5.tar.gz )


$btpd && ( [ -f btpd-0.15.tar.gz ] || $download_cmd http://www.murmeldjur.se/btpd/btpd-0.15.tar.gz )

$smbd && ( [ -f samba-3.5.2.tar.gz ] || $download_cmd http://www.samba.org/samba/ftp/stable/samba-3.5.2.tar.gz )



$rutorrent && ( [ -f rutorrent-3.0.tar.gz ] || $download_cmd http://rutorrent.googlecode.com/files/rutorrent-3.0.tar.gz )


$rtgui && ( [ -f rtgui-0.2.7.tgz ] || $download_cmd http://rtgui.googlecode.com/files/rtgui-0.2.7.tgz )



#
# openssl installation
#

if [ $openssl == true ]
then
    cd $compile
    tar zxf $downloads/openssl-0.9.7g.tar.gz
    cd openssl-0.9.7g
    ./Configure linux-mipsel:mipsel-linux-gcc  --prefix=/${cipibad} --openssldir=/${cipibad}/openssl
    $CLEAN && make clean
    make
    make install

#
# openssl target
#

# nothing, statically linked

fi

#
# iconv installation
#


if [ $iconv == true ]
then

    cd $compile
    tar zxf $downloads/libiconv-1.10.tar.gz
    cd libiconv-1.10
    ./configure --prefix=${cipibad} --host=mipsel-linux 
    $CLEAN && make clean
    make
    make install


#
# iconv target
#

    cp ${cipibad}/lib/libiconv.so.2 $target/lib

fi


#
# libxml2 installation
#


if [ $libxml2 == true ]
then

    cd $compile
    tar zxf $downloads/libxml2-2.6.20.tar.gz
    cd libxml2-2.6.20
    ./configure --prefix=${cipibad} --host=mipsel-linux 
    $CLEAN && make clean
    make
    make install


#
# libxml2 target
#

    cp ${cipibad}/lib/libxml2.so.2 $target/lib

fi



#
# xmlrpc installation
#

if [ $xmlrpc == true ]
then
    cd $compile
    tar zxf $downloads/xmlrpc-1.12.00.tgz
    cd 1.12.00
    chmod +x ./configure
    ./configure --prefix=${cipibad} --host=mipsel-linux --enable-libxml2-backend
    $CLEAN && make clean
    make
    chmod +x ./install.sh
    make install

#
# xmlrpc target
#

cp ${cipibad}/lib/libxmlrpc_server.so.3 $target/lib
cp ${cipibad}/lib/libxmlrpc.so.3 $target/lib
cp ${cipibad}/lib/libxmlrpc_util.so.3 $target/lib

fi


if [ $expat == true ]
then
    cd $compile
    tar zxf $downloads/expat-2.0.0.tar.gz
    cd expat-2.0.0
    ./configure --prefix=${cipibad} --host=mipsel-linux
    $CLEAN && make clean
    make
    make install

#
# expat target
#
cp ${cipibad}/lib/libexpat.so.1 $target/lib


fi

if [ $pcre == true ]
then
    cd $compile
    tar zxf $downloads/pcre-4.4.tar.gz
    cd pcre-4.4
    ./configure --prefix=${cipibad} --host=mipsel-linux 
    $CLEAN && make clean
    gcc -c -g -O2 -I. ./dftables.c
    gcc -g -O2 -I. -I. -o dftables dftables.o
    make
    make install

#
# pcre target
#

cp ${cipibad}/lib/libpcre.so.0 $target/lib


fi

if [ $php == true ]
then
    cd $compile
    tar zxf $downloads/php-5.1.6.tar.gz
    cd php-5.1.6
    cat >config.cache <<EOF
ac_cv_func_getaddrinfo=yes
EOF

    CC=mipsel-linux-gcc ./configure --prefix=${cipibad} --host=mipsel-linux --disable-all --disable-cli --enable-fastcgi --enable-discard-path --disable-ipv6  --enable-session --cache-file=`pwd`/config.cache --enable-sockets --with-pcre-regex=/cb3pp/ --enable-shared=false --enable-static=true
    $CLEAN && make clean
    make
    make install

#
# php target
#

cp ${cipibad}/bin/php $target/bin

fi

if [ $lighttpd == true ]
then
    cd $compile
    tar zxf $downloads/lighttpd-1.4.15.tar.gz
    cd lighttpd-1.4.15
    ./configure --prefix=${cipibad} --host=mipsel-linux --disable-ipv6
    $CLEAN && make clean
    make
    make install

#
# lighttpd target
#

cp ${cipibad}/sbin/lighttpds $target/sbin

    
fi


if [ $apache == true ]
then
    cd $compile
    tar zxf $downloads/apache_1.3.37.tar.gz
    cd apache_1.3.37
    CC=mipsel-linux-gcc ./configure --prefix=${cipibad}
    $CLEAN && make clean

    patch -p0 < ${patches}/httpd-1.patch
    make
    make install

#
# lighttpd target
#
# !!! don't install apache now !!!
#cp ${cipibad}/bin/httpd $target/bin

    
fi




#
# building curl
#
if [ $curl == true ]
then
    cd $compile
    tar zxf $downloads/curl-7.14.0.tar.gz
    cd curl-7.14.0
    ./configure --prefix=${cipibad} --host=mipsel-linux
    $CLEAN && make clean
    make
    make install

#
# TODO: curl target
#
cp ${cipibad}/lib/libcurl.so.3 $target/lib


fi


if [ $dtach == true ]
then
    cd $compile
    tar zxf $downloads/dtach-0.8.tar.gz
    cd dtach-0.8
    ./configure --prefix=${cipibad} --host=mipsel-linux 
    $CLEAN && make clean
    make
    cp dtach ${cipibad}/bin/

#
# dtach target
#

cp ${cipibad}/bin/dtach $target/bin

fi




if [ $libsigc == true ]
then
    cd $compile
    tar zxf $downloads/libsigc++-2.0.18.tar.gz
    cd libsigc++-2.0.18
    ./configure --prefix=${cipibad} --host=mipsel-linux 
    $CLEAN && make clean
    make
    make install

#
# TODO: libsig target
#

cp ${cipibad}/lib/libsigc-2.0.so.0 $target/lib

fi


if [ $libtorrent == true ]
then
    cd $compile
    tar zxf $downloads/libtorrent-0.12.5.tar.gz
    cd libtorrent-0.12.5
    STUFF_CFLAGS="-I/cb3pp/include -I/cb3pp/include/sigc++-2.0 -I/cb3pp/lib/sigc++-2.0/include" STUFF_LIBS="-L/cb3pp/lib -lsigc-2.0" OPENSSL_CFLAGS="-I/cb3pp/include" OPENSSL_LIBS="-L/cb3pp/lib -lssl -lcrypto" ./configure --prefix=${cipibad} --host=mipsel-linux --enable-aligned
    $CLEAN && make clean
    make
    make install

#
# TODO: libtorrent target
#
cp ${cipibad}/lib/libtorrent.so.9 $target/lib

fi
if [ $ncurses == true ]
then
    cd $compile
    tar zxf $downloads/ncurses-5.7.tar.gz
    cd ncurses-5.7
    ./configure --prefix=${cipibad} --host=mipsel-linux 
    $CLEAN && make clean
    make
    make install

#
# TODO ncurses target
#


fi


if [ $rtorrent == true ]
then
    cd $compile
    tar zxf $downloads/rtorrent-0.8.5.tar.gz
    cd rtorrent-0.8.5
    patch -p0 < ${patches}/rtorrent-1.patch
    PATH=$PATH:/cb3pp/bin/ LIBS="-L/cb3pp/lib" sigc_CFLAGS="-I/cb3pp/include/ncurses/ -I/cb3pp/include -I/cb3pp/include/sigc++-2.0 -I/cb3pp/lib/sigc++-2.0/include" sigc_LIBS="-L/cb3pp/lib -lsigc-2.0 -ltorrent" libcurl_CFLAGS="-I/cb3pp/lib" libcurl_LIBS="-L/cb3pp/lib -lcurl" OPENSSL_CFLAGS="-I/cb3pp/include" OPENSSL_LIBS="-L/cb3pp/lib -lssl -lcrypto" ./configure --prefix=${cipibad} --host=mipsel-linux --with-xmlrpc-c
    $CLEAN && make clean
    make
    make install

#
# rtorrent target
#

cp ${cipibad}/bin/rtorrent $target/bin

fi




if [ $btpd == true ]
then
    cd $compile
    tar zxf $downloads/btpd-0.15.tar.gz
    cd btpd-0.15
    patch -p1 < ${patches}/btpd-1.patch
    CFLAGS="-I/cb3pp/include" LIBS="-L/cb3pp/lib" ./configure --prefix=${cipibad} --host=mipsel-linux 
    $CLEAN && make clean
    make
    make install

#
# TODO ncurses target
#


fi


if [ $smbd == true ]
then
    cd $compile
    tar zxf $downloads/samba-3.5.2.tar.gz
    cd samba-3.5.2
    CFLAGS="-I/cb3pp/include" LIBS="-L/cb3pp/lib" ./configure --prefix=${cipibad} --host=mipsel-linux 
    $CLEAN && make clean
    make
    make install

#
# TODO ncurses target
#


fi













#
#web gui install

if [ $rtgui == true ]
then

    [ -d ${target}/share/www ] || mkdir -p ${target}/share/www
    
    cd ${target}/share/www
    
    rm -rf rtgui*
    tar zxf ${downloads}/rtgui-0.2.7.tgz
    cd rtgui

cat > config.php <<EOF
<?php

include "config.php.example";

// Connect string for your local RPC/rTorrent connection:
\$rpc_connect="http://localhost:8081/RPC2";

?>
EOF

# // rtorrent 'watch' directory (used for upload torrent)
# \$watchdir="/tmp/hdd/volumes/HDD1/rtorrent/watch";

# // Path to report disk usage
# \$downloaddir="/tmp/hdd/volumes/HDD1/rtorrent/download";

fi



# cd /cb3pp/share/www
# rm -rf rtgui*
# wget http://rtgui.googlecode.com/files/rtgui-0.2.7.tgz
# /cb3pp/bin/gunzip rtgui-0.2.7.tgz
# tar xvf rtgui-0.2.7.tar
# cd /cb3pp/share/www/rtgui

# cat > config.php <<EOF
# <?php

# include "config.php.example";

# // Connect string for your local RPC/rTorrent connection:
# \$rpc_connect="http://localhost:8081/RPC2";

# // rtorrent 'watch' directory (used for upload torrent)
# \$watchdir="/tmp/hdd/volumes/HDD1/rtorrent/watch";

# // Path to report disk usage
# \$downloaddir="/tmp/hdd/volumes/HDD1/rtorrent/download";

# ?>
# EOF
# cd ..
# rm rtgui-0.2.7.tar


#strip all in target

#Second web gui install
if [ $rutorrent == true ]
then

    [ -d ${target}/share/www ] || mkdir -p ${target}/share/www
    
    cd ${target}/share/www
    
    rm -rf rutorrent*
    tar zxf ${downloads}/rutorrent-3.0.tar.gz
    cd rutorrent/conf
    mv config.php config.php.dist
    cat > config.php <<EOF
<?php

include "config.php.dist";

\$scgi_port = 0;
\$scgi_host = "unix:///tmp/rpc.socket";
?>
EOF

fi



#
# install startup scripts and other configuration
#

# cd ${source}
# cp -a . ${target}


#
# strip
#
if [ $strip == true ]
then
    
    mipsel-linux-strip -s $target/sbin/*
    mipsel-linux-strip -s $target/bin/*
    mipsel-linux-strip -s $target/lib/*

fi

sudo umount /mnt/toolchain_build/buildroot/build_mipsel_nofpu/staging_dir/mipsel-linux-uclibc/
