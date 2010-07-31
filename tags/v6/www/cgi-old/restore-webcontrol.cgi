#!/bin/sh

echo "Content-type: text/html"
echo
echo "<html><head><title>Eboda Web Control Panel restore</title></head><body bgcolor=\"#000000\" text=\"#FFFFFF\"><br><br><br>"

tmpdir=/tmp


if [ -f ../ewcp-*.tar ] 
then
    echo old version was found
    oldserial=`grep SERIAL $workdir/current_version.txt  | cut -d'=' -f 2` && echo old serial is $oldserial
    tar cvf ${tmpdir}/ewcp-${oldserial}.tar * 
    if [ $? -eq 0 ]
    then
        echo current version saved temporarly
        rm -rf *
        tar xvf /ewcp-*.tar
        if [ $? -eq 0 ]
        then
            echo new version installed
        else
            echo cannot restore old version, trying to restore current version
            tar xvf ${tmpdir}/ewcp-${oldserial}.tar
            echo if panel not working anymore ... nashpa
        fi
    else
        echo "cannot save current version in ${tmpdir}/ewcp-${oldserial}.tar"
    fi
else
    echo "restore file not found"
    
fi
echo '<FORM><INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);return true;"> </FORM> '

echo "<br></body></html>"

