#!/bin/sh

echo "Content-type: text/html"
echo
echo "<html><head><title>Eboda Web Control Panel update</title></head><body bgcolor=\"#000000\" text=\"#FFFFFF\"><br><br><br><pre>"

echo Eboda Web Control Panel is updating.

workdir=`pwd`
tmpdir=/tmp

cd $tmpdir && echo DIR changend to $tmpdir
wget http://eboda-hd-for-all-500.googlecode.com/files/ewcp-latest.zip && echo Got latest package
if [ $? -ne 0 ]
then
echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> '
exit
fi
mkdir dir_$$ && echo created new package dir
cd dir_$$ && echo DIR changed to dir$$
unzip ../ewcp-latest.zip && echo new package extracted
newserial=`grep SERIAL current_version.txt  | cut -d'=' -f 2` && echo new serial is $newserial
oldserial=`grep SERIAL $workdir/current_version.txt  | cut -d'=' -f 2` && echo old serial is $oldserial
cd ..
rm -rf dir_$$
[ $newserial -le $oldserial ] && echo you already have the latest version && 
echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> ' && exit 1

cd $workdir && echo we will update

tar cvf ../ewcp-${oldserial}.tar *
if [ $? -eq 0 ]
then
	rm -rf `ls -1 | grep -v UniCGI.cgi` && echo backup was OK, cleaning old install
else
	echo Cannot make backup. Exiting ...
	echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> '
	exit 1
fi

unzip $tmpdir/ewcp-latest.zip && echo new package extracted
rm $tmpdir/ewcp-latest.zip && echo temp files removed

echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> '

echo "</pre><br></body></html>"

