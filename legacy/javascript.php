<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<script type="text/javascript">
		function display() 
		{
			for(var i=1;i<=10;i++)
			{
				document.getElementById('res').value=i;
			}
		}
	</script>
</head>
<body>
	<textarea id="res"></textarea>
	<button onclick="display()">Show Result</button>
</body>
</html>