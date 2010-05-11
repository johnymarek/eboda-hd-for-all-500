#!/bin/sh


touch cb3pp/.modified_full_firmware2
find cb3pp | grep -v .svn | zip -9 cb3pp-latest.zip -@
rm cb3pp/.modified_full_firmware2



