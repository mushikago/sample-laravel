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


//$this->Html->css('//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css');
//$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js');

$this->Html->script('//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js',
	array(
			'integrity' => 'sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==',
			'crossorigin' => 'anonymous',
			'block' => 'script'
	));
$this->Html->css('//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css',
		array(
				'integrity' => 'sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==',
				'crossorigin' => 'anonymous',
				'block' => 'css'
		));


?>

<?php $this->Html->scriptStart( array("block"=>'script',"inline"=>false)); ?>
<!--<script>-->
$(function (){
jQuery.datetimepicker.setLocale('ja');
	var format = {
		format: 'Y-m-d H:i',
		allowTimes:[
			'00:00','00:30','01:00','01:30','02:00','02:30','03:00','03:30',
			'04:00','04:30','05:00','05:30','06:00','06:30','07:00','07:30',
			'08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30',
			'12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30',
			'16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30',
			'20:00','20:30','21:00','21:30','22:00','22:30','23:00','23:30'
		]
	};
	$('#dev_start_date_picker').datetimepicker(format);
	$('#start_date_picker').datetimepicker(format);
	$('#end_date_picker').datetimepicker(format);

	$('#deleteButton').click(function(e) {
		$id = $(e.currentTarget).data("id");
		$backid = $(e.currentTarget).data("back");
		if($id == 0){
			alert('#' + $id + 'は削除できません。');
		}else{
			if (!confirm('本当にこのアプリ（#' + $id + '）を削除してもよろしいですか？')) {
				return false;
			} else {// OKの場合
				window.location.href = '/admin/events/deleteObject/' + $id + '/' + $backid + '<?= $queryStr ?>';
			}
		}
	});
})

<?php $this->Html->scriptEnd(); ?>

<?php echo $this->Html->scriptStart( array("block"=>'scriptBottom',"inline"=>false)); ?>
<!--<script>-->
setCkeditor('#appInfo');
<?php echo $this->Html->scriptEnd(); ?>

<a href="/admin/events/listObjects/<?= $myObject['Event'][$belong] ?>/<?= $backid.$queryStr ?>" class="btn btn-secondary"><< LIST EVENTS</a>

<div class="container pt-4">
	<div class="row">
		<div class="col-md-10">
			<form id="myform" class="pt-3" action="/admin/events/editObject/<?= $myObject['Event']['id'] ?>/<?= $backid.$queryStr ?>" method="post">
				<input type="hidden" name="application_id" value="<?= $backid ?>">
				<div class="float-right mb-2">
					<small><?= ($isAdmin) ? '[管理者クッキーあり]' : '[管理者クッキーなし]' ?></small></small>
				</div>


				<input name="uid" type="hidden" value="<?= $myObject['Event']['id'] ?>">


				<div class="form-group row miniAreaBox">
					<label for="appName" class="col-sm-2 col-form-label">イベント名称</label>
					<div class="col-sm-10 normalFont">
						<input id="appName" name="name" class="form-control" value="<?= $myObject['Event']['name'] ?>">
						<small class="form-text text-muted">
							長過ぎないように簡潔な名称を入力してください。
						</small>
					</div>
				</div>

				<div class="form-group row">
					<label for="appInfo" class="col-sm-2 col-form-label">イベント概要</label>
					<div class="col-sm-10 normalFont">
						<textarea id="appInfo" name="info"><?= $myObject['Event']['info'] ?></textarea>
						<small class="form-text text-muted">
							イベント概要を入力してください。
						</small>
					</div>
				</div>

				<div class="form-group row">
					<label for="dev_start_date_picker" class="col-sm-2 col-form-label">運用期間</label>
					<div class="col-sm-10">
						<input id="dev_start_date_picker" name="dev_start" class="form-control mb-2" type="text" placeholder="DEVELOP" value="<?= $myObject['Event']['dev_start'] ?>">
						<input id="start_date_picker" name="start" class="form-control mb-2" type="text" placeholder="START" value="<?= $myObject['Event']['start'] ?>">
						<input id="end_date_picker" name="end" class="form-control" type="text" placeholder="END" value="<?= $myObject['Event']['end'] ?>">
						<small class="form-text text-muted">
							終了期日が定まっていない場合は、遠い未来の日付を入力してください。<br>
							<br>
							イベントとは基本スタンプラリーイベントです。<br>
							イベントを作成後、スタンプポイントを追加してください。
						</small>
					</div>
				</div>




				<?php
				$uploadDisabled = true;
				if($myObject['Event']['id'] != 0){
					$uploadDisabled = false;
					?>
					<div class="form-group row">
						<label for="inputPdf" class="col-sm-2 col-form-label">ファイル名</label>
						<div class="col-sm-10">
							<input name="image" type="hidden" value="<?= $myObject['Event']['image'] ?>">
							<input id="inputPdf" class="form-control mb-1" type="text" placeholder="" value="<?= $myObject['Event']['image'] ?>" disabled>
							<small class="form-text text-muted">アプリアイコンは、<a href="#profileUploaderArea">画像アップローダー</a>を使ってアップロードしてください。</small>
						</div>


					</div>
				<?php }else{echo '<input name="image" type="hidden" value="">';} ?>





				<div class="text-right p-1">
					<a href="/admin/events/listObjects/<?= $backid.$queryStr ?>" class="btn btn-secondary"><< LIST EVENTS</a>
					<button id="submitButton" type="submit" name="action" class="btn btn-primary" value="edited"><?= ($myObject['Event']['id'] == 0) ? __('新規作成') : __('更新') ?></button>
				</div>

			</form>

			<hr/>

			<div class="text-right p-1">
				<a href="/admin/events/duplicateObject/<?= $id ?>/<?= $backid ?>/" class="btn btn-info mb-2">このイベントを複製する</a><br>
				<button id="deleteButton" type="button" class="btn btn-danger" data-id="<?= $myObject['Event']['id'] ?>" data-back="<?= $backid ?>">このイベントを完全に削除する <i class="far fa-window-restore"></i></button>
			</div>

			<hr class="mb-5"/>
		</div>

		<div class="col-md-2">
			<div id="profileUploaderArea">
				<a href="/admin/events/deletefile/<?= $id ?>/<?= $backid.$queryStr ?>" class="float-right btn btn-danger btn-sm mr-1 mb-1 <?= ($myObject['Event']['image'] == '') ? 'disabled' : '' ?>">DELETE</a>
				<img src="/img/events/<?= ($myObject['Event']['image'] != '') ? $myObject['Event']['image'] : 'image.png' ?>" class="img-fluid rounded mb-2">
				<br>
				<a class="btn btn-info btn-sm text-light <?= ($uploadDisabled) ? 'disabled' : '' ?>"
				   data-toggle="modal"
				   data-target="#fileUploader"
				>アップローダー</a>

				<?= ($uploadDisabled) ? '<small class="form-text text-muted">新規作成の場合は、まず<span class="cmsColor_news">イベントを作成してから</span>画像ファイルをアップロードしてください。</small>' : '' ?>
			</div>

			<div class="text-right pt-3">
				<a href="/admin/stations/listObjects/<?= $id ?>/<?= $backid.$queryStr ?>" class="btn btn-warning mb-2"><i class="fas fa-stamp"></i><br>STAMP POINTS</a><br>
			</div>
		</div>
</div>
</div>



<div id="fileUploader" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<form action="/admin/events/uploadfile/<?= $id ?>/<?= $backid.$queryStr ?>" method="post" enctype="multipart/form-data">
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
								<input id="upload_id" name="upload_id" type="hidden" value="<?= $myObject['Event']['id'] ?>">
								<input id="existing_file" name="existing_file" type="hidden" value="<?= $myObject['Event']['image'] ?>">
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
