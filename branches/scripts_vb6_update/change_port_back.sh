#!/bin/sh


for i in ` find scripts | grep -v .svn ` 

do echo $i; 

grep 127.0.0.1 $i 
if [ $? -eq 0 ]
then
	echo changing port
#	sed -i -e 's/127.0.0.1:82/127.0.0.1:8081/g' $i
	sed -i -e 's#127.0.0.1:82/cgi-bin/#127.0.0.1/cgi-bin/#g' $i
fi

done
