<!DOCTYPE html>
<html>
<head>
	<style>
	.error {color: #FF0000;}

	.item1 { grid-area: header }
	.item2 { grid-area: left }
	.item3 { grid-area: center }
	.item4 { grid-area: right }
	.item5 { grid-area: table }
	.item6 { grid-area: total }
	.item7 { grid-area: footer }

	.grid-container {
		display: grid;
		grid-template-areas:
			'header header header header header header'
			'left center center center center right'
			'table table table table table total'
			'footer footer footer footer footer footer';
		gap: 10px;
		background-color: #2196F3;
		padding: 10px;
	}

	.grid-container > div {
		background-color: rgba(255, 255, 255, 0.8);
		text-align: center;
		padding: 16px 0;
		font-size: 16px;
	}
	</style>
</head>
<body>

<?php
// define variables and set to empty values
$nameErr = $empidErr = $weekErr = "";
$name = $empid = $week = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST['name'])) {
		$nameErr = "Name is required";
	} else {
    	$name = test_input($_POST['name']);
		if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
			$nameErr = "Only letters and white space allowed";
		}
	}

	if (empty($_POST['empid'])) {
		$empidErr = "Employee ID is required";
	} else {
    	$empid = test_input($_POST['empid']);
		if (!preg_match("/^[0-9]*$/",$empid)) {
			$empidErr = "Only numbers allowed";
		}
	}

	if (empty($_POST['week'])) {
		$weekErr = "Week number required";
	} else {
    	$week = test_input($_POST['week']);
		if (!preg_match("/^[0-9]*$/",$week)) {
			$weekErr = "Only numbers allowed";
		} else {
			if ($week > 52) {
				$weekErr = "Only 52 weeks in a year";
			}
		}
	}
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
<div class="grid-container">
	<div class="item1"><h2>Weekly Time Card</h2></div>
	<div class="item2" style="text-align: left";>
		<p><span class="error">* required field</span></p>
		  Name: <input type="text" name="name" value="<?php echo $name;?>">
		  <span class="error">* <br><?php echo $nameErr;?></span>
		  <br><br>

		  Emplyee ID: <input type="text" name="empid" value="<?php echo $empid;?>">
		  <span class="error">* <br><?php echo $empidErr;?></span>
		  <br><br>
	</div>
	<div class="item3">
		<img src="timeclock.jpg" alt="Time Clock" style="width:1000px;">	
	</div>
	<div class="item4" style=text-align: left;>
		<h3>Week Number</h3>
		  Week: <input type="text" name="week" value="<?php echo $week;?>">
		  <span class="error">* <br><?php echo $weekErr;?></span>
		  <br><br>
	</div>
	<div class="item5" alt="Data entry">
		Data entry here
	</div>
	<div class=item7>
		  <input type="submit" name="submit" value="Submit">
	</div>
</form>
</div>

<?php
if ($name) {
	echo "<h2>Your Input:</h2>";
	echo "Name: " . $name . "<br>";
	echo "Employee ID: " . $empid . "<br>";
	echo "Week: " . $week . "<br>";
}
?>

</body>
</html>

