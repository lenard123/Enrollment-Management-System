<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<div id="data"></div>

<script>
try{
	var source = new EventSource("test1.php");
	source.onmessage = function(event) {
	    document.getElementById("data").innerHTML += event.data + "<br>";
	};
}catch(e){
	console.log(e);
} 
</script>

</body>
</html>