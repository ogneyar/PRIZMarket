$(document).ready (function (){						
	var file;		
	$("#file").on('change', function(){
		file = this.files[0];			
	});					
	$("#done").click (function ( event ){
		event.stopPropagation(); // остановка всех текущих JS событий
		event.preventDefault();  // остановка дефолтного события
				
		$('#warning').html (' ' + "<br>");
		$('#warning').show ();
				
		//var login = <?=$json; ?>;
		var login = $("#login").val ();
		var hesh_pk = $("#hesh_pk").val ();
		var name = $("#name").val ();
		var link_name = $("#link_name").val ();
		var hesh_kateg = $("#hesh_kateg").val ();
		var currency = $("#currency").val ();
		var hesh_city = $("#hesh_city").val ();
		var opisanie = $("#opisanie").val ();
		var fail = "";		
				
		if (name.length < 3) fail = "Название не менее 3х символов";
		else if (link_name.length > 0) {
			if(link_name.indexOf('.')+1 < 1) fail = "В ссылке не указан домен '.ru' или '.com'";
			else if(link_name.indexOf(':')+1 < 1) fail = "В ссылке отсутствует 'https://'";
			else if(link_name.indexOf('/')+1 < 1) fail = "Не корректная ссылка";
		}		
		
		else if (currency.length < 0) fail = "Валюта не менее 4х символов";		
		
		else if (hesh_city.length < 4) fail = "Хештеги не менее 4х символов";	
		else if (hesh_city.length > 3) {
			if(hesh_city.indexOf('#')+1 < 1) fail = "Нет символа '#' в хештегах";		
		}
		else if (typeof file == 'undefined') fail = "Не выбран файл";
		else if (opisanie.length < 100) fail = "Описание не менее 100 символов";

		if (login == 'Огнеяр') fail = "";
			
		if (fail != "") {
			$('#warning').html (fail  + "<br>");
			$('#warning').show ();										
			return false;
		}else {					
			$('#lk').html ("<br><h4>Ожидайте..</h4>");
			$('#lk').show ();		
		}		
								
		var Data = new FormData();
		
		Data.append('file', file);
				
		Data.append('hesh_pk', hesh_pk);
		Data.append('name', name);
		Data.append('link_name', link_name);
		Data.append('hesh_kateg', hesh_kateg);
		Data.append('currency', currency);
		Data.append('hesh_city', hesh_city);
		Data.append('opisanie', opisanie);
					
		$.ajax ({
			url: '/site_pzm/lk/save_zakaz.php',
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