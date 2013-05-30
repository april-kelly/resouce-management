<html>

<head>
	<title>Bluetent Resouce Management: Dashboard</title>
	<link rel="stylesheet" href="./styles/styles.css" type="text/css">
</head>
<body>

    <div id="header">

        <img src="./images/logo.gif" style="center"/>

        <ul>
           <li><a href="./dashboard.php">Overview</a></li>
           <li><a href="./index.php">Request</a></li>
           <li><a href="./admin/index.php">Login</a></li>
           <li><a href="./admin/admin.php">Settings</a></li>
        </ul>

    </div>

    <div id="main">

        <h3>Monthly Overview:</h3>

        <?php

        		require_once('month.php');

        ?>

    </div>

</body>

</html>
