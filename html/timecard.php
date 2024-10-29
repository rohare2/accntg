<!DOCTYPE html>
<html>
<head>
	<title>Timecard</title>
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

	<script>
		// function to programmatically set the employee selection in the dropdown
		function setSelection() {
			// Get the value from the input field
			let inputValue = document.getElementById('empNo').value;

			// Get the select element
			let selectElement = document.getElementById('emp');

			// loop through the options in the select element
			for (let i = 0; i < selectElement.options.length; i++) {
				// If an option matches the input value, sleect it
				if (selectElement.options[i].value === inputValue) {
					selectElement.selectedIndex = i;
					break;
				}
			}
		}

		// Function to programatically set the employee number based upon the user selection
		function numSelection() {
			// Get the value from the employee select field
			let selectValue = document.getElementById('emp').value;

			// Get the input element
			let inputElement = document.getElementById('empNo');

			// Set empNo to value of select field
			inputElement.value = selectValue;
		}

		// Add an event listener for when the user finished typing in the input field
		window.onload = function() {
			document.getElementById('empNo').addEventListener('input', setSelection);
			document.getElementById('emp').addEventListener('input', numSelection);
		}

	</script>
</head>
<body>

<?php
session_start();
require_once('DBC.php');

$emp = $empNo = $date = "";
$empErr = "";
$total = 0;

// Validate input values
if ($_SERVER['REQUEST_METHOD'] == "POST") {

	$empNo = test_input($_POST['empNo']);
	if (!preg_match("/^[0-9]*$/",$empNo)) {
		$empNoErr = "Only numbers allowed";
	}

	$emp = test_input($_POST['emp']);
	if (!preg_match("/^[0-9]*$/", $emp)) {
		$empErr = "Only letters, dash and single quote allowed";
	}

	$date = $_POST["date"];
	$rows = $_POST["rowCountInput"];
	$accnt = $_POST["accnt"];
	$desc = $_POST["desc"];
	$sun = $_POST["sun"];
	$mon = $_POST["mon"];
	$tue = $_POST["tue"];
	$wed = $_POST["wed"];
	$thu = $_POST["thu"];
	$fri = $_POST["fri"];
	$sat = $_POST["sat"];
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
<div class="grid-container">
	<div class="item1"><h2>Time Card</h2></div>
	<div class="item2" style="text-align:left">
		<p style="margin-left: 10px"><span class="error">* required field</span></p>
		<h2 style="margin-left:10px">Employee:</h2>
		<span style="margin-left:10px">
		  	<label for="empNo">Enter by #:</label>
		  	<input type="text" name="empNo" id="empNo" required style="width:60px;margin-left:10px">
			<p style="margin-left:30px">or</p>
		</span>

		  <span style="margin-left:10px">
		  	 <label for="emp">Email:</label>
		 	 <select name="emp" id="emp" required>
			 <?php
				require_once 'accntg_functions.php';

        		$connection = db_connect();

        		if ($connection) {
            		$sql = "SELECT empNo, email FROM employee";
            		$result = $connection->query($sql);

            		if ($result->num_rows > 0) {
                		while ($row = $result->fetch_assoc()) {
                    		echo "<option value='" . $row['empNo'] . "'>" . $row['email'] . "</option>";
                		}
            		} else {
                		echo "<option value=''>No employees available</option>";
            		}

            		db_close($connectin);
        		} else {
            		alert("Connection failed");
        		}
			 ?>
			 </select>
	      </span>
		  <span class="error">* <?php echo $empErr;?></span>
		  <br><br>

	</div>
	<div class="item3">
		<img src="timeclock.jpg" width="300" height="300" alt="Time Clock">
	</div>
	<div class="item4" style="text-align:center">
		<h3>Pay Period</h3>
		<input type="date" name="date" id="date" required>
		<br><br>
		<h3>Ajust row count</h3>
		<div>
			<button type="button" id="decrement">-</button>
			<input type="text" id="rowCountInput" name="rowCountInput" value="4" min="1" max="10" style="width:50px">
			<button type="button" id="increment">+</button>
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
			<tbody>
				<!-- Table rows will be dynamically added here -->
			</tbody>
		</table>
	</div>
	<div class="item6">
		<p><h3>Total Hours</h3></p>
		<input type="text" name="total" id="total" style="width:20px">
	</div>
	<div class=item7>
		<button type="submit">Submit</button>
		<div class="left">&nbsp</div>
		<div class="right">
			<a href="./">Back</a>&nbsp
			<a href="http://www">Home</a>&nbsp
		</div>
	</div>
</div>
</form>

<script>
function addRow() {
	var dtable = document.getElementById("dataTable");
	var row = dtable.insertRow();

    for (i = 0; i < 9; i++) {
        var icell = row.insertCell(i);
        switch (i) {
            case 0:
                icell.innerHTML = "<input type='text' name='accnt[]' style='width:100px'>";
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
const input = document.getElementById("rowCountInput");
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

</script>

<?php
echo "<h2>Your input</h2>";
echo "EmpNo: " . $empNo . "<br>";
echo "Employee: " . $emp . "<br>";
echo "Date: " . $date . "<br>";
echo "rows: " . $rows . "<br>";
echo "Accnt array: <br>";
echo '<pre>'; print_r($accnt); echo '</pre>';
echo "Desc array: <br>";
echo '<pre>'; print_r($desc); echo '</pre>';
echo "Sun array: <br>";
echo '<pre>'; print_r($sun); echo '</pre>';
echo "Mon array: <br>";
echo '<pre>'; print_r($mon); echo '</pre>';
echo "Tue array: <br>";
echo '<pre>'; print_r($tue); echo '</pre>';
echo "Wed array: <br>";
echo '<pre>'; print_r($wed); echo '</pre>';
echo "Thu array: <br>";
echo '<pre>'; print_r($thu); echo '</pre>';
echo "Fri array: <br>";
echo '<pre>'; print_r($fri); echo '</pre>';
echo "Sat array: <br>";
echo '<pre>'; print_r($sat); echo '</pre>';
echo "Total Hours: " . $total . "<br>";
?>

</body>
</html>

