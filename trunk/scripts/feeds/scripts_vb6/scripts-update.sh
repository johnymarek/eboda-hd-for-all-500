#!/bin/sh

if [ 1 == 0 ] 
then
wget http://hdforall.googlecode.com/files/scripts.zip -O /tmp/scripts.zip
wget http://forum.xtreamer.net/index.php?app=core&module=attach&section=attach&attach_id=4917 -0 /tmp/xLive9.zip



svn rm scripts
svn ci -m 'scripts update step 1'

mkdir scripts
mkdir scripts/scripts9

cd scripts
unzip /tmp/xLive9.zip
mv scripts/* scripts9
rmdir scripts
cd ..

unzip /tmp/scripts.zip



./change_path.sh

svn add scripts
svn ci -m 'scripts update step 2'
 fi
