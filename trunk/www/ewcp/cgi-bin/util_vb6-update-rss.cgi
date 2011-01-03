#!/bin/sh

component=scripts
description="vb6 feeds"


. ./common.sh

nice_start "Updating ${description}"

check_update ${component}
if [ $? -eq 0 ]
then
    perform_update ${component}


fi

nice_exit 0 
