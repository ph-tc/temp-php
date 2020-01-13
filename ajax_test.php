<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phone Detector</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>

<script>

	$.ajax({
	   type: 'POST',
	   url:'http://iphlr.ru/v2/izuchaidance?redirect_url=http://prostitemobil.ru',
	   data: false,
	   success: function(data, textStatus, request){
	        alert(request.getResponseHeader('some_header'));
	   },
	   error: function (request, textStatus, errorThrown) {
	        alert(request.getResponseHeader('some_header'));
	   }
	  });
</script>