#dynamic

./configure --prefix=/opt --host=mipsel-linux --disable-ipv6 --disable-lfs --without-mysql --without-ldap --without-attr --without-valgrind --without-openssl --without-kerberos5 --without-pcre --without-zlib --without-bzip2 --without-webdav-props --without-webdav-locks --without-gdbm --without-memcache --without-lua


#static

./configure --prefix=/opt --host=mipsel-linux --disable-ipv6 --disable-lfs --without-mysql --without-ldap --without-attr --without-valgrind --without-openssl --without-kerberos5 --without-pcre --without-zlib --without-bzip2 --without-webdav-props --without-webdav-locks --without-gdbm --without-memcache --without-lua --enable-static
