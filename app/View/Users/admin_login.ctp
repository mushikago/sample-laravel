<div class="users form container p-5">

	<?php echo $this->Form->create('User'); ?>
	<div class="form-group">
		<?php echo $this->Form->input('username',
				array(
						'label' => 'USER ID',
						'class' => 'form-control userInput',
						'placeholder' => 'USER ID',
						'aria-describedby' => 'usernameHelp'
				)
		); ?>
		<small id="usernameHelp" class="form-text text-muted"><?= __('指定されたユーザー名を入力してください。')?></small>
	</div>
	<div class="form-group">
		<?php echo $this->Form->input('password',
				array(
						'label' => 'PASSWORD',
						'class' => 'form-control userInput',
						'placeholder' => 'PASSWORD'
				)
		); ?>
	</div>

	<button type="submit" class="btn btn-primary">LOGIN</button>
	<?php //echo $this->Flash->render('auth'); ?>
</div>
