<?php require_once '../Kernel.php';?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Storer : ข้อมูลการสั้งซื้อ</title>

	<link href="<?=$configFile['base_dir'];?>asset/css/bootstrap.css" rel="stylesheet">
	<link href="<?=$configFile['base_dir'];?>asset/css/sb-admin.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=$configFile['base_dir'];?>asset/font-awesome/css/font-awesome.min.css">
	 
	
	<style>
	
</style>
  </head>

  <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Storer Dashboard</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li ><a href="listOrder.php"><i class="fa fa-dashboard"></i> รายการสั่งซื้อ</a></li>
          </ul>
        </div>
      </nav>
	  
	   <div id="page-wrapper">
	  <div class="row">
          <div class="col-lg-12">
            <h1>ข้อมูลการสั้งซื้อ</h1>
          </div>
        </div><!-- /.row -->
		<hr/>
		<div class="row">
          <div class="col-sm-6">
			<?php 
				$db = Database::getInstance($configFile);
				$mysqli = $db->getConnection(); 
				$sql_query = "SELECT * FROM orders JOIN users on orders.userToken = users.lineUserId WHERE orderId = '".$_GET['orderId']."'";
				$result = $mysqli->query($sql_query)->fetch_object();
			?>
            <form action="action/updateOrder.php" method="POST" class="form-horizontal">
			  <input type="hidden" id="orderId" name="orderId" value="<?=$result->orderId;?>" >
			  <div class="form-group">
				<label for="name" class="col-sm-3 control-label">ผู้สั่ง</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="name" name="name" value="<?=base64_decode($result->firstname);?> <?=base64_decode($result->lastname);?>" readonly>
				</div>
			  </div>
			  <div class="form-group">
				<label for="note" class="col-sm-3 control-label">ข้อความ</label>
				<div class="col-sm-9">
				  <textarea rows="10" cols="50" id="note" name="note"><?=base64_decode($result->note);?></textarea>
				</div>
			  </div>
			  <div class="form-group">
				<label for="datetime" class="col-sm-3 control-label">วัน - เวลา บันทึก</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="datetime" name="datetime" value="<?=$result->dateTimeStamp;?>" readonly >
				</div>
			  </div>
			  <div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
				  <button type="submit" class="btn btn-success">บันทึก</button>
				  <a href="order.php"  class="btn btn-default">ยกเลิก</a>
				 </form>
				</div>
			  </div>
			
          </div>

      </div><!-- /#page-wrapper -->
	</div>
	
	</div><!-- /#wrapper -->
	  
    <!-- JavaScript -->
    <script src="<?=$configFile['base_dir'];?>asset/js/jquery-1.10.2.js"></script>
    <script src="<?=$configFile['base_dir'];?>asset/js/bootstrap.js"></script>
  </body>
  
</html>
