<?php $this->blockStart("body"); ?>

<section>
	<form id="dbconsole__form">
		<textarea id="dbconsole__query"></textarea>
		<input type="submit" valu="submit">
	</form>
</section><section id="dbconsole__result"></section>

<?php 
$this->blockEnd("body"); 
$this->extend("layout");