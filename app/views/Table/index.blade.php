<!doctype html>
<html>
    <head>
        <title>Minimal Bootflat example</title>
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://bootflat.github.io/bootflat/css/bootflat.css">
    	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.0.1/pivot.min.css" rel="stylesheet" />	    	

    </head>

    <body>
        
        <nav class="navbar navbar-inverse navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="#">Table Generator</a>
	        </div>
			<!--	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <form class="navbar-form navbar-right">
	            <div class="form-group">
	              <input type="text" placeholder="Email" class="form-control">
	            </div>
	            <div class="form-group">
	              <input type="password" placeholder="Password" class="form-control">
	            </div>
	            <button type="submit" class="btn btn-success">Sign in</button>
	          </form>
	        </div><!--/.navbar-collapse -->
	    	-->
	      </div>
	    </nav>

	    <!-- Main jumbotron for a primary marketing message or call to action -->
	    <div class="jumbotron" style="padding-top: 50px;">
	      <div class="container">
	        <h1>Hello Guys!</h1>
	        <p>This is a simple  application to generate dynamic table from database</p>
	        
	      </div>
	    </div>
	      

	    <div class="container">
	      <!-- Example row of columns -->
	      <div class="row">
	        <div class="col-md-4">
	          <h2>Select Subject</h2>
			  <select class="select-subject" style="width:100%"></select>

	          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
	        </div>
	        <div class="col-md-4">
	          <h2>Select Variable</h2>
	          <select class="select-variable" style="width:100%"></select>


	          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
	       </div>
	        <div class="col-md-4">
	          <h2>Select Regional</h2>
	          <select class="select-region" style="width:100%"></select>

	          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
	        </div>
	      </div>

	      <hr>
	      <div class="row" width="100%" style="overflow:scroll"><div class="col-md-12" id="output"></div></div>
	    
	      
	      <footer>
	        <p>&copy; 2016 Company, Inc.</p>
	      </footer>
	    </div> <!-- /container -->

        <!-- Bootstrap -->
        <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
        <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        <script src="{{asset('assets/pivot.js')}}"></script>
        <script src="{{asset('assets/table2CSV.js')}}"></script>
        <script src="{{asset('assets/tableExport.js')}}"></script>
        <script src="{{asset('assets/jquery.base64.js')}}"></script>

        <!-- Bootflat's JS files.-->
        <script src="https://bootflat.github.io/bootflat/js/icheck.min.js"></script>
        <script src="https://bootflat.github.io/bootflat/js/jquery.fs.selecter.min.js"></script>
        <script src="https://bootflat.github.io/bootflat/js/jquery.fs.stepper.min.js"></script>


        <script type="text/javascript">
			//var data = [{ id: 0, text: 'enhancement' }, { id: 1, text: 'bug' }, { id: 2, text: 'duplicate' }, { id: 3, text: 'invalid' }, { id: 4, text: 'wontfix' }];
			var dataTopik = {{$topik}};
			var dataFakta,selected,selected2;

			console.log(dataTopik);

			$(".select-subject").select2({
				data: dataTopik
			})

									
			$(".select-subject").change(function() {
				//console.log($(".select-subject").val());
				console.log("Subjek : "+$(".select-subject").val());

				selected = $(".select-subject").val();

				//$(".select-variable").select2("val", null);
				$(".select-variable").html("");

				if(selected!=0){
					
					$.getJSON( "getVariabel/"+selected, function( data ) {
					  	
					  	$(".select-variable").select2({
					  		placeholder: "Select Variable",
							data: data
						})

					}).done(function(){
						
						selected2 = $(".select-variable").val();
						console.log("Variabel : "+selected2);

						console.log("selected : "+selected+" - "+selected2);

						//$(".select-region").html("");

						$.getJSON("getRegional/"+selected+"/"+selected2,function(data){

							$(".select-region").select2({
						  		placeholder: "Select Regional",
								data: data
							})

						}).done(function(){
							
							selected3 = $(".select-region").val();

							$.getJSON("getFakta/"+selected+"/"+selected2+"/"+selected3,function(data){
								
								dataFakta = data;
							
							}).done(function(){
								
								console.log(dataFakta);	
								var dataBuatTable = (dataFakta["data"]);
								for(var i=0;i<dataBuatTable.length;i++){
									delete dataBuatTable[i].kode_sumber_data;
									delete dataBuatTable[i].id;
									delete dataBuatTable[i].kode_topik_variabel;
								}
									
							 	console.log(dataBuatTable);	
							 	$("#output").pivotUI(
								    dataBuatTable,
								    {
								    	rows: ["kode_wilayah"],
								    	cols: ["tahun"],
			   						 	vals: ["nilai"],
								    	aggregatorName: "Sum"
									}
								);	
								$('.pvtRendererArea').on('DOMNodeInserted','.pvtTable',function(){
									
								 	$("#output .csvmaker").remove();
									var tableF = $('.pvtTable');	
								  	console.log($('.pvtTable'));
								    var $button = $("<button class='csvmaker' type='button'>");
								    $button.text("Export to spreadsheet");
								    $("#output").append($button);
								    $button.click(function() {
								       //tableF.tableExport({type:'csv',escape:'false'});
								    	
								      var csv = tableF.table2CSV({delivery:'value'});
								      window.location.href = 'data:text/csv;charset=UTF-8,'
								                            + encodeURIComponent(csv);
										
								    });
								});
							
							})
						
						})

					})
				}

			});

			
			

			$(".select-variable").change(function() {
				//console.log($(".select-variable").val());
				selected2 = $(".select-variable").val();
				
				console.log("selected : "+selected+" - "+selected2);


				//$(".select-region").html("");

				$.getJSON("getRegional/"+selected+"/"+selected2,function(data){

					$(".select-region").select2({
						placeholder: "Select Regional",
						data: data
					})

				}).done(function(){
					
					selected3 = $(".select-region").val();
					
					$.getJSON("getFakta/"+selected+"/"+selected2+"/"+selected3,function(data){
						
						dataFakta = data;
					
					}).done(function(){
						
						console.log(dataFakta);	
						var dataBuatTable = (dataFakta["data"]);
						for(var i=0;i<dataBuatTable.length;i++){
							delete dataBuatTable[i].kode_sumber_data;
							delete dataBuatTable[i].id;
							delete dataBuatTable[i].kode_topik_variabel;
						}
							
					 	console.log(dataBuatTable);	
					 	$("#output").pivotUI(
						    dataBuatTable,
						    {
								rows: ["kode_wilayah"],
						    	cols: ["tahun"],
	   						 	vals: ["nilai"],
						    	aggregatorName: "Sum"
							}
						);

						$('.pvtRendererArea').on('DOMNodeInserted','.pvtTable',function(){
							var tableF = $('.pvtTable');	
						  	console.log($('.pvtTable'));
						    var $button = $("<button type='button'>");
						    $button.text("Export to spreadsheet");
						    $("#output").append($button);
						 
						    $button.click(function() {
						      var csv = tableF.table2CSV({delivery:'value'});
						      window.location.href = 'data:text/csv;charset=UTF-8,'
						                            + encodeURIComponent(csv);
						    });
						});
						    
					})

				})
						
				
			});

			$(".select-region").change(function() {
				selected3 = $(".select-region").val();
				console.log("selected : "+selected+" - "+selected2+" - "+selected3);
 				
 				$.getJSON("getFakta/"+selected+"/"+selected2+"/"+selected3,function(data){
						
					dataFakta = data;
					
				}).done(function(){
						
					console.log(dataFakta);	
					var dataBuatTable = (dataFakta["data"]);
					for(var i=0;i<dataBuatTable.length;i++){
						delete dataBuatTable[i].kode_sumber_data;
						delete dataBuatTable[i].id;
						delete dataBuatTable[i].kode_topik_variabel;
					}
							
				 	console.log(dataBuatTable);	
				 	$("#output").pivotUI(
					    dataBuatTable,
					    {
					    	rows: ["kode_wilayah"],
					    	cols: ["tahun"],
   						 	vals: ["nilai"],
					    	aggregatorName: "Sum"
						}
					);
					
					$('.pvtRendererArea').on('DOMNodeInserted','.pvtTable',function(){
						var tableF = $('.pvtTable');	
					  	console.log($('.pvtTable'));
					    var $button = $("<button type='button'>");
					    $button.text("Export to spreadsheet");
					    $("#output").append($button);
					 
					    $button.click(function() {
					      var csv = tableF.table2CSV({delivery:'value'});
					      window.location.href = 'data:text/csv;charset=UTF-8,'
					                            + encodeURIComponent(csv);
					    });
					});
					
				})
			})

		</script>

		<script type="text/javascript">
			$(document).ready(function() {
			  
			  /*
			  $('.pvtTable').(function() {
			    var $table = $(this);
			 	
			    var $button = $("<button type='button'>");
			    $button.text("Export to spreadsheet");
			    $button.insertAfter($table);
			 
			    $button.click(function() {
			      var csv = $table.table2CSV({delivery:'value'});
			      window.location.href = 'data:text/csv;charset=UTF-8,'
			                            + encodeURIComponent(csv);
			    });
			  });*/
			})
		</script>	

    </body>
</html>
