<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<script type="text/javascript" language="javascript">
		function getResult() 
		{
			let start=parseInt(document.getElementById('from').value);
			let end=parseInt(document.getElementById('to').value);
			let result=0;
			for(var i=start;i<=end;i++)
			{
				result=result+i;
			}

			document.getElementById('res').value=result;
		}
	</script>
</head>
<body>
	<label>Start :</label>
	<input type="text" id="from" value="0" disabled>
	<label>End :</label>
	<input type="text" id="to">
	<label>Result :</label>
	<input type="text" id="res" readonly>
	<button onclick="getResult()">Get Result</button>
</body>
</html>