<?php header($_SERVER['SERVER_PROTOCOL']." 505 HTTP Version Not Supported"); ?>
    <h3>Error 505: HTTP Version Not Supported.</h3>
    <img src="./includes/images/505.png" title="xkcd 554 Not Enough Work" alt="Yes we support gopher!" />
    <p class="sans-serif">
        Were sorry but it appears that your http version is not supported by this server. If you believe this in error and
        are using a modern web browser, Please try again later. If you are attempting to view
        this page using gopher, please use our gopher version <a href="gopher://<?php echo $settings['url']; ?>gopher.php">instead</a>.
    </p>