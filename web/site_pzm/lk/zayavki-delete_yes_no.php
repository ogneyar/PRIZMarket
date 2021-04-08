<article id="repeat_delete">
	<form action='/site_pzm/lk/zayavki.php' method='post'>		
		<input type='hidden' name='id_lota' id='id_lota' value='<?php echo $_POST['id_lota'];?>'>
		<input type='hidden' name='file' id='file' value='<?php echo $_POST['file'];?>'>

		<h4><br>
		<label>Вы уверены что хотите удалить лот <?php echo $_POST['id_lota'];?>?</label><br><br>
		<input type='submit' class='button' name='done' id='done1' value='Да'>
		<input type='submit' class='button' name='done' id='none2' value='Нет'>
		</h4> 
	</form>
	<div id="lk"></div>
</article>

	
<script>

// $(document).ready (function (){
// 	$("#done1").click (function ( event ){
// 		event.stopPropagation(); // остановка всех текущих JS событий
// 		event.preventDefault();  // остановка дефолтного события

// 		let file = document.getElementById("file")
// 		console.log(file)
				
// 		$.ajax ({
// 			url: 'https://media.pzmarket.ru/deleteimage.php',
// 			type: 'POST',
// 			cache: false,
// 			data: {
// 				'file': file.value
// 			},
// 			dataType: 'html',
// 			success: function (data) {
// 				$('#lk').html ("<br><h4>" + data + "</h4>");
// 				$('#lk').show ();
// 				// if (data == "Удалил") location.replace("https://pzmarket.ru");
// 			}
// 		});

		
// 	});
// });	


</script>