				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
					<col />
					<col width="5"/>
					<col width="30"/>
					<col width="90"/>
					<col width="30"/>
					<col width="60"/>
				<tr>
					<td>
						<table width='100%' border='0' cellspacing='0' cellpadding='0' class="progressbar" style="padding-top:4px">
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
					<td rowspan="2">&nbsp;</td>
					<td class="boxtxt">DL:</td>
					<td class="boxtxt"><strong><?php echo $torrent['rx'] ?></strong>&nbsp;KB/s</td>
					<td class="boxtxt">Peers:</td>
					<td class="boxtxt"><strong><?php echo $torrent['peers'] ?></strong></td>
				</tr>
				<tr>
					<td class="boxtxt"><?php echo $torrent['status'] ?></td>
					<td class="boxtxt">UL:</td>
					<td class="boxtxt"><strong><?php echo $torrent['tx'] ?></strong>&nbsp;KB/s</td>
					<td class="boxtxt">Ratio:</td>
					<td class="boxtxt">&nbsp;<strong><?php echo $torrent['ratio'] ?></strong></td>
				</tr>
				</table>