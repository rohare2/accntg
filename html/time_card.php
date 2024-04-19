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
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
<div class="grid-container">
	<div class="item1"><h2>Weekly Time Card</h2></div>
	<div class="item2" style="text-align:left">
		  <span style="margin-left:10px">Name: <input type="text" name="name" required></span>
		  <br><br>

		  <span style="margin-left:10px">Emplyee #: <input type="text" name="empid" style="width:60px;" required></span>
		  <br><br>
	</div>
	<div class="item3">
		<img src="timeclock.jpg" width="300" height="300" alt="Time Clock">
	</div>
	<div class="item4" style="text-align:center">
		<h3>Week Number</h3>
		<input type="text" name="week" size="2" required>
		<br><br>
		<h3>Ajust row count</h3>
		<div>
			<button type="button" id="decrement">-</button>
			<input type="text" id="rowCountInput" name="rowCountInput" value="6" min="1" style="width:50px">
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
		40
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
let counter = 6;

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
$name = $empid = $week = "";
$rows = 6;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$name = $_POST["name"];
	$empid = $_POST["empid"];
	$week = $_POST["week"];
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

echo "<h2>Your input</h2>";
echo "Name: " . $name . "<br>";
echo "EmpId: " . $empid . "<br>";
echo "Week: " . $week . "<br>";
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
?>

</body>
</html>

