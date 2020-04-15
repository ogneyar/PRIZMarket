<?

?>
<article id="lk">
<h4>
<!--
<form action="/site_pzm/lk/sozdanie.php" method="post" enctype="multipart/form-data">
-->
	<input type="hidden" name="photo" value="1">
	<br><br>	
	
	<label>Загрузите главное фото:</label>
	<br><br>
	<input type="file" name="file" id="file" accept=".jpg, .jpeg, .png">	
	<br><br><br>
	
	<label>Загрузите доп. фото:</label>
	<br><br>
	<input type="file" id="files_opt" name="files_opt" multiple accept=".jpg, .jpeg, .png">
	<br><br><br>
	
	<label id="warning"><br></label>
	<input type="submit" class="button" name="done_files" id="done_files" value="Применить">
<!--
</form>
-->
</h4>
</article>

<script>
$(document).ready (function (){	
	var file;		
	$("#file").change(function(){
		file = this.files;			
	});		
	$("#done_files").click (function (event){
		event.stopPropagation(); // остановка всех текущих JS событий
		event.preventDefault();  // остановка дефолтного события		
		$('#warning').html (' ' + "<br>");
		$('#warning').show ();		
		var fail = "";
		if (typeof file == 'undefined') fail = "Не выбран файл";		
		if (fail != "") {
			$('#warning').html (fail  + "<br>");
			$('#warning').show ();										
			return false;
		}
		
		$('#lk').html ("<br><h4>Идёт загрузка..</h4>");
		$('#lk').show ();
		
		let Data = new FormData();
		
		Data.append('file', "1");
   
		$.ajax ({
			url: '/site_pzm/lk/save_photo2.php',
			type: 'POST',
			cache: false,
			data: {'file': "file"},			
			dataType: 'html',
			contentType: false,
			//processData: false,
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
</script>