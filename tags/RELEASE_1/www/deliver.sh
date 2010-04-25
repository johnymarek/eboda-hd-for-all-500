#!/bin/sh


#simple delivery script for linux

#deliver menu

touch ewcp/.modified_full_firmware1
find ewcp | grep -v .svn | zip -9 ewcp-latest.zip -@
rm ewcp/.modified_full_firmware1
