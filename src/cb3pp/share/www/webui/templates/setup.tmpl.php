<?php require("_header.tmpl.php") ?>

<tr>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="5">&nbsp;</td>
			<td width="20"><img src="icons/iconOptions.png" width="20" height="20" border="0"></td>
			<td class="txt"><strong>Client Setup</strong></td>
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
				<table border='0' cellspacing='2' cellpadding='2'>
					<col/>
					<col/>
					<col width="10"/>
					<col/>
					<col/>
				<tr>
					<td class="txt" colspan="2"><strong>Version</strong></td>
					<td class='progressbar' rowspan="2">&nbsp;</td>
					<td class="txt" colspan="2"><strong>Download path</strong></td>
				</tr>
				<tr>
					<td class="txt" colspan="2"><?php echo $session["version"] ?>&nbsp;</td>
					<td class="txt" colspan="2"><input type="text" name='fDownloadDir' size="20" maxlength="255" value="<?php echo $session["download-dir"] ?>" /></td>
				</tr>
				<tr>
					<td class='progressbar' colspan="8">&nbsp;</td>
				</tr>
				<tr>
					<td nowrap="nowrap" class="txt" colspan="2"><strong>Transfer Bandwidth</strong></td>
					<td class='progressbar' rowspan="4">&nbsp;</td>
					<td class="txt" colspan="2"><strong>Advanced</strong></td>
				</tr>
				<tr>
					<td nowrap="nowrap" class="txt">DL rate:</td>
					<td nowrap="nowrap" class="txt"><input type="text" name='fDlRate' size="5" maxlength="10" value="<?php echo $session["speed-limit-down"] ?>"/>&nbsp;&nbsp;KB/s</td>
					<td nowrap="nowrap" class="txt">Max connections:</td>
					<td nowrap="nowrap" class="txt"><input type="text" name='fMaxConnections' size="5" maxlength="10" value="<?php echo $session["peer-limit"] ?>"/></td>
				</tr>
				<tr>
					<td nowrap="nowrap" class="txt">UL rate:</td>
					<td nowrap="nowrap" class="txt"><input type="text" name='fUlRate' size="5" maxlength="10" value="<?php echo $session["speed-limit-up"] ?>"/>&nbsp;&nbsp;KB/s</td>
					<td class="txt">Port:</td>
					<td nowrap="nowrap" class="txt"><input type="text" name='fPort' size="5" maxlength="10" value="<?php echo $session["port"] ?>"/></td>
				</tr>
				<tr>
					<td nowrap="nowrap" class="txt">Max UL peers:</td>
					<td nowrap="nowrap" class="txt"><input type="text" name='fMaxUlPeers' size="5" maxlength="10" value="<?php echo $session["max-upload-peers"] ?>" /> (-1/0-n)</td>
					<td class="txt">Empty start:</td>
					<td nowrap="nowrap" class="txt"><input type="checkbox" name='fEmptyStart' value="1" <?php if($session["empty-start"]==1): ?>checked="checked"<?php endif; ?>/></td>
				</tr>
				<tr>
					<td class='progressbar' colspan="8">&nbsp;</td>
				</tr>
				<tr>
					<td nowrap="nowrap" class="txt" colspan="5"><strong>Sorting order</strong></td>
				</tr>
				<tr>
					<td nowrap="nowrap" class="txt" colspan="5">
						<select name='sortOrder'>
							<option value="0" <?php if($session["sort-order"]==0): ?>selected="selected"<?php endif; ?>>Downloading, Verifying, Seeding, Stopped</option>
							<option value="1" <?php if($session["sort-order"]==1): ?>selected="selected"<?php endif; ?>>Downloading, Verifying, Stopped, Seeding</option>
							<option value="2" <?php if($session["sort-order"]==2): ?>selected="selected"<?php endif; ?>>Seeding, Verifying, Downloading, Stopped</option>
							<option value="3" <?php if($session["sort-order"]==3): ?>selected="selected"<?php endif; ?>>Stopped, Verifying, Downloading, Seeding</option>
							<option value="4" <?php if($session["sort-order"]==4): ?>selected="selected"<?php endif; ?>>Stopped, Seeding, Downloading, Verifying</option>
						</select>
					</td>
				</tr>
				</table>
				<table border="0" cellpadding="0" cellspacing="1">
					<tr>
						<td><input type="submit" name="action-save" value="save"/></td>
					</tr>
				</table>
			</td>
			<td background="images/tbl_rightside.png"></td>
		</tr>
		<tr>
			<td height="12"><img src="images/tbl_bottomleft.png" width="12" height="12"></td>
			<td class="progressbar" background="images/tbl_bottomcenter.png" height="12">&nbsp;</td>
			<td><img src="images/tbl_bottomright.png" width="12" height="12"></td>
		</tr>
		</table>
	</td>
</tr>

<?php require("_footer.tmpl.php") ?>