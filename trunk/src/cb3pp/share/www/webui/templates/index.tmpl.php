<?php require("_header.tmpl.php") ?>

<?php for( $idx = $globalinfo['fromTor']-1; $idx < $globalinfo['toTor']; $idx++ ): ?>
<?php if( !($oneTorrent = $torrents[$idx]) ) break; ?>
<?php $torrent = parseTorrent($oneTorrent); ?>

	<?php require("_torrentStart.tmpl.php") ?>

	<?php require("_torrentContent.tmpl.php") ?>

	<?php require("_torrentEnd.tmpl.php") ?>

<?php endfor; ?>

<tr>
	<td class="pagination">
		<table border="0" cellpadding="0" cellspacing="1"<?php if( !$globalinfo['isGaya'] ): ?> width="100%"<?php endif; ?>>
		<tr>
			<td width="10"><input type="submit" name="action-start" value="start"></td>
			<td width="10"><input type="submit" name="action-stop" value="stop"></td>
			<td width="10"><input onclick="return confirm('Are you sure?')" type="submit" name="action-delete" value="delete"></td>
			<?php if( !$globalinfo['isGaya'] ): ?>
			<td align="right" class="txt">
				Upload torrent file: <input type="file" name="fFile" />
				<input type="checkbox" name="fAutoStart" value="1" checked="checked"/> Auto-start torrent&nbsp;
			</td>
			<td width="10"><input type="submit" name="action-upload" value="upload" /></td>
			<?php endif; ?>
		</table>
		<table border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td width="10"><input type="submit" name="action-start-all" value="start all"></td>
			<td width="10"><input type="submit" name="action-stop-all" value="stop all"></td>
			<td width="10"><input onclick="return confirm('Are you sure?')" type="submit" name="action-delete-all" value="delete all"></td>
		</table>
	</td>
	<td align="right" class="pagination">

<?php require("_pagination.tmpl.php") ?>

	</td>
</tr>

<?php require("_footer.tmpl.php") ?>