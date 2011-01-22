#!/bin/sh


#simple delivery script for linux

#deliver menu

rm scripts-latest.zip

find scripts | grep -v .svn |  grep -v ~$ | zip -9 scripts-latest.zip -@

googlecode_upload.py -s scripts -p eboda-hd-for-all-500 scripts-latest.zip -u cipibad -w UV5At6QF7Tz5

googlecode_upload.py -s scripts -p eboda-hd-for-all-500 scripts-version.txt -u cipibad -w UV5At6QF7Tz5
