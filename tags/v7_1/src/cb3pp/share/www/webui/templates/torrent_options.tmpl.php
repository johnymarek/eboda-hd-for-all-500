<?php require("_header.tmpl.php") ?>

<?php for( $idx = 0; $idx < 1; $idx++ ): ?>
<?php if( !($oneTorrent = $torrents[$idx]) ) break; ?>
<?php
	$torrent = parseTorrent($oneTorrent, true);

	$torrent['progress_uploaded_width']    = ceil($torrent['ratio']);
	$torrent['progress_notuploaded_width'] = 100 - $torrent['progress_uploaded_width'];

	$torrent['progress_uploadeleft_border']   = 'progressGreen2LeftBorder.png';
	$torrent['progress_uploadedright_border'] = 'progressDarkBlueRightBorder.png';
	$torrent['progress_uploaded_image']    = 'progressGreen2.png';
	$torrent['progress_notuploaded_image'] = 'progressDarkBlue.png';
	$torrent['selected'] = true;
?>
	<?php require("_torrentStart.tmpl.php") ?>

	<?php require("_torrentOptions.tmpl.php") ?>

	<?php require("_torrentEnd.tmpl.php") ?>

<?php endfor; ?>

<?php require("_footer.tmpl.php") ?>