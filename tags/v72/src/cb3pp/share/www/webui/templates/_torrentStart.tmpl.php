<tr>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="5">&nbsp;</td>
			<td width="20"><input type='checkbox' name='list[]' value='<?php echo $torrent['id'] ?>' <?php if($torrent['selected']==true): ?>checked="checked"<?php endif; ?>></td>
			<td width="20"><a class='pagination' href='<?php echo $globalinfo['scriptOptions'] ?>?pg=<?php echo $globalinfo['page'] ?>&t=<?php echo $torrent['id'] ?>' name='options'><img src="icons/iconOptions.png" width="20" height="20" border="0"></a></td>
			<td class="txt"><a class='pagination' href='<?php echo $globalinfo['scriptOptions'] ?>?pg=<?php echo $globalinfo['page'] ?>&t=<?php echo $torrent['id'] ?>' name='options'><strong><?php echo substr($torrent['name'],0,30) ?></strong></a></td>
			<td width="60" class="txt" align="right"><?php if($torrent['percCompleted']<100): ?><?php echo $torrent['completed'] ?>MB/<?php endif; ?><?php echo $torrent['totalSize'] ?>MB</td>
			<td align="center" width="34"><?php if (!empty($torrent['iconStatus']) ): ?><img src="icons/<?php echo $torrent['iconStatus'] ?>" width="24" height="24"><?php endif; ?></td>
			<td width="60" class="txt"><strong><?php echo $torrent['percCompleted'] ?></strong>%</td>
			<td width="5">&nbsp;</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="2" valign="top">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="12" height="12"><img src="images/tbl_topleft.png" width="12" height="12"></td>
			<td class="progressbar" background="images/tbl_topcenter.png" height="12">&nbsp;</td>
			<td width="12"><img src="images/tbl_topright.png" width="12" height="12"></td>
		</tr>
		<tr>
			<td background="images/tbl_leftside.png"></td>
			<td background="images/tbl_center.png" valign="top">