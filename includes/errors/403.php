<?php header($_SERVER['SERVER_PROTOCOL']." 403 MLP is awesome, Deal with it"); ?>
<h3>Error 403: Request Refused</h3>

<p>
    Were sorry, but the server is refusing to respond to your request. This is may be because, the settings.json and/or
    settings.php file(s) have become corrupted. Please verify line 16 in /includes/config/settings.php and rebuild
    settings.json if necessary.
    This is probably because you changed the value of public $mlp to something other than it's default 'awesome'.
    <img src="./images/403.gif" alt="MLP is awesome, Deal with it" />
</p>