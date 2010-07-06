#!/bin/sh

. ./common.sh

nice_start "Rebooting"


cat <<EOF
	    </pre>
             <h2> Allow few seconds for reboot. 404 error is normal during startup process </h2> <br>
	     <h2><a href="/cgi-bin/ewcp.cgi">Click here to go back to main page<a></h2>
           <td>
          </tr>
          <tr>
            <td><img src="/eb_imgs/cp_BL.gif" width="7" height="6"></td>
            <td class="pnlFooter"><img src="/eb_imgs/spacer.gif" width="6" height="6"></td>
            <td><img src="/eb_imgs/cp_BR.gif" width="7" height="6"></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td><img src="/eb_imgs/cp_footer.gif" width="714" height="65"></td>
  </tr>
</table>
</body>
</html>

EOF

/sbin/reboot

