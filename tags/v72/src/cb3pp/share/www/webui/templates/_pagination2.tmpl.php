<table border="0" cellpadding="1" cellspacing="1">
<tr>
	<td class="pagination"><?php echo $globalinfo['fromTor'] ?> - <?php echo $globalinfo['toTor'] ?> / <?php echo $globalinfo['actTor'] ?> items&nbsp;</td>
	<?php if($globalinfo['fromTor'] > 1 ): ?><td width="21" class="pagination"><a class='pagination' href='<?php echo $globalinfo['scriptName'] ?>?pg=<?php echo $globalinfo['page'] ?>&pg2=<?php echo $globalinfo['prevpage'] ?>&t=<?php echo $globalinfo["torrentId"] ?>' name='prevpage' tvid='pgup'><img src="<?php echo $globalinfo['imgPath'] ?>/up_off.png" width="21" height="21" border="0"></a></td><?php endif; ?>
	<?php if($globalinfo['nextpage'] ): ?><td width="21" class="pagination"><a class='pagination' href='<?php echo $globalinfo['scriptName'] ?>?pg=<?php echo $globalinfo['page'] ?>&pg2=<?php echo $globalinfo['nextpage'] ?>&t=<?php echo $globalinfo["torrentId"] ?>' name='nextpage' tvid='pgdn'><img src="<?php echo $globalinfo['imgPath'] ?>/down_off.png" width="21" height="21" border="0"></a></td><?php endif; ?>
</tr>
</table>