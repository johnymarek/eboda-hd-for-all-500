#!/bin/sh


#simple delivery script for linux

#deliver menu

touch scripts/.modified_full_firmware2
find scripts | grep -v .svn | zip -9 scripts-latest.zip -@
rm scripts/.modified_full_firmware2
