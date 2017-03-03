<?php
	
	require_once '../connection/DB.class.php';
	$configFile = include('../config/app.conf');
	session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Print</title>
        <link rel="stylesheet" href="<?=$configFile['base_dir'];?>asset/css/salvattore.css">

        <!-- For demo only -->
        <link rel="stylesheet" href="<?=$configFile['base_dir'];?>asset/css/styles.css">
    </head>
    <body>

        <div id="timeline" data-columns>
			<?php
					
				$db = Database::getInstance();
				$mysqli = $db->getConnection(); 
				$sql_query = "SELECT * FROM customers WHERE cusId in(".$_GET['id'].") ORDER BY cusId DESC";
				$resultEl = $mysqli->query($sql_query)->fetch_all(MYSQLI_ASSOC);

			?>
			<?php foreach ($resultEl as $key=>$cus) { $key++; ?>
			<div class="item borderBox">
                <p><?=base64_decode($cus['note']);?></p>
            </div>
			<?php } ?>
        </div>

        <!-- The script must be included at the bottom of the body to work -->
        <script src="<?=$configFile['base_dir'];?>asset/js/salvattore.min.js"></script>
    </body>
</html>