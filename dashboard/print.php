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
					outline: 2cm #fff solid;
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
    <body> <!---->
		<div class="book">
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="<?=$configFile['base_dir'];?>asset/js/jquery.base64.js"></script>
    </body>
	
	<script>
	
	
	$(document).ready(function() {

		$.ajax({ url: 'action/callOrder.php',
			 data: {id: '<?=$_GET['id'];?>'},
			 type: 'get',
			 dataType: 'json',
			 success: function(output) {
			 
				var elementTemp = new Array();
				var monitor = false;
				
				var numOfPage = 1;
				var addNewPage = true;
			 
				var numOfCol = 0;
				var maxOfCol = 3;
				var endOfCol = false;
				var addNewCol = true;
				
				var numOfElement = 1;
	
				$.each(output, function(index, element) {
					elementTemp.push('<u><b>กรุณาส่ง</b></u><br/>'+nl2br($.base64.atob(element.note, true)));
				});
				
				var sizeOfLoop = elementTemp.length;
				
				for(i=0; i < sizeOfLoop;i++) {
	
					if(addNewPage) {
						$( ".book" ).append( '<div id="numOfPage'+numOfPage+'" class="page"><div class="subpage"><div id="containerPage'+numOfPage+'" class="site-container"></div></div></div> ');
						addNewPage = false;
					}
					
					if(addNewCol) {
						$( "#containerPage"+numOfPage ).append( '<div id="dataCol'+numOfPage+numOfCol+'" class="element-container"></div>');
						addNewCol = false;
					}
					
					///////////////////////////////////////////
					
					var nowColSize = $( '#dataCol'+numOfPage+numOfCol ).height();
		
					var text = elementTemp.shift();
			
					if(numOfCol > 0 && numOfElement < 2) {
						sizeOfLoop--;
						$( "#dataCol"+numOfPage+numOfCol ).append( '<div id="elePop'+numOfPage+numOfCol+i+'" class="my-element">'+elementTemp.pop()+'</div>' );
						var nowColSize = $( '#elePop'+numOfPage+numOfCol+i ).height();
					}
					
					$( "#dataCol"+numOfPage+numOfCol ).append( '<div id="ele'+numOfPage+numOfCol+i+'" class="my-element">'+text+'</div>' );
					
					var sizeLastDiv = $( '#ele'+numOfPage+numOfCol+i ).height();
	
					var sumDiv = nowColSize+sizeLastDiv;
		
					if(sumDiv > 1000) {
						$( '#ele'+numOfPage+numOfCol+i ).remove();
						elementTemp.push(text);
						sizeOfLoop++;
						monitor = true;
					}
					
					if(monitor || 1000-sumDiv < 200 ) {
						if($('#ele'+numOfPage+numOfCol+i).closest("html").length == 1) {
							endOfCol = true;
							monitor = false;
						}
					}
					
					///////////////////////////////////////////
					numOfElement++;
					
					if(endOfCol) {

						addNewCol = true;
						numOfCol++;
						
						endOfCol = false;
						numOfElement = 1;
					
					}
					
					if(numOfCol == maxOfCol) {
					
						addNewPage = true;
						numOfPage++;
						
						numOfCol = 0;
						
					}
					
				}
				
				window.print();
				//alert(elementTemp.length);

			 }
		});
	});
	
	function px2mm(px) {
	  var d = $("<div/>").css({ position: 'absolute', top : '-1000cm', left : '-1000cm', height : '1000cm', width : '1000cm' }).appendTo('body');
	  var px_per_cm = d.height() / 10000;
	  d.remove();
	  return px / px_per_cm;
	}
	
	function nl2br (str, is_xhtml) {
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}

	</script>

</html>