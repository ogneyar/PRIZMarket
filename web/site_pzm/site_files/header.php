<?php
$tester = getenv('TESTER');
if ($tester == 'да') {
?>
<a href="/" id="logo">
	<b><span>TESTMarket</span></b>
</a>
<?php
}else {
?>
<a href="/" id="logo">
	<b><span>PRIZMarket</span></b>
</a>
<?php
} 
?>
