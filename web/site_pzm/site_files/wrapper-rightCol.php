
<article>
	<a href='https://hutoryanin.ru'>
		<img src="/site_pzm/img/art/Yera.png" />
	</a>
	<center>
	<h3 style="padding:5px;"><span>Заходи на сайт <a href="https://hutoryanin.ru">ХуторянинЪ</a>!</span></h3>
	</center>
	<br>
</article>


<article>
	<a href='#'>
		<img src="/site_pzm/img/art/PRIZM.png" />
	</a>
	<center>
	<h3><span>Здесь может быть Ваша реклама!</span></h3>
	</center>
	<br>
</article>
<!--<article>
	<h3><span>Поддержать проект:</span></h3>
	<h4><p>PRIZM-Q9ST-5ML8-S79J-4DQBE</p>
	<p>672cb195e34bbd206c345ad1f5f617f531816f54be0ec37d5dca2a959a563c4f</p></h4>
</article>-->

<article>
<center>

	<br>
	<h3><span>Поддержать проект:</span></h3><br>

	<article class="tooltip">	
		<!--<h4>-->
		<h5><span>Кошелёк</span></h5>
		<input type="text" value="PRIZM-Q9ST-5ML8-S79J-4DQBE" id="myInput" onclick="myFunction('myInput')" onmouseout="outFunc()" readonly>
		
		<br><br>
		
		<h5><span>Публичный ключ</span></h5>
		<input type="text" value="672cb195e34bbd206c345ad1f5f617f531816f54be0ec37d5dca2a959a563c4f" id="myInput2" onclick="myFunction('myInput2')" onmouseout="outFunc()" readonly>
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
