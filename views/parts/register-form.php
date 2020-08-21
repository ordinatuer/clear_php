<h1>Регистрация</h1>
<form action="/head/register" method="POST" class="form-register">
	<div class="form-block">
		<div class="form-row">
			<label>Login</label>
			<input type="text" name="login" placeholder="Login" value="<?=$form->val('login')?>" required />
		</div>
		<div class="form-row">
			<label>Name</label>
			<input type="text" name="name" placeholder="Name" value="<?=$form->val('name')?>" />
		</div>
		<div class="form-row">
			<label>Email</label>
			<input type="email" name="email" placeholder="Email" value="<?=$form->val('email')?>" required />
		</div>
		<div class="form-row">
			<label>Password</label>
			<input type="password" name="password" placeholder="password" required />
		</div>
		<div class="form-row">
			<label>Retype password</label>
			<input type="password" name="retype" placeholder="password again" required />
		</div>
		<div class="form-row">
			<label>&nbsp;</label>
			<input type="submit" name="register" />
		</div>
		<div class="clearfix"></div>
		<span class="form-error">Error message</span>
	</div>
</form>