<ul>
    <li><a href="./?p=home">Overview</a></li>
    <li><a href="./?p=request">Request</a></li>
    <li><a href="./?p=admin">Settings</a></li>
    <?php if(!(isset($_SESSION['name']))){ ?>
    <li><a href="./?p=login">Login</a></li>
    <?php }else{ ?>
    <li><a href="./?p=user">Hi, <?php echo $_SESSION['name']; ?></a></li>
    <?php } ?>
</ul>

