<!DOCTYPE html>
<?php
$thispage = $_SERVER["REQUEST_URI"];

function checkVisible($user){
	return "d-none";
}
?>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TABI-LOG SYSTEM CONSOLE</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Resource-type" content="Document" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

	<!--	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">-->
	<?php echo $this->Html->css('bootstrap.min'); ?>

	<!--	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<!--	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>-->
<!--	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>-->

	<?php
	echo $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js',
			array(
					'integrity' => 'sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=',
					'crossorigin' => 'anonymous',
			));

	echo $this->Html->script('https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js',
			array(
					'integrity' => 'sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo',
					'crossorigin' => 'anonymous'
			));

	echo $this->Html->script('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js',
			array(
					'integrity' => 'sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI',
					'crossorigin' => 'anonymous'
			));

	//jQueryUI
	echo $this->Html->script( 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js',
			array(
					'integrity' => 'sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=',
					'crossorigin' => 'anonymous'
			));
	echo $this->Html->css('https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css');


	?>


	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<script src="https://kit.fontawesome.com/9b41e56b11.js"></script>

	<script src="/js/packery.pkgd.js"></script>
	<script src="/js/draggabilly.pkgd.js"></script>



	<?php echo $this->Html->css('mskg'); ?>
	<?php echo $this->Html->css('admin'); ?>

	<!-- AdobeFont-->
	<script>
	  (function(d) {
		var config = {
		  kitId: 'sci1akd',
		  scriptTimeout: 3000,
		  async: true
		},
		h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
	  })(document);
	</script>

	<?php echo $this->fetch('css'); ?>
	<?php echo $this->fetch('script'); ?>
</head>
<body>
<header class="navbar navbar-expand-lg navbar-dark adminNav">
	<a class="navbar-brand adminTitle" href="/admin">TABI-LOG SYSTEM CONSOLE<br>Release version : <?= RELEASE_VERSION ?></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarText">
		<ul class="navbar-nav mr-auto">
			<!--			<li class="nav-item --><?php //echo ($thispage == '/orders/history') ? 'active' : ''; ?><!--">-->
			<!--				<a class="nav-link" href="/"><i class="far fa-list-alt middleIcon"></i> 履歴<span class="sr-only">(current)</span></a>-->
			<!--			</li>-->
			<li class="nav-item <?php echo ($thispage == '/admin/users/editUser') ? 'active' : ''; ?>">
				<a class="nav-link" href="/admin/users/editUser"><i class="fas fa-user-edit"></i> User Edit</a>
			</li>
			<li class="nav-item <?php echo checkVisible(""); ?> <?php echo ($thispage == '/users/search') ? 'active' : ''; ?>">
				<a class="nav-link" href="/users/search"><i class="fas fa-search largeIcon"></i> ユーザー検索</a>
			</li>
			<li class="nav-item <?php echo ($thispage == '/orders/start') ? 'active' : ''; ?>">
				<a class="nav-link" href="/admin/users/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
			</li>
			<!--			<li class="nav-item --><?php //echo ($thispage == '/orders/review') ? 'active' : ''; ?><!--">-->
			<!--				<a class="nav-link" href="/orders/review"><i class="fas fa-user-check middleIcon"></i> レビュー</a>-->
			<!--			</li>-->
		</ul>
		<span class="navbar-text"><a class="nav-link" href="/"><i class="fas fa-home"></i></a></span>
	</div>
</header>
<?php echo $this->Flash->render(); ?>
<div class="container pt-5">
	<h2 class="pb-4"><i class="<?= $this->fetch('icon'); ?>"></i> <?= $this->fetch('title'); ?></h2>

	<?php echo $this->fetch('content'); ?>
</div>

<footer class="text-muted">
	<!--	<div class="container p-5">-->
	<div class="p-5">
		<p class="float-right">
			<a href="/"><i class="fas fa-home"></i> HOME</a><?php if ($auth) {?> | <a href="/admin"><i class="fas fa-cog"></i> Admin TOP</a><?php } ?>
		</p>
	</div>
</footer>
<?php
echo $this->fetch('scriptBottom');
?>
</body>
</html>
