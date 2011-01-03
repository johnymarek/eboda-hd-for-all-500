#!/bin/sh


echo this script will automagically download/compile and prepare 3pp selection by cipibad for realtek based players
echo the binaries cand be included in any custom firmware

# set clean to true to make clean for all packages
CLEAN=false

rutorrent=false

openssl=false
iconv=false
libxml2=false
xmlrpc=false

expat=false
pcre=false
php=false
lighttpd=true

#
# !!!!! tricks
#

sudo mount -o bind /usr/local/toolchain_mipsel/ /mnt/toolchain_build/buildroot/build_mipsel_nofpu/staging_dir/mipsel-linux-uclibc/

#TODO
# here copy some toolchain libs to /.../lib

#
# global variables setup
#

cipibad=/cb3pp

compile=`pwd`/compile
target=`pwd`/target/${cipibad}

downloads=`pwd`/downloads
download_cmd=wget

[ -d $target ]		|| mkdir -p $target
[ -d $downloads ]	|| mkdir -p $downloads
[ -d $compile ]		|| mkdir -p $compile
[ -d $target/lib ]	|| mkdir -p $target/lib
[ -d $target/bin ]	|| mkdir -p $target/bin



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
$xmlrpc && (  [ -f xmlrpc-1.06.27.tgz ] || $download_cmd http://sourceforge.net/projects/xmlrpc-c/files/Xmlrpc-c%20Super%20Stable/1.06.27/xmlrpc-1.06.27.tgz/download )


# expat-2.0.0.tar.gz
$expat && (  [ -f expat-2.0.0.tar.gz ] || $download_cmd http://sourceforge.net/projects/expat/files/expat/2.0.0/expat-2.0.0.tar.gz/download )
# pcre-4.4.tar.gz
$pcre && (  [ -f pcre-4.4.tar.gz ] || $download_cmd http://sourceforge.net/projects/pcre/files/pcre/4.4/pcre-4.4.tar.gz/download )
# php-5.0.5.tar.gz
$php && (  [ -f php-5.0.5.tar.gz ] || $download_cmd http://museum.php.net/php5/php-5.0.5.tar.gz )
# lighttpd-1.4.15.tar.gz
$lighttpd && (  [ -f lighttpd-1.4.15.tar.gz ] || $download_cmd http://download.lighttpd.net/lighttpd/releases-1.4.x/lighttpd-1.4.15.tar.gz )




$rutorrent || [ -f rutorrent-3.0.tar.gz ] || $download_cmd http://rutorrent.googlecode.com/files/rutorrent-3.0.tar.gz

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
    tar zxf $downloads/xmlrpc-1.06.27.tgz
    cd xmlrpc-c-1.06.27
    ./configure --prefix=${cipibad} --host=mipsel-linux --enable-libxml2-backend
    $CLEAN && make clean
    make
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
    tar zxf $downloads/php-5.0.5.tar.gz
    cd php-5.0.5
    cat >config.cache <<EOF
ac_cv_func_getaddrinfo=yes
EOF

    CC=mipsel-linux-gcc ./configure --prefix=${cipibad} --host=mipsel-linux --disable-all --disable-cli --enable-fastcgi --enable-mbstring --with-xmlrpc --with-libxml-dir=${cipibad} --enable-libxml --cache-file=`pwd`/config.cache --with-expat-dir=${cipibad}  --with-iconv-dir=${cipibad} --enable-discard-path --disable-ipv6 --with-pcre-regex=${cipibad} --enable-session --cache-file=`pwd`/config.cache
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
# lighttpd
#

fi





#web gui install

# cd /opt/share/www
# rm -rf rtgui*
# wget http://rtgui.googlecode.com/files/rtgui-0.2.7.tgz
# /opt/bin/gunzip rtgui-0.2.7.tgz
# tar xvf rtgui-0.2.7.tar
# cd /opt/share/www/rtgui

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
# TODO: install startup scripts and other configuration
#