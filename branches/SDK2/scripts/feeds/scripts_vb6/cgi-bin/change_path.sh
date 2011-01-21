#!/bin/sh


for i in `find . | grep -v .svn  | grep -v change_path.sh` 

do echo $i; 

grep opt $i 
if [ $? -eq 0 ]
then
	echo changing port
	sed -i -e 's#/opt/bin/#/cb3pp/bin/#g' $i
fi

done
