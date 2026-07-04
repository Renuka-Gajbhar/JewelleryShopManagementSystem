<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<script type="text/javascript" language="javascript">
		function checkValue()
		{
			let value1=parseInt(document.getElementById('n1').value);
			let value2=parseInt(document.getElementById('n2').value);

			let res1=value1*value2;
			let res2=value1/value2;

			document.getElementById('mult').value=res1;
			document.getElementById('div').value=res2;

		}
	</script>
</head>
<body>
		<label>First No.</label>
		<input type="text" id="n1">

		<label>Second No.</label>
		<input type="text" id="n2"><br><br>

		<label>Multiplication :</label>
		<input type="text" id="mult" readonly>

		<label>Division :</label>
		<input type="text" id="div" readonly>

		<button onclick="checkValue()">Display Result</button>
</body>
</html>