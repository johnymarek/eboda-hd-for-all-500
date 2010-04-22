#!/bin/sh


#simple delivery script for linux

#deliver menu

cd menu
zip ../menu.zip *
cd ..

cd cgi-bin/mf/
zip ../../mf-cgi-bin.zip *
cd ../..

cd cgi-bin/vb6/
zip ../../vb6-cgi-bin.zip *
cd ../..

cd bin
zip ../mf-binaries.zip *
cd ..

zip scripts.zip scripts