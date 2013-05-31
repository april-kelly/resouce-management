<html>

<head>
	<title>Bluetent Resouce Management: Dashboard</title>
	<link rel="stylesheet" href="./styles/styles.css" type="text/css">
</head>
<body>

<div id="header">

    <img src="./images/logo.gif" />

    <?php

    require_once(dirname(__FILE__).'/nav.php');

    ?>

</div>

    <div id="main">

        <h3>Monthly Overview:</h3>

        <?php

        		require_once('month.php');

        ?>

    </div>

</body>

</html>
