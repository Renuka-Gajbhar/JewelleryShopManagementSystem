<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Count Digit </title>
	<script type="text/javascript">
		function CountDigit() 
		{
			let input=parseInt(document.getElementById('inp').value);
			let count=0;

			while(input!=0)
			{
				input=parseInt(input/10);
				count++;
			}

			document.getElementById('res').value=count;
		}
	</script>
</head>
<body>	
	<label>Input Value : </label>
	<input type="text" id="inp">
	<label>Count Digits :</label>
	<input type="text" id="res" readonly>
	<button onclick="CountDigit()">Show Result</button>
</body>
</html>