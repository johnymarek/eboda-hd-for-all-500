#!/bin/sh
#
#   http://code.google.com/media-translate/
#   Copyright (C) 2010  Serge A. Timchenko
#
#   This program is free software: you can redistribute it and/or modify
#   it under the terms of the GNU General Public License as published by
#   the Free Software Foundation, either version 3 of the License, or
#   (at your option) any later version.
#
#   This program is distributed in the hope that it will be useful,
#   but WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#   GNU General Public License for more details.
#
#   You should have received a copy of the GNU General Public License
#   along with this program. If not, see <http://www.gnu.org/licenses/>.
#

DATAPATH=$BASEPATH/app/rss
cd $DATAPATH

echo "Content-type: application/xml"
echo
$MSDL -p http -q -o - "$stream_url" | sed 's/></>\n</g' | awk '/<description/ {match($0, /img src=\x27([^\x27]+)\x27/, arr); print "<image url=\"" arr[1] "\"/>";} {print $0;} '

