<?php
$this->assign('icon', $icon);
$this->assign('title', $title);
$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

?>

<?php $this->Html->scriptStart( array("block"=>'script',"inline"=>false)); ?>
<!--<script>-->
$(function (){

	$('.grid').packery({
		itemSelector: '.grid-item',
		gutter: 10
	});

	$('.stationIcon').css('cursor', 'pointer')
		.click(function (e){
			$stid = $(e.currentTarget).data("stid");
			window.location = '/admin/stations/editStation/' + $stid;
		})

	$('.addStation').css('cursor', 'pointer')
		.click(function (e){
			window.location = '/admin/stations/editStation/';
		})

})

<?php $this->Html->scriptEnd(); ?>

<?php echo $this->Html->scriptStart( array("block"=>'scriptBottom',"inline"=>false)); ?>
<!--<script>-->

<?php echo $this->Html->scriptEnd(); ?>

<a href="/admin/applications/viewApplication/<?= $appid ?>" class="btn btn-secondary"><< VIEW APP</a>

<main role="main">

	<div class="py-5">
		<div class="grid">
			<?php foreach ($myStations as $station): ?>
				<div class="grid-item grid-item--width3 grid-item--height3 stationIcon" data-stid="<?= $station['Station']['id'] ?>">
					<figure class="figure">
						<img src="/img/applications/<?= $station['Station']['image'] ?>" class="img-fluid">
					</figure>
					<!--				<img src="/img/applications/--><?//= $application['Application']['image'] ?><!--" width="210" height="210">-->
				</div>
			<?php endforeach; ?>
			<div class="grid-item grid-item--width3 grid-item--height3 addStation"><i class="fas fa-plus"></i></div>
		</div>
	</div>

</main>


