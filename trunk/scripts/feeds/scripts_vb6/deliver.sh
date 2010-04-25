#!/bin/sh


#simple delivery script for linux

#deliver menu

touch scripts/.modified_full_firmware1
find scripts | grep -v .svn | zip -9 hdd_scripts.zip -@
rm scripts/.modified_full_firmware1
