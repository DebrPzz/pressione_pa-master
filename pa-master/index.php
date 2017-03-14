<?php 
	//REF: http://www.redbeanphp.com/index.php
	require_once('lib/rb.php');
	R::setup( 'mysql:host=127.0.0.1;dbname=pa-master','pa', 'pressione' );
	
	$pg=(empty($_REQUEST['p'])) ? 'home' : $_REQUEST['p'];
	$pg='pgs/'.$pg.'.php';

?>
<!doctype html>
<html lang="it">
	<head>
		<meta charset="utf8" />
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		
		<link rel="stylesheet" href="css/jquery_datatable.css">
		<link rel="stylesheet" href="css/my_style.css">
		
		
		
		<title>Pressione Arteriosa</title>
	</head>
	<body>
		<?php if (file_exists($pg)) include_once($pg); ?>
		<script  src="js/jquery.min.js"></script>
		<script src="js/jquery_datatable.js"></script>
		<script src="js/my_jquery.js"></script>
		
	</body>
</html>