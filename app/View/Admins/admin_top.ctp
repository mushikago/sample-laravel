<?php
$this->assign('icon', __('fas fa-cog'));
$this->assign('title', 'ADMINISTRATOR TOP');
?>


	<?php $this->Html->scriptStart( array("block"=>'script',"inline"=>false)); ?>
<!--	<script>-->
	$(function (){

		$('.grid').packery({
			itemSelector: '.grid-item',
			gutter: 10
		});

		$('.topAppIcon').css('cursor', 'pointer')
		.click(function (e){
			$aid = $(e.currentTarget).data("aid");
			window.location = '/admin/applications/viewObject/' + $aid;
		})

		$('.topAddApp').css('cursor', 'pointer')
				.click(function (e){
					window.location = '/admin/applications/editObject/0';
				})

	})

	<?php $this->Html->scriptEnd(); ?>


<main role="main">

	<div class="pb-5">
		<div class="grid">
			<?php foreach ($myApplications as $application): ?>
			<div class="grid-item grid-item--width2 grid-item--height2 topAppIcon" data-aid="<?= $application['Application']['id'] ?>">
				<figure class="figure">
					<img src="/img/applications/<?= ($application['Application']['image'] == '') ? 'image.png' : $application['Application']['image'] ?>" class="img-fluid">
				</figure>
<!--				<img src="/img/applications/--><?//= $application['Application']['image'] ?><!--" width="210" height="210">-->
			</div>
			<?php endforeach; ?>
			<div class="grid-item grid-item--width2 grid-item--height2 topAddApp"><i class="fas fa-plus"></i></div>
		</div>
	</div>

	<div class="container pb-5">
		<table class="table table-bordered">
			<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">APP LOGIN</th>
				<th scope="col">USER COUNT</th>
				<th scope="col">TODAYS TOTAL STAMPS</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<th scope="row">1</th>
				<td>20233</td>
				<td>2030</td>
				<td>234</td>
			</tr>
			<tr>
				<th scope="row">2</th>
				<td>3455</td>
				<td>122</td>
				<td>58</td>
			</tr>
			<tr>
				<th scope="row">3</th>
				<td colspan="2">435</td>
				<td>499</td>
			</tr>
			</tbody>
		</table>
	</div>

</main>
