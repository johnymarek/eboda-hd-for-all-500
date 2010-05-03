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

export CC=mipsel-linux-gcc
#! /bin/sh
#
# Created by configure
## TAKE 2

# replace first static wit extern in case of redefinition
LDFLAGS='-L/usr/local/mipsel-linux/lib -ldl -lpthread' \
CC='mipsel-linux-gcc' \
'./configure' \
'--enable-fastcgi' \
'--with-xmlrpc' \
'--with-libxml-dir=/opt' \
'--host=mipsel-linux' \
'--with-iconv=/opt' \
'--without-apxs' \
"$@"
#! /bin/sh
#
# Created by configure

LDFLAGS='-L/usr/local/mipsel-linux/lib -ldl -lpthread' \
CC='mipsel-linux-gcc' \
'./configure' \
'--with-xmlrpc' \
'--with-libxml-dir=/opt' \
'--host=mipsel-linux' \
'--with-iconv=/opt' \
'--disable-cli' \
'--prefix=/opt' \
'--enable-static' \
"$@"
