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

				if(value1>value2)
				{
					document.getElementById('res').value=value1;
				}
				else if(value1<value2)
				{
					document.getElementById('res').value=value2;
				}
				else
				{
					document.getElementById('res').value="Both are Equal";
				}
		}
	</script>
</head>
<body>
		<label>First No.</label>
		<input type="text" id="n1"><br><br>

		<label>Second No.</label>
		<input type="text" id="n2"><br><br>

		<label>Result :</label>
		<input type="text" id="res" readonly>

		<button onclick="checkValue()">Check Large</button>
</body>
</html>