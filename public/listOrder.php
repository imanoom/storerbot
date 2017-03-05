<?php
	
	require_once '../connection/DB.class.php';
	$configFile = include('../config/app.conf');
	
	session_start();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Storer</title>

	<link href="<?=$configFile['base_dir'];?>asset/css/bootstrap.css" rel="stylesheet">
	<link href="<?=$configFile['base_dir'];?>asset/css/sb-admin.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=$configFile['base_dir'];?>asset/font-awesome/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="//cdn.datatables.net/v/dt/dt-1.10.12/se-1.2.0/datatables.min.css">
	<link rel="stylesheet" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.1.0/css/dataTables.checkboxes.css">
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	 
    
	<!--<link href="<?=$configFile['base_dir'];?>asset/css/dataTables.bootstrap.css" rel="stylesheet">-->
	
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
            <h1>รายการสั่งซื้อ</h1>
          </div>
        </div><!-- /.row -->
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<form id="frm-example" action="" method="POST">
					<table id="example" class="display" cellspacing="0" width="100%">
   <thead>
      <tr>
         <th style="width: 5%" ></th>
         <th style="width: 5%" >No.</th>
         <th style="width: 15%" >วัน/เวลา ที่บันทึก</th>
         <th style="width: 45%" >ชื่อ - นามสกุล</th>
		 <th style="width: 10%" >สถานะ</th>
         <th style="width: 10%"  class="text-center">ดูข้อมูล</th>
         <th style="width: 10%"  class="text-center">ลบออก</th>
      </tr>
   </thead>
   <tbody>
						<?php
						
							$db = Database::getInstance();
							$mysqli = $db->getConnection(); 
							$sql_query = "SELECT * FROM orders ORDER BY printed ,orderId DESC";
							$resultEl = $mysqli->query($sql_query)->fetch_all(MYSQLI_ASSOC);
			
						?>
						<?php foreach ($resultEl as $key=>$cus) { $key++; ?>
							<tr class="odd gradeX">
								<td ><?=$cus['orderId'];?></td>
								<td><?=$key;?></td>
								<td><?=$cus['dateTimeStamp'];?></td>
								<?php
								
									$full_text = base64_decode($cus['note']);
									$full_texts = explode(" ", $full_text);
								
								?>
								<td><?=$full_texts[0];?>  <?=$full_texts[1];?></td>
								<td><?php if($cus['printed'] == "1") { echo "Print แล้ว"; } else { echo "ยังไม่ Print"; } ?></td>
								<td class="text-center" ><a href="view.php?orderId=<?=$cus['orderId'];?>"><i class="fa fa-search"></i></a></td>
								<td class="text-center" ><a href="action/deleteOrder.php?orderId=<?=$cus['orderId'];?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
							</tr>
						<?php } ?>
						</tbody>
</table>
				</div>
				<p><button class="btn btn-success">Print</button></p>
				<!--
				<p><b>Selected rows data:</b></p>
				<pre id="example-console-rows"></pre>

				<p><b>Form data as submitted to the server:</b></p>
				<pre id="example-console-form"></pre>
				-->
				</form>
			</div>
		</div>
	</div>
	
	</div><!-- /#wrapper -->
	  
    <!-- JavaScript -->
    <script src="<?=$configFile['base_dir'];?>asset/js/jquery-1.10.2.js"></script>
    <script src="<?=$configFile['base_dir'];?>asset/js/bootstrap.js"></script>

	 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	 <script src="//cdn.datatables.net/v/dt/dt-1.10.12/se-1.2.0/datatables.min.js"></script>
	 <script src="//gyrocode.github.io/jquery-datatables-checkboxes/1.1.0/js/dataTables.checkboxes.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
$(document).ready(function() {
   var table = $('#example').DataTable({
	  "pageLength": 100,
      'columnDefs': [
         {
            'targets': 0,
            'checkboxes': {
               'selectRow': true
            }
         }
      ],
      'select': {
         'style': 'multi'
      },
      'order': [[1, 'asc']]
   });
   
   // Handle form submission event 
   $('#frm-example').on('submit', function(e){
      var form = this;
      
      var rows_selected = table.column(0).checkboxes.selected();

      // Iterate over all selected checkboxes
      $.each(rows_selected, function(index, rowId){
         // Create a hidden element 
         $(form).append(
             $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'id[]')
                .val(rowId)
         );
      });
	  
	  //alert(rows_selected.join(","));

      // FOR DEMONSTRATION ONLY
      // The code below is not needed in production
      
      // Output form data to a console     
      //$('#example-console-rows').text(rows_selected.join(","));
      
      // Output form data to a console     
      //$('#example-console-form').text($(form).serialize());
       
      // Remove added elements
      $('input[name="id\[\]"]', form).remove();
	  
	  window.open('print.php?id='+rows_selected.join(","),'_blank');
       
      // Prevent actual form submission
      e.preventDefault();
	  });   
});
	</script>

  </body>
  
</html>
