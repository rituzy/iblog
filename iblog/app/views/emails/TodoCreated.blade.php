<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h3>{{ $mes }}!</h3>
		<div>
		  {{ $mes }} в списке задач на izutov.com <br> Иди на сайт и смотри скорее :)
      <h4>Детали</h4>
        Содержимое: {{ $content }}<br>
        Срок: {{ $deadline }}<br>
        Приоритет: {{ $priority }}<br>
		</div>
	</body>
</html>
