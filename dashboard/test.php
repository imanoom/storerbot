<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Strict//EN">
<?php
	
	require_once '../Kernel.php';
	
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Print</title>
		<style>
			    body {
					width: 100%;
					height: 100%;
					margin: 0;
					padding: 0;
					background-color: #FAFAFA;
					font: 12pt "Tahoma";
				}
				* {
					box-sizing: border-box;
					-moz-box-sizing: border-box;
				}
				.page {
					width: 210mm;
					min-height: 297mm;
					padding: 5mm;
					margin: 10mm auto;
					border: 1px #D3D3D3 solid;
					border-radius: 5px;
					background: white;
					box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
				}
				.subpage {
					<!--padding: 0.5cm;-->
					border: 5px red solid;
					height: 277mm;
					outline: 2cm #000 solid;
					overflow: hidden;
				}
				
				@page {
					size: A4;
					margin: 0;
				}
				@media print {
					html, body {
						width: 210mm;
						height: 297mm;        
					}
					.page {
						margin: 0;
						border: initial;
						border-radius: initial;
						width: initial;
						min-height: initial;
						box-shadow: initial;
						background: initial;
						page-break-after: always;
					}
				}
				
				div.content {
					max-width: 65mm;
					border: 1px solid #000;
					display:inline-block;
					padding: 10px;
					vertical-align: top;
				}
				
				.site-container,
				.element-container,
				.my-element {
					margin: 0;
					padding: 0;
				}
				.site-container {
					display: block;
					width: 960px;
					margin: 0 auto; /* centers your site container on the page */
					clear: both; /* basic float clearing */
				}
				.element-container {
					display: inline-block;
					float: left;
					max-width: 210mm;
					margin-right: 0px;
				}
				.my-element {
					max-width: 66mm;
					border: 1px solid #000;
					margin-bottom: 0px;
					padding: 15px;
					
					font-size: 14px;
					line-height: 1.8em;
					letter-spacing: 0.5px;
				}
.red {
					font: 30pt "Tahoma";
				}
		</style>
    </head>
    <body  > <!--onload="window.print()"-->
		<div class="book">
			<div class="book">
			<div class="page">
				<div class="subpage">
					<div  class="site-container">
						<div class="element-container">
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							
						</div> 
						<div class="element-container">
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							<div class="my-element"><u><b>กรุณาส่ง</b></u><br/>sdvsdcsdcsdvsdcsdcsdvs dcsdcsdvsdcsdcsdvsd csdcsdvsdcsdcsdvsdcsdcsdvsdcsdc</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="<?=$configFile['base_dir'];?>asset/js/jquery.base64.js"></script>
    </body>
	
	<script>
		
		$(document).ready(function() {

			alert(">> "+$( ".element-container" ).height());
		});
	
	</script>

</html>