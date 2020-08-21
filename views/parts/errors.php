<h6>Errors</h6>
<ul class="form-errors">
	<?php foreach($errors as $field => $row) : ?>
		<?php foreach($row as $text) : ?>
	<li data-name="<?=$field?>"><?=$text?></li>
		<?php endforeach; ?>
	<?php endforeach; ?>
</ul>