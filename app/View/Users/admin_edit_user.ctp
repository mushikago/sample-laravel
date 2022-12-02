<?php
function gUInfo($user, $prop){
	return (isset($user)) ? $user[$prop] : '---';
}

function gUDiv($user, $param){
	if(isset($user)){
		if ($user['division_id'] == $param){
			return 'checked';
		}else{
			return '';
		}
	}
}
?>
<div class="container p-3">
	<h1><i class="far fa-edit"></i> ユーザー情報変更</h1>

	<form class="pt-3" action="/admin/users/editUser/" method="post">

		<div class="form-group row">
			<label for="inputName" class="col-sm-2 col-form-label">ログインID</label>
			<div class="col-sm-10">
				<input class="form-control" type="text" placeholder="yamada" readonly value="<?php echo gUInfo($thisUser,'username'); ?>" disabled>
				<small class="form-text text-muted">変更したい場合は、管理者までご連絡ください。</small>
			</div>
		</div>

		<div class="form-group row">
			<label for="inputPassword" class="col-sm-2 col-form-label">パスワード</label>
			<div class="col-sm-10">
				<input name="password" id="inputPassword" placeholder="" type="password" class="form-control bg-warning" maxlength="16">
				<small class="form-text text-muted">変更する場合は入力し、変更しない場合は<span class="text-danger">空欄のまま</span>。</small>
			</div>
		</div>



		<fieldset class="form-group">
			<div class="row">
				<legend class="col-form-label col-sm-2 pt-0">区分</legend>
				<div class="col-sm-10">
					<div class="form-check">
						<input class="form-check-input" type="radio" name="division" id="gridRadios1" value="1" <?php echo gUDiv($thisUser, '1'); ?>>
						<label class="form-check-label" for="gridRadios1">
							BeBeBe Alliance
						</label>
						<small id="emailHelp" class="form-text text-muted">仮区分です</small>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="division" id="gridRadios2" value="2" <?php echo gUDiv($thisUser, '2'); ?>>
						<label class="form-check-label" for="gridRadios2">
							ほげ
						</label>
						<small id="emailHelp" class="form-text text-muted">仮区分です</small>
					</div>
					<small class="form-text text-muted">※ コメント</small>
				</div>
			</div>
		</fieldset>



		<div class="text-right p-1">
			<button type="submit" name="action" class="btn btn-primary" value="edited">更新</button>
		</div>
	</form>

</div>


