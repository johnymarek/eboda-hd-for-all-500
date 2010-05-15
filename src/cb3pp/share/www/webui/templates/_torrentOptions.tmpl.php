				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<col />
					<col width="5"/>
					<col width="30"/>
					<col width="90"/>
					<col width="30"/>
					<col width="60"/>
				<tr>
					<td>
						<table width='100%' border='0' cellspacing='0' cellpadding='0' class="progressbar">
						<tr>
							<td class='progressbar' background='images/<?php echo $torrent['progress_left_border'] ?>' width='5' height='10'>&nbsp;</td>
							<td>
								<table width='100%' border='0' cellspacing='0' cellpadding='0' class="progressbar">
								<tr>
									<?php if( $torrent['progress_done_width'] > 0 ): ?><td class='progressbar' background='images/<?php echo $torrent['progress_done_image'] ?>' width='<?php echo $torrent['progress_done_width'] ?>%' height='10'>&nbsp;</td><?php endif; ?>
									<?php if( $torrent['progress_notdone_width'] > 0 ): ?><td class='progressbar' background='images/<?php echo $torrent['progress_notdone_image'] ?>' width='<?php echo $torrent['progress_notdone_width'] ?>%' height='10'>&nbsp;</td><?php endif; ?>
								</tr>
								</table>
							</td>
							<td class='progressbar' background='images/<?php echo $torrent['progress_right_border'] ?>' width='5' height='10'>&nbsp;</td>
						</tr>
						</table>
					</td>
					<td rowspan="3">&nbsp;</td>
					<td class="boxtxt">DL:</td>
					<td class="boxtxt"><strong><?php echo $torrent['rx'] ?></strong>&nbsp;KB/s</td>
					<td class="boxtxt">Peers:</td>
					<td class="boxtxt"><strong><?php echo $torrent['peers'] ?></strong></td>
				</tr>
				<tr>
					<td class="boxtxt">
						<table width='100%' border='0' cellspacing='0' cellpadding='0' class="progressbar">
						<tr>
							<td class='progressbar' background='images/<?php echo $torrent['progress_uploadeleft_border'] ?>' width='5' height='10'>&nbsp;</td>
							<td>
								<table width='100%' border='0' cellspacing='0' cellpadding='0' class="progressbar">
								<tr>
									<?php if( $torrent['progress_uploaded_width'] > 0 ): ?><td class='progressbar' background='images/<?php echo $torrent['progress_uploaded_image'] ?>' width='<?php echo $torrent['progress_uploaded_width'] ?>%' height='10'>&nbsp;</td><?php endif; ?>
									<?php if( $torrent['progress_notuploaded_width'] > 0 ): ?><td class='progressbar' background='images/<?php echo $torrent['progress_notuploaded_image'] ?>' width='<?php echo $torrent['progress_notuploaded_width'] ?>%' height='10'>&nbsp;</td><?php endif; ?>
								</tr>
								</table>
							</td>
							<td class='progressbar' background='images/<?php echo $torrent['progress_uploadedright_border'] ?>' width='5' height='10'>&nbsp;</td>
						</tr>
						</table>
					</td>
					<td class="boxtxt">UL:</td>
					<td class="boxtxt"><strong><?php echo $torrent['tx'] ?></strong>&nbsp;KB/s</td>
					<td class="boxtxt">Ratio:</td>
					<td class="boxtxt">&nbsp;<strong><?php echo $torrent['ratio'] ?></strong></td>
				</tr>
				<tr>
					<td class="boxtxt"><?php echo $torrent['status'] ?></td>
					<td class="boxtxt"></td>
					<td class="boxtxt"></td>
					<td class="boxtxt">Avail:</td>
					<td class="boxtxt"><strong><?php echo $torrent['avail'] ?></strong>%</td>
				</tr>
				</table>
				<table border='0' cellspacing='2' cellpadding='2'>
					<col/>
					<col/>
					<col width="10"/>
					<col/>
					<col/>
				<tr>
					<td class='progressbar' colspan="5">&nbsp;</td>
				</tr>
				<tr>
					<td nowrap="nowrap" class="txt" colspan="2"><strong>Pieces</strong></td>
					<td class='progressbar' rowspan="4">&nbsp;</td>
					<td nowrap="nowrap" class="txt" colspan="2"><strong>Info</strong></td>
				</tr>
				<tr>
					<td class="txt">Downloaded:</td>
					<td class="txt"><?php echo $torrent["piecesDownloaded"] ?></td>
					<td class="txt">Torrent:</td>
					<td class="txt"><?php echo $torrent["name"] ?></td>
				</tr>
				<tr>
					<td class="txt">Total:</td>
					<td class="txt"><?php echo $torrent["piecesTotal"] ?></td>
					<td class="txt">Hash:</td>
					<td class="txt"><?php echo $torrent["hash"] ?></td>
				</tr>
				<tr>
					<td class="txt">Seen:</td>
					<td class="txt"><?php echo $torrent["piecesSeen"] ?></td>
					<td class="txt">Errors:</td>
					<td class="txt"><?php echo $torrent["errors"] ?></td>
				</tr>
				</table>
				<table border='0' cellspacing='2' cellpadding='2'>
				<tr>
					<td class='progressbar' colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td nowrap="nowrap" class="txt" colspan="2"><strong>Torrent content</strong></td>
				</tr>
				<?php $file_name = $globalinfo["APP_HOME"]."/torrents/".$torrent["hash"]."/torrent"; ?>
				<?php if( file_exists($file_name) ): ?>
					<?php

						$torrent_content = file_get_contents($file_name);
						$bencoder = new BEncodeLib();
						$torrent_info = $bencoder->bdecode($torrent_content);
						if( !is_array($torrent_info) ) $torrent_info = array();
					?>
					<?php foreach( $torrent_info AS $key => $val ): ?>
					<?php if( $globalinfo["isGaya"] && is_array($val) ) continue; ?>
					<tr>
						<td nowrap="nowrap" class="txt"><?php echo htmlspecialchars(ucfirst(strtolower($key))) ?>:</td>
						<td class="txt"><?php echo is_array($val)?tor_getContentAsHtmlList($val):tor_parseContentAsHtml($key, $val) ?></td>
					</tr>
					<?php endforeach; ?>
				<?php else: ?>
				<tr>
						<td class="txt">Error:</td>
						<td class="txt">Cannot find torrent file.</td>
					</tr>
				<?php endif; ?>
				</table>
				<table border="0" cellpadding="0" cellspacing="1" width="100%">
					<tr>
						<!--//<td width="10"><input type="submit" name="action-save" value="save"></td>//-->
						<td width="10"><input type="submit" name="action-start" value="start"></td>
						<td width="10"><input type="submit" name="action-stop" value="stop"></td>
						<td width="10"><input onclick="return confirm('Are you sure?')" type="submit" name="action-delete" value="delete"></td>
						<td align="right"><!--//
							<a href="<?php echo $globalinfo['scriptFiles'] ?>?t=<?php echo $globalinfo['torrentId'] ?>&pg=<?php echo $globalinfo['page'] ?>" class="pagination">Files</a>
							&nbsp;|&nbsp;
							<a href="<?php echo $globalinfo['scriptPeers'] ?>?t=<?php echo $globalinfo['torrentId'] ?>&pg=<?php echo $globalinfo['page'] ?>" class="pagination">Peers</a>//-->
						</td>
					</tr>
				</table>