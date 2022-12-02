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



<main role="main">

	<a href="/admin/events/editObject/0/<?= $id ?>/<?= $backid.$queryStr ?>" class="float-right btn btn-primary text-light"><?= __('新規作成') ?></a>

	<a href="/admin/applications/viewObject/<?= $id ?>/<?= $backid.$queryStr ?>" class="btn btn-secondary"><< VIEW APP</a>



	<?php
	echo $this->element('pageCtrl', array(
			'info' => false,
			'right' => true
	));
	?>

	<div class="content p-3">

		<?php foreach ($myObjects as $event): ?>

			<?= $this->element('lists/listEvent', array(
					'event'=>$event,
					'appid'=>$id
			)); ?>

		<?php endforeach; ?>

	</div>

	<?php
	echo $this->element('pageCtrl', array(
			'info' => true,
			'right' => false
	));
	?>

</main>


