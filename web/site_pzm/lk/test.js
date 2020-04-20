$(document).ready (function (){
	$("#done").click (function ( event ){
		event.stopPropagation(); // остановка всех текущих JS событий
		event.preventDefault();  // остановка дефолтного события
				
		$('#warning').html (' ' + "<br>");
		$('#warning').show ();
						
		var login = $("#login").val ();	
		var name = $("#name").val ();
		var fail = "";		
				
		if (name.length < 3) fail = "Чёнить не менее 3х символов";
					
		if (fail != "") {
			$('#warning').html (fail  + "<br>");
			$('#warning').show ();										
			return false;
		}else {					
			$('#lk').html ("<br><h4>Ожидайте..</h4>");
			$('#lk').show ();		
		}		
		
		var Data = new FormData();
		
		Data.append('login', login);
		Data.append('name', name);
		
		$.ajax ({
			url: 'https://f0430377.xsph.ru',
			type: 'POST',
			cache: false,
			data: Data,
			//dataType: 'json',
			contentType: false,
			processData: false,
			success: function (data) {
				$('#lk').html ("<br><h4>" + data + "</h4>");
				$('#lk').show ();						
			},
			error: function(){
				$('#lk').html ("<br><h4>Ошибка отправки запроса..</h4>");
				$('#lk').show ();
			}			
		});	
	
	});
});	