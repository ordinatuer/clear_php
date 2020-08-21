<?php
use app\src\Main;
use app\src\auth\User;

$home = Main::app()->config('home');
?>
<!DOCTYPE html>
<html>
<head>
	<title>TITLE</title>
	<link rel="stylesheet" href="<?=$home?>css/styles.css" />
</head>
<body>
	<nav>
		<ul class="main-nav">
			<li><a href="/">Home</a></li>
			<li><a href="/head/index">Head</a></li>
			<li><a href="/head/page">Page</a></li>
<?php if ($this->uid) : ?>
			<li><a href="/user/logout">Logout</a></li>
<?php else : ?>
			<li><a href="/user/register">Register</a></li>
			<li><a href="/user/login">Login</a></li>
<?php endif; ?>
			<li><a href="/header/pages">404</a></li>
			<li><b><?=(int)$this->uid?></b></li>
		</ul>
	</nav>
	<div class="clearfix"></div>
	<hr />

	<main>
		<?=$content?>
		<?php
			//echo $this->renderPart('parts/part');
		?>
	</main>

	<hr />
	<footer>
		<p>foot blocks</p>	
	</footer>
</body>
</html>