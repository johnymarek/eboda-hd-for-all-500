#!/usr/bin/awk -f
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

#.H1 getXML.awk
#.H2 Synopsis
#.P
# gawk -f getXML.awk <xml-file>
#.H2 Download
#.P Download from <a href="http://lawker.googlecode.com/svn/fridge/lib/awk/getxml.awk">LAWKER</a>
#.H2 Example 
#.PRE

function getInfo(url)
{
  print "Resolve url: " url > "/dev/stderr"
  HttpService = "/inet/tcp/0/127.0.0.1/80"
  ORS = RS = "\n\n"
  print "GET /cgi-bin/translate?info,Resolve-playlist:1," url " HTTP/1.0" |& HttpService
  HttpService |& getline Header
  info_file = "/tmp/info.xml"
  printf "" > info_file
  while ((HttpService |& getline) > 0)
    printf "%s", $0 >> info_file
  close(HttpService)
  close(info_file)

 ORS="\n"
  while ( getXML(info_file,1) ) 
  {
    if(XTYPE == "TAG")
    {
      if(XITEM == "stream" && XATTR["url"] != "" && XATTR["class"] != "text")
      {
        server_url = XATTR["server_url"];
        if(XATTR["protocol"] ~ /^http/)
        {
          if(server_url ~ /^icyx:/)
          {
            server_url = "";
          }
        }
        else
        {
          if(server_url == "")
          {
            server_url = "_empty_";
          }
        }
        
        if(XATTR["url"] != "") print "<meta rel=\"stream_url\">" XATTR["url"] "</meta>";
        if(XATTR["class"] != "") print "<meta rel=\"stream_class\">" XATTR["class"] "</meta>";
        if(XATTR["server"] != "") print "<meta rel=\"stream_soft\">" XATTR["server"] "</meta>";
        if(server_url != "") print "<meta rel=\"stream_server\">" server_url "</meta>";
        if(XATTR["type"] != "") print "<meta rel=\"stream_type\">" XATTR["type"] "</meta>";
        if(XATTR["protocol"] != "") print "<meta rel=\"stream_protocol\">" XATTR["protocol"] "</meta>";
      }
      else
      if(XITEM == "stream-genre")
      {
        getXML(info_file,0);
        if(XTYPE == "CDA" || XTYPE == "DAT")
          print "<meta rel=\"stream_genre\">" XITEM "</meta>";
      }
      else
      if(XITEM == "stream-bitrate")
      {
        getXML(info_file,0);
        if(XTYPE == "CDA" || XTYPE == "DAT")
          print "<meta rel=\"stream_bitrate\">" XITEM "</meta>";
      }
      else
      if(SKIPTITLE != 1 && XITEM == "stream-title")
      {
        getXML(info_file,0);
        if(XTYPE == "CDA" || XTYPE == "DAT")
          print "<meta rel=\"stream_title\">" XITEM "</meta>";
      }
    }
  }
}

BEGIN {
  UNESCAPEXML = 0;
  skiptag = 0;

  while ( getXML(ARGV[1],0) ) 
  {
    if(XTYPE == "TAG")
    {
      value = "";
      if(XITEM == "track")
      {
        location = "";
        stream = 0;
      }
      else
      if(XITEM == "meta" && XATTR["rel"] == "stream_url")
      {
        stream = 1;
      }
      
      if(FORCEINFO == 1 && XITEM == "meta" && XATTR["rel"] ~ /stream_/)
      {
        skiptag = 1;
      }
      else
      {
        printf "<" XITEM;
        for (attrName in XATTR)
          printf " " attrName "=\"" XATTR[attrName] "\"";
        printf ">";
      }
    }
    else
    if(XTYPE == "DAT")
    {
      if(skiptag == 0)
      {
        value = XITEM;
        printf XITEM;
      }
    }
    else
    if(XTYPE == "CDA")
    {
      if(skiptag == 0)
      {
        printf "<![CDATA[" XITEM "]]>";
      }
    }
    else
    if(XTYPE == "PIN")
    {
        printf "<?" XITEM "?>";
    }
    else
    if(XTYPE == "END")
    {
      if(skiptag == 0)
      {
        tagname = XITEM;
        if(XITEM == "location")
        {
          UNESCAPEXML=1;
          location = unescapeXML(value);
          UNESCAPEXML=0;
        }
        else
        if(XITEM == "track" && location != "")
        {
          if(stream == 0 || FORCEINFO == 1)
          {
            print "";
            getInfo(location);
          }
        }
        printf "</" tagname ">";
      }
      skiptag = 0;
    }
  }
}

#./PRE
#.H2 Details
#.P
# Main function, read snext xml-data into XTYPE,XITEM,XATTR
#.PRE
#getXML( file, skipData ): 
#./PRE
#.DL
#.DT   file
#.DD path to xml file
#.DT   skipData 
#.DD flag: do not read "DAT" (data between tags) sections
#./DL
#.H3 External variables:
#.DL
#.DT   XTYPE  
#.DD type of item read, e.g. "TAG"(tag), "END"(end tag), "COM"(comment), "DAT"(data)
#.DT   XITEM  
#.DD value of item, e.g. tagname if type is "TAG" or "END"
#.DT   XATTR  
#.DD Map of attributes, only set if XTYPE=="TAG"
#.DT  XPATH   
#.DD Path to current tag, e.g. /TopLevelTag/SubTag1/SubTag2
#.DT  XLINE   
#.DD current line number in input file
#.DT  XNODE   
#.DD XTYPE, XITEM, XATTR combined into a single string
#.DT  XERROR  
#.DD error text, set on parse error
#./DL
#.H3 Returns
#.DL
#.DT
#    1         
#.DD on successful read: XTYPE, XITEM, XATTR are set accordingly
#.DT    ""        
#.DD at end of file or parse error, XERROR is set on error
#./DL
#.H3 Private Data
#.DL
#.DT  _XMLIO
#.DD buffer, XLINE, XPATH for open files
#./DL
#.H2 Code
#<font size="-3">
#.PRE
function getXML( file, skipData           \
				,end,p,q,tag,att,accu,mline,mode,S0,ex,dtd) {
    XTYPE=XITEM=XERROR=XNODE=""; split("",XATTR);
    S0=_XMLIO[file,"S0"]; XLINE=_XMLIO[file,"line"]; 
	XPATH=_XMLIO[file,"path"]; dtd=_XMLIO[file,"dtd"];
    while (!XTYPE) {
        if (S0=="") { if (1!=(getline S0 <file)) break; XLINE++; S0=S0 RS; }
        if ( mode == "" ) {
            mline=XLINE; accu=""; p=substr(S0,1,1);
            if ( p!="<" && !(dtd && p=="]") )         
				mode="DAT";
            else if ( p=="]" ) 
				{ S0=substr(S0,2);  mode="DTE"; end=">"; dtd=0; }
            else if ( substr(S0,1,4)=="<!--" ) 
				{ S0=substr(S0,5);  mode="COM"; end="-->"; }
            else if ( substr(S0,1,9)=="<!DOCTYPE" ) 
                { S0=substr(S0,10); mode="DTB"; end=">"; }
            else if ( substr(S0,1,9)=="<![CDATA[" ) 
                { S0=substr(S0,10); mode="CDA"; end="]]>"; }
            else if ( substr(S0,1,2)=="<!" ) 
				{ S0=substr(S0,3);  mode="DEC"; end=">"; }
            else if ( substr(S0,1,2)=="<?" ) 
				{ S0=substr(S0,3);  mode="PIN"; end="?>"; }
            else if ( substr(S0,1,2)=="</" ) 
				{ S0=substr(S0,3);  mode="END"; end=">";
                tag=S0;sub(/[ \n\r\t>].*$/,"",tag);
				S0=substr(S0,length(tag)+1);
                ex=XPATH;sub(/\/[^\/]*$/,"",XPATH);
				ex=substr(ex,length(XPATH)+2);
                if (tag!=ex) { 
                   	XERROR="unexpected close tag <" ex ">..</" tag ">"; 
					break; } }
            else{                                     
				S0=substr(S0,2);  mode="TAG";
                tag=S0;sub(/[ \n\r\t\/>].*$/,"",tag);
				S0=substr(S0,length(tag)+1);
                if ( tag !~ /^[A-Za-z:_][0-9A-Za-z:_.-]*$/ ) { 
                    XERROR="invalid tag name '" tag "'"; break; }
                XPATH = XPATH "/" tag; } }
        else if ( mode == "DAT" ) {                            
            p=index(S0,"<"); 
			if ( dtd && (q=index(S0,"]")) && (!p || q<p) ) p=q;
            if (p) {
                if (!skipData) { XTYPE="DAT"; 
                       XITEM=accu unescapeXML(substr(S0,1,p-1)); }
                S0=substr(S0,p); mode=""; }
            else{ if (!skipData) accu=accu unescapeXML(S0); S0=""; } }
        else if ( mode == "TAG" ) {   
			sub(/^[ \n\r\t]*/,"",S0); if (S0=="") continue;
            if ( substr(S0,1,2)=="/>" ) {
                S0=substr(S0,3); mode=""; XTYPE="TAG"; 
				XITEM=tag; S0="</"tag">"S0; }
            else if ( substr(S0,1,1)==">" ) {
                S0=substr(S0,2); mode=""; XTYPE="TAG"; XITEM=tag; }
            else{
                att=S0; sub(/[= \n\r\t\/>].*$/,"",att); 
				S0=substr(S0,length(att)+1); mode="ATTR";
                if ( att !~ /^[A-Za-z:_][0-9A-Za-z:_.-]*$/ ) { 
                    XERROR="invalid attribute name '" att "'"; 
					break; } } }
        else if ( mode == "ATTR" ) {  
				sub(/^[ \n\r\t]*/,"",S0); if (S0=="") continue;
            if ( substr(S0,1,1)=="=" ) { S0=substr(S0,2); mode="EQ"; }
            else                       { XATTR[att]=att; mode="TAG"; 
                                         XNODE=XNODE att"="att"\001"; } }
        else if ( mode == "EQ" ) {    
					sub(/^[ \n\r\t]*/,"",S0); if (S0=="") continue;
            end=substr(S0,1,1);
            if ( end=="\"" || end=="'" ) {
					S0=substr(S0,2);accu="";mode="VALUE";}
            else{
                accu=S0; sub(/[ \n\r\t\/>].*$/,"",accu); 
				S0=substr(S0,length(accu)+1);
                XATTR[att]=unescapeXML(accu); mode="TAG"; 
				XNODE=XNODE att"="XATTR[att]"\001"; } }
        else if ( mode == "VALUE" ) { # terminated by end
            if ( p=index(S0,end) ) {
                XATTR[att]=accu unescapeXML(substr(S0,1,p-1)); 
				XNODE=XNODE att"="XATTR[att]"\001";
                S0=substr(S0,p+length(end)); mode="TAG"; }
            else{ accu=accu unescapeXML(S0); S0=""; } }
        else if ( mode == "DTB" ) { # terminated by "[" or ">"
            if ( (q=index(S0,"[")) && (!(p=index(S0,end)) || q<p ) ) {
                XTYPE=mode; XITEM= accu substr(S0,1,q-1); 
				S0=substr(S0,q+1); mode=""; dtd=1; }
            else if ( p=index(S0,end) ) {
                XTYPE=mode; XITEM= accu substr(S0,1,p-1); 
				S0="]"substr(S0,p); mode=""; dtd=1; }
            else{ accu=accu S0; S0=""; } }
        else if ( p=index(S0,end) ) {  # terminated by end
            XTYPE=mode; XITEM= ( mode=="END" ? tag : accu substr(S0,1,p-1) );
            S0=substr(S0,p+length(end)); mode=""; }
        else{ accu=accu S0; S0=""; } }
    _XMLIO[file,"S0"]=S0; _XMLIO[file,"line"]=XLINE; 
	_XMLIO[file,"path"]=XPATH; _XMLIO[file,"dtd"]=dtd;
    if (mode=="DAT") { mode=""; if (accu!="") XTYPE="DAT"; XITEM=accu; }
    if (XTYPE) { XNODE=XTYPE"\001"XITEM"\001"XNODE; return 1; }
    close(file);
    delete _XMLIO[file,"S0"]; delete _XMLIO[file,"line"]; 
	delete _XMLIO[file,"path"]; delete _XMLIO[file,"dtd"];
    if (XERROR) XERROR=file ":" XLINE ": " XERROR;
    else if (mode) XERROR=file ":" mline ": " "unterminated " mode;
    else if (XPATH) XERROR=file ":" XLINE ": "  "unclosed tag(s) " XPATH;
} 
#./PRE
#./FONT
#.P
# Unescape data and attribute values, used by getXML.
#.PRE
function unescapeXML( text ) {
  if(UNESCAPEXML==1)
  {
    gsub( "&apos;", "'",  text );
    gsub( "&quot;", "\"", text );
    gsub( "&gt;",   ">",  text );
    gsub( "&lt;",   "<",  text );
    gsub( "&amp;",  "\\&",  text );
  }
  return text
}
#./PRE
#.P
#Close xml file
#.PRE
function closeXML( file ) {
    close(file);
    delete _XMLIO[file,"S0"]; delete _XMLIO[file,"line"]; 
    delete _XMLIO[file,"path"]; delete _XMLIO[file,"dtd"];
    delete _XMLIO[file,"open"]; delete _XMLIO[file,"IND"];
}
#./PRE
#.H2 Author
#.P Jan Weber 
