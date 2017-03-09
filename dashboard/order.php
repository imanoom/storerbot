<?php require_once '../Kernel.php';?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Storer Bot : รายการสั่งซื้อ</title>

	<link href="<?=$configFile['base_dir'];?>asset/css/bootstrap.css" rel="stylesheet">
	<link href="<?=$configFile['base_dir'];?>asset/css/sb-admin.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=$configFile['base_dir'];?>asset/font-awesome/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="//cdn.datatables.net/v/dt/dt-1.10.12/se-1.2.0/datatables.min.css">
	<link rel="stylesheet" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.1.0/css/dataTables.checkboxes.css">
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
            <h1>
			  <span>รายการสั่งซื้อ</span>
			  <button id="print" class='btn btn-primary pull-right' style="margin-left:5px" ><i class="fa fa-print" aria-hidden="true"></i> Print</button>
			  <a href="order.php?p=all" class='btn btn-success pull-right' style="margin-left:5px" ><i class="fa fa-bars" aria-hidden="true"></i> ดูรายการทั้งหมด</a>
			  <a href="order.php" class='btn btn-warning pull-right'><i class="fa fa-asterisk" aria-hidden="true"></i> ดูเฉพาะยังไม่พิมพ์</a>
			</h1>
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
         <th style="width: 45%" >ข้อความ</th>
		 <th style="width: 10%" >สถานะ</th>
         <th style="width: 10%"  class="text-center">ดูข้อมูล</th>
         <th style="width: 10%"  class="text-center">ลบออก</th>
      </tr>
   </thead>
   <tbody>
						<?php
						
							$sqlEx = " WHERE printed = '0' ";
							if(isset($_GET['p'])) {
								$sqlEx = "";
							}
						
							$db = Database::getInstance($configFile);
							$mysqli = $db->getConnection(); 
							$sql_query = "SELECT * FROM orders ".$sqlEx." ORDER BY orderId DESC";
							$resultEl = $mysqli->query($sql_query)->fetch_all(MYSQLI_ASSOC);
			
						?>
						<?php foreach ($resultEl as $key=>$cus) { $key++; ?>
							<tr class="odd gradeX">
								<td ><?=$cus['orderId'];?></td>
								<td><?=$key;?></td>
								<td><?=$cus['dateTimeStamp'];?></td>
								<td><?=mb_substr(base64_decode($cus['note']), 0, 50, 'UTF-8'). '...';?></td>
								<td><?php if($cus['printed'] == "0") { echo "ยังไม่ปริ้นท์";} else { echo "ปริ้นท์แล้ว"; } ?></td>
								<td class="text-center" ><a href="view.php?orderId=<?=$cus['orderId'];?>"><i class="fa fa-search"></i></a></td>
								<td class="text-center" ><button type="button" class="btn btn-danger btn-xs btn-delete" data-id="<?=$cus['orderId'];?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
							</tr>
						<?php } ?>
						</tbody>
</table>
				</div>
				</form>
			</div>
		</div>
	</div>
	
	<div id="modalConfirmDel" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
		  <div class="modal-content">

			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel">ยืนยันการลบ</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="dataId" id="dataId" value=""/>
				<div class="modal-body-content" >
					<h4>คุณแน่ใจว่าต้องการลบข้อมูล</h4>
				  <p>หากต้องการลบผู้ใช้งาน คลิกปุ่ม "ยืนยัน" หากไม่ต้องการ คลิกปุ่ม "ยกเลิก"</p>
				  <p><button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>  <button type="button" class="btn btn-danger" id="confirm-del">ยืนยัน</button></p>
				</div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
			</div>
		  </div>
		</div>
	  </div>
	
	</div><!-- /#wrapper -->
	  
    <!-- JavaScript -->
    <script src="<?=$configFile['base_dir'];?>asset/js/jquery-1.10.2.js"></script>
    <script src="<?=$configFile['base_dir'];?>asset/js/bootstrap.js"></script>

	 <script src="//cdn.datatables.net/v/dt/dt-1.10.12/se-1.2.0/datatables.min.js"></script>
	 <script src="//gyrocode.github.io/jquery-datatables-checkboxes/1.1.0/js/dataTables.checkboxes.min.js"></script>
	<script>
	
	$(document).ready(function() {
	   var table = $('#example').DataTable({
		  "pageLength": 100,
		  'columnDefs': [
			 {
				'targets': 0,
				'checkboxes': {
				   'selectRow': true
				},
				
			 }
		  ],
		  'select': {
			 'style': 'multi'
		  },
		  'order': [[1, 'asc']]
	   });
   
   $('#print').on('click', function(e){

		  var form = this;
		  
		  var rows_selected = table.column(0).checkboxes.selected();

		  $.each(rows_selected, function(index, rowId){
			 $(form).append(
				 $('<input>')
					.attr('type', 'hidden')
					.attr('name', 'id[]')
					.val(rowId)
			 );
		  });
		  
		  $('input[name="id\[\]"]', form).remove();
		  
		  if(rows_selected.join(",") == "") {
			  
			alert('เลือก order ที่ต้องการพิมพ์ก่อน'); 
			} else {
			window.open('print.php?id='+rows_selected.join(","),'_blank');
			}
		  

		  e.preventDefault();
		  });   
	});
	
	//Modal Confirm Del
	$('.btn-delete').on('click', function(e) {
		e.preventDefault();
		var dataId = $(this).data('id');
     	$(".modal-body #dataId").val( dataId );
		$('#modalConfirmDel').modal('show');
	});
	
	$('#confirm-del').click(function() {
		var id = $('.modal-body #dataId').val();
	
		$("#confirm-del").prop("disabled",true);
	
		$( ".modelDelAlert" ).hide();
		$(".modal-body").prepend('<div class="modelDelAlert alert alert-warning alert-dismissible fade in" role="alert"><strong><i class="fa fa-refresh fa-spin fa-fw"></i> กำลังลบ</strong></div>');
		
		$.get('action/deleteOrder.php?orderId='+id,
			function(data, status){
				if(status == 'success') {
					$( ".modal-body-content" ).hide();
					$( ".modelDelAlert" ).hide();
					$(".modal-body").prepend('<div class="modelDelAlert alert alert-success alert-dismissible fade in" role="alert"><strong>สำเร็จ</strong></div>');	
					$( "#messageRow"+id ).remove();

					setTimeout(function() {
						location.reload();
					}, 1000);

				} else {
					$( ".modelDelAlert" ).hide();
					$(".modal-body").prepend('<div class="modelDelAlert alert alert-danger alert-dismissible fade in" role="alert"><strong>ไม่สามารถดำเนินการได้ โปรดดำเนินการในภายหลัง</strong></div>');
				}
			}).error(function() {
				$( ".modelDelAlert" ).hide();
				$(".modal-body").prepend('<div class="modelDelAlert alert alert-danger alert-dismissible fade in" role="alert"><strong>ไม่สามารถดำเนินการได้ โปรดดำเนินการในภายหลัง</strong></div>');
			});
		
	});

	//End Modal Confirm Del
	
	
	</script>

  </body>
  
</html>
