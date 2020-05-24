<article>
	<a href='' title=''>
		<img src="/site_pzm/img/art/PRIZM.png" />
	</a>
	<h3><span>Здесь может быть Ваша реклама!</span></h3>
</article>
<!--<article>
	<h3><span>Поддержать проект:</span></h3>
	<h4><p>PRIZM-UFSC-9S49-ESJX-79N7S</p>
	<p>11dcf528f8f2ff9dc3c5005cd6fdc3240ea09ceaf96f2dd261255696ccb2842c</p></h4>
</article>-->

<article>
<center>

	<h3><span>Поддержать проект:</span></h3><br>

	<article class="tooltip">	
		<!--<h4>-->
		<h6>Кошелёк</h6>
		<input type="text" value="PRIZM-UFSC-9S49-ESJX-79N7S" id="myInput" onclick="myFunction('myInput')" onmouseout="outFunc()" readonly>
		
		<br><br>
		
		<h6>Публичный ключ</h6>
		<input type="text" value="11dcf528f8f2ff9dc3c5005cd6fdc3240ea09ceaf96f2dd261255696ccb2842c" id="myInput2" onclick="myFunction('myInput2')" onmouseout="outFunc()" readonly>
		<!--</h4>-->
		
		<br><br>
		
		<span class="tooltiptext" id="myTooltip">Нажмите чтобы копировать текст в буфер</span>
	</article>
	
</center>
</article>

<!--<div class="tooltip">
  <input type="text" value="Здравствуй мир!" id="myInput" onclick="myFunction()" onmouseout="outFunc()"> 
  <span class="tooltiptext" id="myTooltip">Нажмите чтобы копировать текст в буфер</span>
</div>-->

<script>
function myFunction(myIn) {
  var copyText = document.getElementById(myIn);
  copyText.select();
  document.execCommand("copy");
  
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Скопировал: " + copyText.value;
}

function outFunc() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Нажмите чтобы копировать текст в буфер";
}
</script>


<!--<p>11dc<wbr>f528<wbr>f8f2<wbr>ff9d<wbr>c3c5<wbr>005c<wbr>d6fd<wbr>c324<wbr>0ea0<wbr>9cea<wbr>f96f<wbr>2dd2<wbr>6125<wbr>5696<wbr>ccb2<wbr>842c</p>-->

<!--<div class="banner">
	<input type="text" placeholder="Поиск" id="search"/>
</div>
<div class="banner">
	<span>Стоит посмотреть:</span>
	<iframe src="https://youtu.be/7-wxMhp99N8" frameborder="0" allowfullscreen></iframe>
</div>
<div class="banner">
	<span>Поддержать проект:</span>
	<img src="/site_pzm/img/WM_sps.png" id="wm" alt="Сказать спасибо" title="Сказать спасибо"/>
</div>-->