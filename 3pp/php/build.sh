#! /bin/sh
#
# Created by configure

CFLAGS='-L/usr/local/mipsel-linux/lib/ -ldl -g' \
CC='mipsel-linux-gcc' \
'./configure' \
'--host=mipsel-linux' \
'--prefix=/opt' \
'--enable-fastcgi' \
'--enable-discard-path' \
'--enable-force-cgi-redirect' \
'--with-xmlrpc' \
'--with-libxml-dir=/opt2' \
'--with-iconv=/opt2' \
'--without-sqlite3' \
'--without-pdo-sqlite' \
'--without-sqlite' \
"$@"

