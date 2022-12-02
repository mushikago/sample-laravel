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
			$id = $(e.currentTarget).data("id");
			window.location = '/admin/stations/editObject/' + $id;
		})

	$('.addStation').css('cursor', 'pointer')
		.click(function (e){
			$id = $(e.currentTarget).data("id");
			window.location = '/admin/stations/editObject/0/' + <?= $id ?>;
		})

})

<?php $this->Html->scriptEnd(); ?>

<?php echo $this->Html->scriptStart( array("block"=>'scriptBottom',"inline"=>false)); ?>
<!--<script>-->

<?php echo $this->Html->scriptEnd(); ?>



<main role="main">

<!--	<a href="/admin/stations/editObject/0/--><?//= $id ?><!--" class="float-right btn btn-primary text-light">--><?//= __('新規作成') ?><!--</a>-->

	<a href="/admin/events/editObject/<?= $id ?>/<?= $backid.$queryStr ?>" class="btn btn-secondary"><< EDIT EVENT</a>



	<?php
	echo $this->element('pageCtrl', array(
			'info' => false,
			'right' => true
	));
	?>

	<div class="pb-5">
		<div class="grid">
			<?php foreach ($myObjects as $station): ?>
			<div class="grid-item grid-item--width3 grid-item--height3 stationIcon" data-id="<?= $station['Station']['id'] ?>">
				<figure class="figure">
					<img src="/img/stations/<?= ($station['Station']['image'] == '') ? 'image.png' : $station['Station']['image'] ?>" class="img-fluid">
				</figure>
			</div>
			<?php endforeach; ?>
			<div class="grid-item grid-item--width3 grid-item--height3 addStation"><i class="fas fa-plus"></i></div>
		</div>
	</div>

	<?php
	echo $this->element('pageCtrl', array(
			'info' => true,
			'right' => false
	));
	?>

</main>


