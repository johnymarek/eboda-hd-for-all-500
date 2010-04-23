#!/bin/sh


#simple delivery script for linux

#deliver menu

cd menu
zip -r ../menu.zip *
cd ..

cd cgi-bin/mf/
zip -r ../../mf-cgi-bin.zip *
cd ../..

cd cgi-bin/vb6/
zip -r ../../vb6-cgi-bin.zip *
cd ../..

cd bin
zip -r ../mf-binaries.zip *
cd ..

zip -r hdd_scripts.zip scripts