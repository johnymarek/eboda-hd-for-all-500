#!/bin/sh

echo "Content-type: text/html"
echo
echo "<html><head><title>PlayOn!HD InfoSite</title></head><body bgcolor=\"#000000\" text=\"#FFFFFF\"><br><br><br>"

echo Eboda Web Control Panel is updating.

recover
{
}

backup
{
#archive content in a file
# write backup_ewcp_version.txt
}

get_files
{
# download version
# check with current_ewcp_version.txt, if not newer, quit
# download app
}

unpack
{
# unpack newer file
# perform version change
}



# get the latest version
# backup existing version
# unpack

echo "<br></body></html>"

