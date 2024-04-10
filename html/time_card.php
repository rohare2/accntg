<!DOCTYPE html>
<html>
<head>
	<title>TimeCard</title>
	<link rel="stylesheet" href="styles.css">

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
			'left left left center center right'
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

<!-- <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"> -->
<div class="grid-container">
	<div class="item1"><h2>Weekly Time Card</h2></div>
	<div class="item2" style="text-align:left">
		<p style="margin-left: 10px"><span class="error">* required field</span></p>
		  <span style="margin-left:10px">Name: <input type="text" name="name" value="<?php echo $name;?>"></span>
		  <span class="error">* <?php echo $nameErr;?></span>
		  <br><br>

		  <span style="margin-left:10px">Emplyee #: <input type="text" name="empid" style="width:60px;" value="<?php echo $empid;?>"></span>
		  <span class="error">* <?php echo $empidErr;?></span>
		  <br><br>
	</div>
	<div class="item3">
		<img src="timeclock.jpg" width="300" height="300" alt="Time Clock">
	</div>
	<div class="item4" style=text-align: left;>
		<h3>Week Number</h3>
		<input type="text" name="week" size="4" value="<?php echo $week;?>">
		<span class="error">* <br><?php echo $weekErr;?></span>
		<br><br>
		<h3>Entry Rows</h3>
		<div>
			<button id="decrement">-</button>
			<input  id="input" type="number" value="0" style="width:50px;" readonly>
			<button id="increment">+</button>
		</div>
	</div>
	<div class="item5" alt="Data entry">
		<table style="width:100%">
			<tr>
				<th>Account</th><th>Description</th><th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th>
			</tr>
			<tr>
				<td>accnt1</td><td>desc1</td><td>s1</td><td>m1</td><td>t1</td><td>w1</td><td>t1</td><td>f1</td><td>s1</td>
			</tr>
			<tr>
				<td>accnt2</td><td>desc2</td><td>s2</td><td>m2</td><td>t2</td><td>w2</td><td>t2</td><td>f2</td><td>s2</td>
			</tr>
			<tr>
				<td>accnt3</td><td>desc3</td><td>s3</td><td>m3</td><td>t3</td><td>w3</td><td>t3</td><td>f3</td><td>s3</td>
			</tr>
			<tr>
				<td>accnt4</td><td>desc4</td><td>s4</td><td>m4</td><td>t4</td><td>w4</td><td>t4</td><td>f4</td><td>s4</td>
			</tr>
		</table>
	</div>
	<div>
		<p><h3>Total Hours</h3></p>
		40
	</div>
	<div class=item7>
		<input type="submit" name="submit" value="Submit">
			<div class="left">&nbsp</div>
			<div class="right">
		 		<a href="./">Back</a>&nbsp
				<a href="http://www">Home</a>&nbsp
		  </div>
	</div>
</div>
<!-- </form> -->

<script>
let counter = 4;

function increment() {
  counter++;
}

function decrement() {
  counter--;
}

function get() {
  return counter;
}

const inc = document.getElementById("increment");
const input = document.getElementById("input");
const dec = document.getElementById("decrement");

inc.addEventListener("click", () => {
  increment();
  input.value = get();
});

dec.addEventListener("click", () => {
  if (input.value > 0) {
    decrement();
  }
  input.value = get();
});
</script>

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

