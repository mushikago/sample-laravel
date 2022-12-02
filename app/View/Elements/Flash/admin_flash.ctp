<?php //bootstrap4 Alerts class=alert-danger,alert-warning etc,?>
<div class="alert <?php echo !empty($params['class']) ? $params['class'] : 'alert-info'; ?> alert-dismissible fade show" role="alert">
	<?php echo h($message) ?>
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
