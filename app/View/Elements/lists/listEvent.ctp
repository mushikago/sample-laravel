<?php
$e = $event['Event'];
$t_start = new DateTime($e['start']);;
$day_start = $t_start->format('Y年m月d日');

$this->assign('name', $e['name']);
$this->assign('start', $day_start);
//$this->assign('mainTitle', mayHasRuby($d['mainTitle']));
?>

<div class="container pb-3">
	<div class="eventTitleBar row ">
		<div class="col-9 eventTitle">
			<?= $this->fetch('name'); ?>
		</div>
		<div class="col-3">
			<a class="btn eventEditButton w-100" href="/admin/events/editObject/<?= $e['id']; ?>/<?= $backid.$queryStr ?>" >編集</a>
		</div>

	</div>
	<div>
		<div class="col-12"><small>STAMP POINT 23 か所</small></div>
		<div class="col-12"><small>開催期間　<?= $this->fetch('start'); ?> より無期限</small></div>
		<div class="col-12"><small>現在の総スタンプ数　2342</small></div>
	</div>

</div>


