<?php
$this->assign('icon', $icon);
$this->assign('title', $title);
$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

$this->Html->script('ckeditor/ckeditor.js',
		array('block' => 'script')
);
$this->Html->script('ckeditor/myeditor.js',
		array('block' => 'scriptBottom')
);

?>

<?php $this->Html->scriptStart( array("block"=>'script',"inline"=>false)); ?>
<!--<script>-->
$(function (){

	$('.grid').packery({
		itemSelector: '.grid-item',
		gutter: 10
	});

	$('.topAppIcon').css('cursor', 'pointer')
		.click(function (e){
			$aid = $(e.currentTarget).data("aid");
			window.location = '/admin/applications/editObject/' + $aid;
		})

	$('.topAddApp').css('cursor', 'pointer')
		.click(function (e){
			window.location = '/admin/applications/editObject/';
		})

	$('#deleteButton').click(function(e) {
		$aid = $(e.currentTarget).data("aid");
		$back = $(e.currentTarget).data("back");
		if($aid == 0){
			alert('#' + $aid + 'は削除できません。');
		}else{
			if (!confirm('本当にこのアプリ（#' + $aid + '）を削除してもよろしいですか？')) {
				return false;
			} else {// OKの場合
				window.location.href = '/admin/applications/deleteObject/' + $aid + '/' + $back + '<?= $queryStr ?>';
			}
		}
	});
})

<?php $this->Html->scriptEnd(); ?>

<?php echo $this->Html->scriptStart( array("block"=>'scriptBottom',"inline"=>false)); ?>
<!--<script>-->
setCkeditor('#appInfo');
<?php echo $this->Html->scriptEnd(); ?>

<a href="/admin/applications/viewObject/<?= $myObject['Application']['id'] ?>/<?= $backid.$queryStr ?>" class="btn btn-secondary"><< VIEW APP</a>

<div class="container pt-4">
	<div class="row">
		<div class="col-md-10">
			<form id="myform" class="pt-3" action="/admin/applications/editObject/<?= $myObject['Application']['id'] ?>/<?= $backid.$queryStr ?>" method="post">

				<div class="float-right mb-2">
					<small><?= ($isAdmin) ? '[管理者クッキーあり]' : '[管理者クッキーなし]' ?></small></small>
				</div>


				<input name="uid" type="hidden" value="<?= $myObject['Application']['id'] ?>">


				<div class="form-group row miniAreaBox">
					<label for="appName" class="col-sm-2 col-form-label">アプリ名称</label>
					<div class="col-sm-10 normalFont">
						<input id="appName" name="name" class="form-control" value="<?= $myObject['Application']['name'] ?>">
						<small class="form-text text-muted">
							長過ぎないように簡潔な名称を入力してください。
						</small>
					</div>
				</div>

				<div class="form-group row">
					<label for="appInfo" class="col-sm-2 col-form-label">アプリ概要</label>
					<div class="col-sm-10 normalFont">
						<textarea id="appInfo" name="info"><?= $myObject['Application']['info'] ?></textarea>
						<small class="form-text text-muted">
							アプリ概要を入力してください。
						</small>
					</div>
				</div>

				<div class="form-group row">
					<label for="appIosURL" class="col-sm-2 col-form-label">iOS App Store URL</label>
					<div class="col-sm-10">
						<input id="appIosURL" name="ios_url" class="form-control" type="text" placeholder="" value="<?= $myObject['Application']['ios_url'] ?>">
						<small class="form-text text-muted">iOS App StoreのURLを入力してください。</small>
					</div>
				</div>

				<div class="form-group row">
					<label for="appAndroidURL" class="col-sm-2 col-form-label">Google Play Store URL</label>
					<div class="col-sm-10">
						<input id="appAndroidURL" name="android_url" class="form-control" type="text" placeholder="" value="<?= $myObject['Application']['android_url'] ?>">
						<small class="form-text text-muted">Google Play Store のURLを入力してください。</small>
					</div>
				</div>


				<?php
				$uploadDisabled = true;
				if($myObject['Application']['id'] != 0){
					$uploadDisabled = false;
					?>
					<div class="form-group row">
						<label for="inputPdf" class="col-sm-2 col-form-label">ファイル名</label>
						<div class="col-sm-10">
							<input name="image" type="hidden" value="<?= $myObject['Application']['image'] ?>">
							<input id="inputPdf" class="form-control mb-1" type="text" placeholder="" value="<?= $myObject['Application']['image'] ?>" disabled>
							<small class="form-text text-muted">アプリアイコンは、<a href="#profileUploaderArea">画像アップローダー</a>を使ってアップロードしてください。</small>
						</div>


					</div>
				<?php }else{echo '<input name="image" type="hidden" value="">';} ?>





				<div class="text-right p-1">
					<a href="/admin/applications/viewObject/<?= $myObject['Application']['id'] ?>/<?= $backid.$queryStr ?>" class="btn btn-secondary"><< VIEW APP</a>
					<button id="submitButton" type="submit" name="action" class="btn btn-primary" value="edited"><?= ($myObject['Application']['id'] == 0) ? __('新規作成') : __('更新') ?></button>
				</div>

			</form>

			<hr/>

			<div class="text-right p-1">
				<button id="deleteButton" type="button" class="btn btn-danger" data-aid="<?= $myObject['Application']['id'] ?>" data-back="<?= $backid ?>">このアプリを完全に削除する <i class="far fa-window-restore"></i></button>
			</div>

			<hr class="mb-5"/>
		</div>

		<div class="col-md-2">
			<div id="profileUploaderArea">
				<a href="/admin/applications/deletefile/<?= $id ?>/<?= $backid.$queryStr ?>" class="float-right btn btn-danger btn-sm mr-1 mb-1 <?= ($myObject['Application']['image'] == '') ? 'disabled' : '' ?>">DELETE</a>
				<img src="/img/applications/<?= ($myObject['Application']['image'] != '') ? $myObject['Application']['image'] : 'image.png' ?>" class="img-fluid rounded mb-2">
				<br>
				<a class="btn btn-info btn-sm text-light <?= ($uploadDisabled) ? 'disabled' : '' ?>"
				   data-toggle="modal"
				   data-target="#fileUploader"
				>アップローダー</a>

				<?= ($uploadDisabled) ? '<small class="form-text text-muted">新規作成の場合は、まず<span class="cmsColor_news">アプリを作成してから</span>画像ファイルをアップロードしてください。</small>' : '' ?>
			</div>
		</div>
</div>
</div>



<div id="fileUploader" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<form action="/admin/applications/uploadfile/<?= $id ?>/<?= $backid.$queryStr ?>" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">写真アップローダー</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label for="inputCost" class="col-sm-2 col-form-label">画像</label>
						<div class="col-sm-10">
							<div class="pt-2">
								<input id="upload_id" name="upload_id" type="hidden" value="<?= $myObject['Application']['id'] ?>">
								<input id="existing_file" name="existing_file" type="hidden" value="<?= $myObject['Application']['image'] ?>">
								<input id="inputNum" name="upload_file" type="file" value="">
								<small class="form-text text-muted">画像(.jpgか.png)を選択し、アップロードしてください。</small>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
					<button type="submit" name="action" class="btn btn-primary" value="uploaded">アップロード</button>
				</div>
			</div>
		</form>
	</div>
</div>
