<!doctype html>
<html lang="en">
  <head>
    <title>CETA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../DataTables/datatables.css"/>
  
    <style>
      .blackisgold{
        background-color:rgba(0,0,0,0.6) !important;
      }
      .hovering,.btn-hovering {
        color:white !important ;
        background-color:rgba(0,0,0,0.9) !important; 
      }

	  .btn-hovering:hover {
		color:black !important;
		background-color:rgba(0,0,0,0.3) !important;}
    
    </style>
  </head>
  
  <body style="background-color:rgba(0,0,0,0.2);">
	
  	<script src="https://code.jquery.com/jquery-3.4.1.min.js"integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../DataTables/datatables.js"></script>
    
    <script>
      $(document).ready(function() {
        $('#eventpass').DataTable( {
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "createdRow": function( row, data, dataIndex){
                        $(row).addClass('blackisgold');
                    }
            });
          $("[name='eventpass_length']").css({"background-color":"rgba(0,0,0,0.8)","color":"white"});
          $("input[type='search']").css({"background-color":"rgba(0,0,0,0.8)","color":"white"});
      });
    
    </script>

	<!-- Modal -->
	<div class="modal fade" id="eventsmodal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Alert.</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
				</div>
				<div class="modal-body">
					Body
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

    <div class="container m-5">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
			
			<div class="container">
				<div class="row">
					<div class="col-12 col-xl-3">
						<input type="submit" class="btn btn-hovering"  name="genpass" value='Generate Password'>		
					</div>
					<div class="col-12 col-xl-3">
						<input type="submit" class="btn btn-hovering"  name="deletepass" value='Delete Password'>						
					</div>
					<div class="col-12 col-xl-3">
						<input type="submit" class="btn btn-hovering"  name="showpass" value='Show Password'>
					</div>
					<div class="col-12 col-xl-3">
					<input type='button' name='print' class="btn btn-hovering" value='Print' id='print' onclick="window.print()"> 
					</div>
				</div>
			</div>
			
			
		</form>

		<br>
		<table id="eventpass" class="table table-dark hover" cellspacing="0" width="100%">
			<thead>
			<tr> 	
					<th class="th-sm">Pin</th>
					<th class="th-sm">Used</th>
			</tr>
			</thead>
			<tbody>
			<?php
				if($_SERVER["REQUEST_METHOD"]=="POST")
				{
					require('../../dbconfig.php');
					$conn= mysqli_connect($server_name,$user,$pass,$db);
					if (!mysqli_connect_errno($conn))
					{
						if(isset($_POST["genpass"]))
						{
							
							$sql="CREATE TABLE ".$db.".pingenerator ( `pin` VARCHAR(20) NOT NULL , `used` INT NOT NULL DEFAULT '0' )";
							if($conn->query($sql))
							{
								$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
									$sql = "insert into pingenerator values";
									$sep = ",";
									$totpasscount = 240;
									for($i=0;$i<$totpasscount;$i++)
									{
									$pass = substr(str_shuffle($alphabet),0,10);
									if($i == $totpasscount-1) {
										$sep = ";";
									}
									$sql.="('$pass',0)".$sep;
									}
									if($conn->query($sql)){
										echo("<script> setTimeout(function () {
											$('#eventsmodal').modal('hide');
											}, 1500);
											$('#eventsmodal').modal('show');
											$('.modal-body').html('Registration Passwords generated successfully.');
										
										</script>");
									}else {
										echo("<script> setTimeout(function () {
											$('#eventsmodal').modal('hide');
											}, 1500);
											$('#eventsmodal').modal('show');
											$('.modal-body').html('Registration Password generation failed.');
										
										</script>");
									}
							}
								
							else{
								
								echo("<script> setTimeout(function () {
									$('#eventsmodal').hide();
									}, 1500);
									$('#eventsmodal').modal('show');
									$('.modal-body').html('Registration Passwords generation failed.');
								
								</script>");
							}
						}
						
						
						if(isset($_POST["deletepass"]))
						{
							$sql="drop TABLE `pingenerator`";
							$conn->query($sql);
							
							echo("<script> setTimeout(function () {
								$('#eventsmodal').modal('hide');
								}, 1500);
								$('#eventsmodal').modal('show');
								$('.modal-body').html('Passwords deleted successfully.');
							
							</script>");
						
						}
						
						
						if(isset($_POST["showpass"]))
						{		
								$sql="select * from pingenerator";
								$res=$conn->query($sql);
								
								if($res)
								{
									while($row=$res->fetch_row())
									{
										echo "<tr>";
										echo "<td>".$row[0]."</td>";
										echo "<td>".$row[1]."</td>";
										echo "</tr>";
									}
								}

								else
								{
									
								echo("<script> setTimeout(function () {
									$('#eventsmodal').modal('hide');
									}, 1500);
									$('#eventsmodal').modal('show');
									$('.modal-body').html('Passwords not generated.');
								
								</script>");
								}
								
						}
					}	
				}
			?>
			
			</tbody>

			<tfoot>
			</tfoot>
		</table>
    </div>

  </body>
</html>