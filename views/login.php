<?php
use app\src\auth\User;
?>
<h1>Авторизация</h1>
<form action="/user/login" method="POST" class="form-register">
	<div class="form-block">
		<div class="form-row">
			<label>Email</label>
			<input type="email" name="email">
		</div>
		<div class="form-row">
			<label>Password</label>
			<input type="password" name="password" />
		</div>
		<div class="form-row">
			<label>&nbsp;</label>
			<input type="submit" name="login" />
		</div>
		<div class="clearfix"></div>
		<span class="form-error">Error message</span>
	</div>	
</form>	
<div class="clearfix"></div>
<?=$message ?>