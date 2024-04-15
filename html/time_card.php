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
$rows = 4;

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

	if (!empty($_POST['rows'])) {
    	$rows = test_input($_POST['rows']);
	}
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!-- Hidden form -->
<form id="hiddenForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" style="display:none">
	<input type="hidden" id="hiddenName" name="name"> 
	<input type="hidden" id="hiddenEmpid" name="empid"> 
	<input type="hidden" id="hiddenWeek" name="week"> 
	<input type="hidden" id="hiddenRows" name="rows"> 
</form>

<!-- visible input -->
<div class="grid-container">
	<div class="item1"><h2>Weekly Time Card</h2></div>
	<div class="item2" style="text-align:left">
		<p style="margin-left: 10px"><span class="error">* required field</span></p>
		  <span style="margin-left:10px">Name: <input type="text" id="name" value="<?php echo $name;?>"></span>
		  <span class="error">* <?php echo $nameErr;?></span>
		  <br><br>

		  <span style="margin-left:10px">Emplyee #: <input type="text" id="empid" style="width:60px;" value="<?php echo $empid;?>"></span>
		  <span class="error">* <?php echo $empidErr;?></span>
		  <br><br>
	</div>
	<div class="item3">
		<img src="timeclock.jpg" width="300" height="300" alt="Time Clock">
	</div>
	<div class="item4" style="text-align:center">
		<h3>Week Number</h3>
		<input type="text" id="week" size="2" value="<?php echo $week;?>">
		<span class="error">* <br><?php echo $weekErr;?></span>
		<br><br>
		<h3>Entry Rows</h3>
		<div>
			<button id="decrement">-</button>
			<input  id="rows" type="number" value="<?php echo $rows; ?>" style="width:50px;" readonly>
			<button id="increment">+</button>
		</div>
	</div>
	<div class="item5" alt="Data entry">
		<table id="dataTable" style="width:100%">
			<thead>
			<tr>
				<th style="width:100px">Account</th>
				<th style="width:60%">Description</th>
				<th>S</th>
				<th>M</th>
				<th>T</th>
				<th>W</th>
				<th>T</th>
				<th>F</th>
				<th>S</th>
			</tr>
			</thead>
		</table>
	</div>
	<div>
		<p><h3>Total Hours</h3></p>
		40
	</div>
	<div class=item7>
		<!-- <button type="button" onlick="submitHiddenForm()">Submit</button> -->
		<button onclick="submitHiddenForm()">Submit</button>
		<div class="left">&nbsp</div>
		<div class="right">
			<a href="./">Back</a>&nbsp
			<a href="http://www">Home</a>&nbsp
		</div>
	</div>
</div>

<script>

function addRow() {
	var dtable = document.getElementById("dataTable");
	var row = dtable.insertRow();

	for (i = 0; i < 9; i++) {
		var icell = row.insertCell(i);
		switch (i) {
			case 0:
				icell.innerHTML = '<input type="text" name="account[]" style="width:100px">';
				break;
		
			case 1:
				icell.innerHTML = "<input type:'text' name='desc[]' style='width:98%'>";
				break;
		
			case 2:
				icell.innerHTML = "<input type='text' name='sun[]' style='width:25px'>";
				icell.style.textAlign = "center";
				break;

			case 3:
				icell.innerHTML = "<input type='text' name='mon[]' style='width:25px'>";
				icell.style.textAlign = "center";
				break;

			case 4:
				icell.innerHTML = "<input type='text' name='tue[]' style='width:25px'>";
				icell.style.textAlign = "center";
				break;

			case 5:
				icell.innerHTML = "<input type='text' name='wed[]' style='width:25px'>";
				icell.style.textAlign = "center";
				break;

			case 6:
				icell.innerHTML = "<input type='text' name='thu[]' style='width:25px'>";
				icell.style.textAlign = "center";
				break;

			case 7:
				icell.innerHTML = "<input type='text' name='fri[]' style='width:25px'>";
				icell.style.textAlign = "center";
				break;

			case 8:
				icell.innerHTML = "<input type='text' name='sat[]' style='width:25px'>";
				icell.style.textAlign = "center";
				break;

			default:
				console.log("Invalid value:" + i);
		}
	}
}

function deleteRow() {
	document.getElementById("dataTable").deleteRow(-1);
}

<!-- Row count selector -->
let counter = 4;

function increment() {
  counter++;
  addRow();
}

function decrement() {
  counter--;
  deleteRow();
}

function get() {
  return counter;
}

const inc = document.getElementById("increment");
const input = document.getElementById("rows");
const dec = document.getElementById("decrement");

inc.addEventListener("click", () => {
  increment();
  input.value = get();
});

dec.addEventListener("click", () => {
  if (input.value > 1) {
    decrement();
  }
  input.value = get();
});

for (k = 0; k < counter; k++) {
	addRow();
}

<!-- Submit form data -->
function submitHiddenForm() {
	// Get values from visible fields
	var visibleName = document.getElementById("name").value;
	var visibleEmpid = document.getElementById("empid").value;
	var visibleWeek = document.getElementById("week").value;
	var visibleRows = document.getElementById("rows").value;
	<!-- add more hidden input fields -->

	// Set values to hidden fields
	document.getElementById("hiddenName").value = visibleName;
	document.getElementById("hiddenEmpid").value = visibleEmpid;
	document.getElementById("hiddenWeek").value = visibleWeek;
	document.getElementById("hiddenRows").value = visibleRows;

	document.getElementById("hiddenForm").submit();
}

</script>

<?php
if ($name && $empid && $week) {
	echo "<h2>Your Input:</h2>";
	echo "Name: " . $name . "<br>";
	echo "Employee ID: " . $empid . "<br>";
	echo "Week: " . $week . "<br>";
	echo "Rows: " . $rows . "<br>";
} else {
	echo "<h2>Invalid submittion</h2>";
}
?>

</body>
</html>

