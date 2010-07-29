#!/bin/sh

if [ 1 == 0 ] 
then
wget http://hdforall.googlecode.com/files/scripts.zip -O /tmp/scripts.zip

svn rm scripts
svn ci -m 'scripts update step 1'

unzip /tmp/scripts.zip

./change_path.sh

svn add scripts
svn ci -m 'scripts update step 2'
fi
