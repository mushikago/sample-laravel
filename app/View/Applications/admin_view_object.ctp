<?php
$this->assign('icon', $icon);
$this->assign('title', $title);
$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

?>

<?php $this->Html->scriptStart( array("block"=>'script',"inline"=>false)); ?>
<!--<script>-->
$(function (){
/*
	$('.grid').packery({
		itemSelector: '.grid-item',
		gutter: 10
	});

	$('.topAppIcon').css('cursor', 'pointer')
		.click(function (e){
			$aid = $(e.currentTarget).data("aid");
			window.location = '/admin/applications/editApplication/' + $aid;
		})

	$('.topAddApp').css('cursor', 'pointer')
		.click(function (e){
			window.location = '/admin/applications/editApplication/';
		})
*/
})

<?php $this->Html->scriptEnd(); ?>

<?php echo $this->Html->scriptStart( array("block"=>'scriptBottom',"inline"=>false)); ?>
<!--<script>-->

<?php echo $this->Html->scriptEnd(); ?>

<a href="/admin/" class="btn btn-secondary"><< CONSOLE TOP</a>

<div class="container pt-4">
	<div class="row">
		<div class="col-md-10">

			<div class="container panel-group">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#collapse1"><button class="btn bg-info text-light"><i class="fab fa-app-store-ios"></i> アプリ概要</button></a>
						</h4>
					</div>
					<div id="collapse1" class="panel-collapse collapse show">
						<div class="panel-body">
							<div class="container borderTitle">

								<div class="form-group row miniAreaBox">
									<label for="appName" class="col-sm-2 col-form-label">アプリ名称</label>
									<div class="col-sm-10 normalFont">
										<div id="appName" class="" ><?= $myObject['Application']['name'] ?></div>
										<small class="form-text text-muted">
											hoge
										</small>
									</div>
								</div>

								<div class="form-group row">
									<label for="appInfo" class="col-sm-2 col-form-label">アプリ概要</label>
									<div class="col-sm-10 normalFont">
										<div id="appInfo"><?= $myObject['Application']['info'] ?></div>
										<small class="form-text text-muted">
											hoge
										</small>
									</div>
								</div>

								<div class="form-group row">
									<label for="appIosURL" class="col-sm-2 col-form-label">iOS App Store URL</label>
									<div class="col-sm-10">
										<div id="appIosURL" class="" ><a href="<?= $myObject['Application']['ios_url'] ?>" target="_blank"><?= $myObject['Application']['ios_url'] ?></a></div>
										<small class="form-text text-muted">iOS App Store</small>
									</div>
								</div>

								<div class="form-group row">
									<label for="appIosURL" class="col-sm-2 col-form-label">Google Play Store URL</label>
									<div class="col-sm-10">
										<div id="appIosURL" class="" ><a href="<?= $myObject['Application']['android_url'] ?>" target="_blank"><?= $myObject['Application']['android_url'] ?></a></div>
										<small class="form-text text-muted">Google Play Store</small>
									</div>
								</div>

								<div class="text-right p-1">
									<a href="/admin/applications/editObject/<?= $myObject['Application']['id'] ?>/0" class="btn btn-warning">編集</a>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="list-group p-3">
				<a href="/admin/events/listObjects/<?= $myObject['Application']['id'] ?>" class="list-group-item list-group-item-action bg-warning text-light">
					イベント一覧・改廃
				</a>
				<a href="#" class="list-group-item list-group-item-action disabled">
					クーポン一覧・改廃
				</a>
				<a href="#" class="list-group-item list-group-item-action disabled">
					バナーリンク一覧・改廃
				</a>
				<a href="#" class="list-group-item list-group-item-action disabled">
					カスタム設定一覧・改廃
				</a>
			</div>


			<div class="container">
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







			<div class="text-right">
				<a href="/admin/" class="btn btn-danger pl-5 mr-3"><< CONSOLE TOP</a>
			</div>

			<hr class="mb-5"/>
		</div>

		<div class="col-md-2">
			<div id="AppInfoArea">
				<img src="/img/applications/<?= ($myObject['Application']['image'] != '') ? $myObject['Application']['image'] : 'image.png' ?>" class="img-fluid rounded mb-2">
				<br>

			</div>
		</div>
</div>
</div>


