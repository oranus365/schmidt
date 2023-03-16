<?php

$servername = "localhost";
$dBUsername = "u556428795_schmidt";
$dBPassword = "Spatzenhausen@2023";//Spatzenhausen@2023
$dBName = "u556428795_bonsai";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);




// pass in the number of seconds elapsed to get hours:minutes:seconds returned
function secondsToTime($s)
{
    $h = floor($s / 3600);
    $s -= $h * 3600;
    $m = floor($s / 60);
    $s -= $m * 60;
    return $h.':'.sprintf('%02d', $m).':'.sprintf('%02d', $s);
}

$startTime = intval(microtime(true));


if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}


if (isset($_POST['toggle_LED'])) {
    
    
	$sql = "SELECT * FROM Ventil_Status;";
	$result   = mysqli_query($conn, $sql);
	$row  = mysqli_fetch_assoc($result);

    $update = mysqli_query($conn, "UPDATE Ventil_Status SET time = ".$startTime." WHERE id = 1;");
	
	if($row['status'] == 0){
		$update = mysqli_query($conn, "UPDATE Ventil_Status SET status = 1 WHERE id = 1;");
        $update = mysqli_query($conn, "UPDATE Ventil_Status SET statusText = 'auf' WHERE id = 1;");
	}		
	else{
		$update = mysqli_query($conn, "UPDATE Ventil_Status SET status = 0 WHERE id = 1;");
        $update = mysqli_query($conn, "UPDATE Ventil_Status SET statusText = 'zu' WHERE id = 1;");
	}
}






$sql = "SELECT * FROM Ventil_Status;";
$result   = mysqli_query($conn, $sql);
$row  = mysqli_fetch_assoc($result);

$elapsed = microtime(true)-$row['time'];


//if longer than 15s shut the valve
if ($row['status']==1 & $elapsed > 15.0 ) {
    

    $update = mysqli_query($conn, "UPDATE Ventil_Status SET status = 0 WHERE id = 1;");
    $update = mysqli_query($conn, "UPDATE Ventil_Status SET statusText = 'zu' WHERE id = 1;");
    $update = mysqli_query($conn, "UPDATE Ventil_Status SET time = ".$startTime." WHERE id = 1;");
    //header("Refresh:0");
}


?>




<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--script src="https://kit.fontawesome.com/b8c226f5c1.js" crossorigin="anonymous"></script-->
    
	<!--link rel="stylesheet" type="text/css" href="Style.css"-->
	
	<style>
	.wrapper{
		width: 100%;
		padding-top: 30px;
		color: #000; 
	}
	.col_3{
		width: 33.3333333%;
		float: left;
		min-height: 1px;
	}
	#submit_button{
		background-color: #2B5CFF; 
		color: #FFF; 
		font-weight: bold; 
		font-size: 40; 
		border-radius: 15px;
    	text-align: center;
	}
	#submit_button:active{
		background-color: #5CFF2B; 
		color: #FFF; 
		font-weight: bold; 
		font-size: 40; 
		border-radius: 15px;
    	text-align: center;
	}
	
	@media only screen and (max-width: 600px) {
		.col_3 {
			width: 100%;
		}
		.wrapper{
			width: 100%;
			padding-top: 4px;
		}
	}

    </style>
	
	<title>Bonsai</title>
</head>


<body>
	<div class="wrapper" id="refresh">
		<div class="col_3">
		</div>

		<div class="col_3" >
			
			<?php 
                echo '<h1 style="text-align: center;">Wasserhahn ist  '.$row['statusText'].'</h1>';
                echo '<h1 style="text-align: center;">Die Zeit seitdem der Wasserhahn '.$row['statusText'].' ist = '.secondsToTime($elapsed).'</h1>';?>
			
			<div class="col_3">
			</div>
			
			<div class="col_3" style="text-align: center;">
			<form action="h3a4U6p12T.php" method="post" id="LED" enctype="multipart/form-data">			
				<input id="submit_button" type="submit" name="toggle_LED" value="Wasserhahn" />
			</form>
				

			</br>
			</br>
			


					
			</div>
				
			<div class="col_3">
			</div>
		</div>

		<div class="col_3">
		</div>

	</div>
	
			<script type="text/javascript">
			
			var intervalId = setInterval(function() {
			  $('#refresh').load(' #refresh', 'update=true');
			}, 1000);
			

	    </script>

	

	
	<div style="text-align: center;" id="charts">
	        <iframe width="450" height="260" style="border: 1px solid #cccccc;" src="https://thingspeak.com/channels/1047096/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>
	</div>

	



</body>

	
</html>