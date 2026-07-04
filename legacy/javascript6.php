<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Factorial </title>
	<script type="text/javascript">
		function display() 
		{
			let input=parseInt(document.getElementById('inp').value);
			let res=1;
			for(var i=input;i>=1;i--)
			{
				res=res*i;
			}

			document.getElementById('res').value=res;
		}
	</script>
</head>
<body>
	<label>Input Value : </label>
	<input type="text" id="inp">
	<label>Factorial :</label>
	<input type="text" id="res" readonly>
	<button onclick="display()">Show Result</button>
</body>
</html>\