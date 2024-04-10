<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="input-group">
  <button id="decrement">-</button>
  <input type="number" id="input" value="0" style="width:50px" readonly>
  <button id="increment">+</button>
</div>
<script>
let counter = 0;

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
</body>
</html>

