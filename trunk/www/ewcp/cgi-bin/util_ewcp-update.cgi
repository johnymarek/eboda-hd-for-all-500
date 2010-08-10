#!/bin/sh

component=ewcp
description="E-boda Web Control Panel"


. ./common.sh

nice_start "Updating ${description}"

check_update ${component}
if [ $? -eq 0 ]
then
    perform_update ${component}


fi

nice_exit 0 
