<?

?>
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
	
	<input type="submit" class="button" name="done_files" id="done_files" value="Применить">
<!--
</form>
-->

	<script>
	$(document).ready (function (){	
		$("#done_files").click (function (){
			$('#lk').html ("<br><h4>Идёт загрузка..</h4>");
			$('#lk').show ();
		});
	});
	</script>