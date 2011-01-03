
#!/bin/sh




#checking original firmware presence
IMAGE_FILE=install.img
VERSION="500a"

#check SVN repository presence
if [ $# -ne 1 ]
then
    echo No arguments given, please suppply absolute path to SVN directory in first argument
    exit 1
fi


[ -f $1/scripts/firmware/patch_realtek.sh ] && source $1/scripts/firmware/patch_realtek.sh

patch_firmware $IMAGE_FILE $1 $VERSION

