<?php
	
	require_once '../Kernel.php';
	
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Print</title>
        <link rel="stylesheet" href="<?=$configFile['base_dir'];?>asset/css/salvattore.css">

        <!-- For demo only -->
        <link rel="stylesheet" href="<?=$configFile['base_dir'];?>asset/css/styles.css">
		<style>
			.senderText {
				font-size: 14px;
			}
		</style>
    </head>
    <body  > <!--onload="window.print()"-->

		<?php
					
			$db = Database::getInstance($configFile);
			$mysqli = $db->getConnection(); 
			$sql_query = "SELECT * FROM orders JOIN users ON orders.userToken = users.lineUserId WHERE orderId in(".$_GET['id'].") ORDER BY orderId DESC";
			$resultEl = $mysqli->query($sql_query)->fetch_all(MYSQLI_ASSOC);
			
			$sql_query = "UPDATE orders SET printed='1' WHERE orderId in(".$_GET['id'].")";
			$result = $mysqli->query($sql_query);

		?>
		
        <div id="timeline" data-columns>
			<?php foreach ($resultEl as $key=>$cus) { $key++; ?>
			<div class="item borderBox" >
				<?php 
					if($cus['userLevel'] == "Agent") {
				?>
				<p class="senderText" style="padding-bottom: 0px">
					<?=base64_decode($cus['firstname']);?> <?=base64_decode($cus['lastname']);?> <?=base64_decode($cus['address']);?>
					<br/> ================
				</p>
				<?php 
					}
				?>
                <p class="senderText" ><u><b>กรุณาส่ง</b></u><br/><span><?=nl2br(base64_decode($cus['note']));?></span></p>
            </div>
			<?php } ?>
        </div>

        <!-- The script must be included at the bottom of the body to work -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?=$configFile['base_dir'];?>asset/js/salvattore.min.js"></script>
    </body>

</html>