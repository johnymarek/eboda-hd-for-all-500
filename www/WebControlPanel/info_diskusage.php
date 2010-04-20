<head>
  <style type="text/css">
    table {border:1px solid black}
    .shaded {background-color:#c0c0c0}
    .small {font-size:8pt}
    .thead {font-weight:bold; background-color:black; color:yellow; text-align:center}
  </style>
</head>
<body>

<?php

function sizefix($s) {

  $t=$s*1024;

  $postfix=Array("B","kB","MB","GB","TB");
  $i=0;

  while($t>1024){
    $t=$t/1024;
    $i++;
  }

  if ($i>0) $t=substr(number_format($t,4),0,5);
  return "$t $postfix[$i]";
}

  exec("df", $output);

  for ($i=1;$i<count($output);$i++) {
    $cols=preg_split("/\s+/", $output[$i]);

    $percent=100*$cols[2]/$cols[1];

    for($j=1;$j<4;$j++){
      $cols[$j]=sizefix($cols[$j]);
    }

    if ($percent>=1) {
      if ($percent<99) {
        $pb="<table width='100%'><tr><td width='$cols[4]' class='shaded'>&nbsp;</td><td>&nbsp;</td></tr></table>";
      } else {
        $pb="<table width='100%'><tr><td class='shaded'>&nbsp;</td></table>";
      }
    } else {
      $pb="<table width='100%'><tr><td>&nbsp;</td></table>";
    }

    echo "<table width='300'>\n  <tr class='thead'><td>$cols[0] &nbsp;&nbsp;&nbsp; --- &nbsp;&nbsp;&nbsp; $cols[5]</td></tr>\n";
    echo "  <tr><td>$pb</td></tr>\n";
    echo "  <tr><td class='small'><font size='-1'>Total: $cols[1] &nbsp;&nbsp; Used: $cols[2] &nbsp;&nbsp; Free: $cols[3]</font></td></tr>\n";
    echo "</table>\n<br>";
  }

?>
</body>