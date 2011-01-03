<html>
<head>
	<title><?php echo $globalinfo["APP_NAME"] ?></title>
	<meta SYABAS-FULLSCREEN>
	<meta SYABAS-BACKGROUND="<?php echo $globalinfo['imgPath'] ?>/bg.jpg">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="icon" href="favicon.ico" type="image/x-icon"/>
	<link href="css/css.css" rel="stylesheet" type="text/css"/>
	<?php if( $globalinfo['refreshTime'] > 0 ): ?><meta http-equiv=refresh content="60"/><?php endif; ?>
</head>
<body bgcolor="#0A446F" focustext="#FFCC00" <?php if( $globalinfo["isGaya"] ): ?>background="<?php echo $globalinfo["imgPath"] ?>/bg.jpg"<?php else: ?>style="background-image:url('<?php echo $globalinfo["imgPath"] ?>/bg.png')"<?php endif; ?>>
<form action="<?php echo $globalinfo['scriptName'] ?>" name="stat" method="<?php if( $globalinfo["isGaya"] ): ?>get<?php else: ?>post<?php endif; ?>" enctype="multipart/form-data">
<input type="hidden" name="t" value="<?php echo $globalinfo["torrentId"] ?>"/>
<input type="hidden" name="pg" value="<?php echo $globalinfo["page"] ?>"/>
<input type="hidden" name="pg2" value="<?php echo $globalinfo["page2"] ?>"/>
<table border="0" cellpadding="2" cellspacing="2" width="100%">
<tr>
	<td colspan="2" align="right">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="10px">&nbsp;</td>
			<td width="20" valign="middle" class="title" nowrap="nowrap"><strong>//<?php echo $globalinfo["APP_NAME"] ?></strong></td>
			<td width="20px">&nbsp;</td>
			<?php if(strcmp($globalinfo['scriptName'],$globalinfo['scriptOptions'])&&$globalinfo["torrentId"]): ?>
				<td width="20"><a class="pagination" href="<?php echo $globalinfo['scriptOptions'] ?>?pg=<?php echo $globalinfo['page'] ?>&t=<?php echo $globalinfo["torrentId"] ?>" tvid="back"><img src="icons/iconBack.png" width="20" height="20" border="0"></a></td>
			<?php endif; ?>
			<?php if(strcmp($globalinfo['scriptName'],$globalinfo['scriptIndex'])): ?>
				<td width="20"><a class="pagination" href="<?php echo $globalinfo['scriptIndex'] ?>?pg=<?php echo $globalinfo['page'] ?>" tvid="back"><img src="icons/iconHome.png" width="20" height="20" border="0"></a></td>
				<td width="20"><a class="pagination" href="<?php echo $globalinfo['scriptName'] ?>?pg=<?php echo $globalinfo['page'] ?>&pg2=<?php echo $globalinfo['page2'] ?>&t=<?php echo $globalinfo["torrentId"] ?>" tvid="reload"><img src="icons/iconReload.png" width="20" height="20" border="0"></a></td>
			<?php elseif(!strcmp($globalinfo['scriptName'],$globalinfo['scriptIndex'])||strcmp($globalinfo['scriptName'],$globalinfo['scriptSetup'])): ?>
				<td width="20"><a class="pagination" href="<?php echo $globalinfo['scriptName'] ?>?pg=<?php echo $globalinfo['page'] ?>&t=<?php echo $globalinfo["torrentId"] ?>" tvid="reload"><img src="icons/iconReload.png" width="20" height="20" border="0"></a></td>
				<td width="20"><a class="pagination" href="<?php echo $globalinfo['scriptSetup'] ?>?pg=<?php echo $globalinfo['page'] ?>" tvid="setup"><img src="icons/iconOptions.png" width="20" height="20" border="0"></a></td>
			<?php endif; ?>
			<td valign="middle" align="right" class="menu" nowrap="nowrap">
				Free: <b><?php echo $globalinfo['freespace']; ?>B</b> (<b><?php echo $globalinfo['usedspaceproc']; ?>%</b>)
				<?php if( is_numeric($globalinfo['totaldown']) ): ?>&nbsp;|&nbsp; DL: <strong><?php echo number_format($globalinfo['totaldown']/1024,1) ?></strong> KB/s <?php endif; ?><?php if( is_numeric($globalinfo['totalup']) ): ?>&nbsp;|&nbsp; UL: <strong><?php echo number_format($globalinfo['totalup']/1024,1) ?></strong> KB/s<?php endif; ?>
			 </td>
			 <td width="5px">&nbsp;</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="2" class="progressbar" height="8">&nbsp;</td>
</tr>