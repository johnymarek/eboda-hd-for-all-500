<?php
/*-------------------------
 *    Developed by Maicros
 *      GNU/GPL Licensed
 * ------------------------*/

class CookieMegavideoWebTemplate extends WebTemplate {

    private $user = null;
    private $cookie = null;
    private $active = null;

    public function setUser($user) {
        $this->user = $user;
    }

    public function setCookie($cookie) {
        $this->cookie = $cookie;
    }

    public function setActive($active){
        $this->active = $active;
    }

    public function showBodyContent() {
        $linkCookieManually = "index.php?web&action=" . ViewCookiePageAction::getActionName() .
                "&subaction=" . ViewCookiePageAction::SUBACTION_COOKIE_MANUAL .
                "&PHPSESID=" . session_id();

        $linkLogin = "index.php?web&action=" . ViewCookiePageAction::getActionName() .
                "&subaction=" . ViewCookiePageAction::SUBACTION_COOKIE_LOGIN .
                "&PHPSESID=" . session_id();

	$linkRemove = "index.php?web&action=" . ViewCookiePageAction::getActionName() .
                "&subaction=" . ViewCookiePageAction::SUBACTION_COOKIE_REMOVE .
                "&PHPSESID=" . session_id();


        ?>

<h3>Megaupload/Megavideo Cookie Information</h3>

<table cellpadding="5px" bgcolor="#330101" width="100%">
    <tr>
        <td width="120px">Username: </td>
        <td style="font-weight: bold;color:white;">
                    <?php echo $this->user; ?>
        </td>
    </tr>
    <tr>
        <td>Cookie: </td>
        <td style="font-weight: bold;color:white;">
                    <?php echo $this->cookie; ?>
        </td>
    </tr>
    <tr>
        <td>State: </td>
        <td style="font-weight: bold;color:white;">
            <img src="../image/img/megaupload-<?php echo ( $this->active ? 'act' : 'des'); ?>.png" alt="Account State" width="16px" height="16px" />
                    <?php echo ( $this->active ? 'Activated' : 'Deactivated'); ?>
        </td>
    </tr>
    <tr>
	<td></td>
	<td>
	    <a href="<?php echo $linkRemove; ?>">Clear Cookie Info</a>
	</td>
    </tr>
</table>

<h3>Login and Save Cookie</h3>
<form action="<?php echo $linkLogin; ?>" method="POST">
    <table cellpadding="5px" bgcolor="#330101" width="100%">
        <tr>
            <td colspan="2" style="color:#E91A1A;">Insert your Megaupload/Megavideo username and password to get cookie and save it (Only username be saved).</td>
        </tr>
        <tr>
            <td width="120px">Username: </td>
            <td><input type="text" id="user" name="user" value="<?php echo $this->user; ?>" size="20" /></td>
        </tr>
        <tr>
            <td>Password: </td>
            <td><input type="password" id="pass" name="pass" value="" size="20" /></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Submit" /></td>
        </tr>
    </table>
</form>

<h3>Modify Cookie Manually</h3>
<form action="<?php echo $linkCookieManually; ?>" method="POST">
    <table cellpadding="5px" bgcolor="#330101" width="100%">
        <tr>
            <td colspan="2" style="color:#E91A1A;">Insert your Megaupload/Megavideo cookie to save it.</td>
        </tr>
        <tr>
            <td width="120px">Cookie: </td>
            <td><input type="text" id="cookie" name="cookie" value="<?php echo $this->cookie; ?>" size="50" /></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Submit" /></td>
        </tr>
    </table>
</form>

        <?php

    }

}
?>