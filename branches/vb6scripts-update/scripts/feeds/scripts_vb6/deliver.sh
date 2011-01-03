#!/bin/sh


#simple delivery script for linux

#deliver menu

rm scripts-latest.zip

find scripts | grep -v .svn |  grep -v ~$ | zip -9 scripts-latest.zip -@

googlecode_upload.py -s scripts -p eboda-hd-for-all-500 scripts-latest.zip -u cipibad -w WV6tc7mt3Ba8

googlecode_upload.py -s scripts -p eboda-hd-for-all-500 scripts-version.txt -u cipibad -w WV6tc7mt3Ba8
