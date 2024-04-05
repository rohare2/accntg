<!DOCTYPE html>
<html>
<body>

<?php
// define variables and set to empty values
$name = $email = $comment = $gender = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_REQUEST['name']);
    $email = test_input($_REQUEST['email']);
    $website = test_input($_REQUEST['website']);
    $comment = test_input($_REQUEST['comment']);
    $gender = test_input($_REQUEST['gender']);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<h2>PHP Form Validation Example</h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
  Name: <input type="text" name="name"><br>
  E-mail: <input type="text" name="email"><br>
  Website: <input type="text" name="website"><br>
  Comment: <textarea name="comment" rows="5" cols="48"></textarea><br>
  Gender:
  <input type="radio" name="gender" value="female">Female
  <input type="radio" name="gender" value="male">Male
  <input type="radio" name="gender" value="other">Other
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>

<?php
if ($name) {
	echo "<h2>Your Input:</h2>";
	echo "Name: " . $name . "<br>";
	echo "E-mail: " . $email . "<br>";
	echo "Website: " . $website . "<br>";
	echo "Comment: " . $comment . "<br>";
	echo "Gender: " . $gender . "<br>";
}
?>

</body>
</html>

