<!DOCTYPE html>
<html>
	<head>	
	
	<?php 		
		$detect = new Mobile_Detect;
 
		// Any mobile device (phones or tablets).
		if ($detect->isMobile()) { 
	?>
			<link rel="stylesheet" type="text/css" href="/site/style_mobile.css">
	<?php		
		}else{		
	?>	
			<link rel="stylesheet" type="text/css" href="/site/style_pc.css">
	<?php
		}
	?>
	
		<meta charset="utf-8">		
		<title>Форма заказа</title>				
	</head>
	<body>