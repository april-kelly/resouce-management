<?php

/**
 * Name:       Resource Management Base Template
 * Version:    2.0
 * Programmer: Liam Kelly
 * Date:       7/17/13
 */

//Start the users session (if not set)
if(!(isset($_SESSION))){
    session_start();
}

?>
<!DOCTYPE html>
<html>
<head>

    <title>Bluetent Resource Management</title>

    <link rel="stylesheet" href="../styles/styles.css" type="text/css" />
    <link rel="icon" href="../images/btm_favicon.ico" />

    <meta charset="UTF-8">

    <?php

        //This is for anything extra that need to go into the head section
        if(isset($_SESSION['page_head_extras'])){

            include_once('./head_extras.html');
            unset($_SESSION['page_head_extras']);

        }

    ?>

</head>
<body>

<div id="header">

    <img src="../images/logo.gif" style="center" alt="Bluetent Marketing"/>

    <?php

        //Now we include the navigation bar
        include_once('./nav.php');

    ?>

</div>

<div id="<?php if(isset($_SESSION['main_id'])){ echo $_SESSION['main_id']; unset($_SESSION['main_id']); }else{ echo 'error'; };?>">


    <?php

        //...and now for the requested page
        if(isset($_SESSION['page_location'])){

            include_once(ABSPATH.$_SESSION['page_location']);
            unset($_SESSION['page_location']);

        }else{

              //Something is wrong display the 500 error page
                include_once('./500.php');

        }

    ?>

</div>

<div id="footer">

    <?php

        //Last but not least the footer
        include_once(ABSPATH.'includes/footer.php');

    ?>

</div>

</body>
</html>