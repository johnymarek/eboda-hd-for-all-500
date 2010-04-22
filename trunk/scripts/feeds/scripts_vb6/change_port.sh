#!/bin/sh


for i in ` find scripts | grep -v .svn ` 

do echo $i; 

grep 127.0.0.1:82 $i 
if [ $? -eq 0 ]
then
	echo changing port
	sed -i -e 's/127.0.0.1:82/127.0.0.1:8081/g' $i
fi

done
