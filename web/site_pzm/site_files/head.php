	<meta name="description" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="all,index,follow" />
	<meta name="distribution" content="global" />
	
	<!-- Adopt website to current screen -->
	<meta name="viewport" content="user-scalable=yes, width=device-width, initial-scale=1.0, maximum-scale=1.0">
	
	<link rel="stylesheet" href="/site_pzm/css/style2.css">
	
	<link rel="stylesheet" href="/site_pzm/font-awesome/css/font-awesome.min.css">
	
	<link rel="shortcut icon" href="/site_pzm/img/favicon.png" type="image/png">
	
	<!--<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#00aba9">
	<meta name="theme-color" content="#ffffff">-->
	
	<!-- Here we add libs for jQuery, Ajax... -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> 
	<!-- <script type="text/javascript" src="/site_pzm/site_files/jquery-3.3.1.min.js"></script> -->
	
	<script type="text/javascript">
		if(screen.width > 800) { // Animate navigation
			$(document).ready(function() {
			// функцию скролла привязать к окну браузера
				$(window).scroll(function(){
					var distanceTop = $('#slideMenu').offset().top;
					if ($(window).scrollTop() >= distanceTop)
						$ ('nav').attr ("id", "fixed");
					else //if ($(window).scrollTop() < distanceTop)
						$ ('nav').attr ("id", "nav");
				});
			});
		}
	</script>	
