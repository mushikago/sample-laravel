<?php
App::uses('AdminsController', 'Controller');
/**
 * Applications Controller
 */
class ApplicationsController extends AdminsController {

/**
 * Scaffold
 *
 * @var mixed
 */
//	public $scaffold = 'admin';

	public function admin_editApplication1($aid = 0){
		$theConditions = array(
			'conditions' => array(
//				'User.id =' => $thisUser['id'],
			),
			'order' => array(
//				'Order.id' => 'DESC',
			),
			'fields' => array(
//				'User.id',
			),
//            'recursive' => 2 //第二階層まで
		);


		$myApplications = $this->Application->find('all',$theConditions);
		$this->Set(compact('myApplications'));
	}

	public function admin_editApplication($id = 0, $backId = 0)
	{
		$title = 'EDIT APP';
		$icon = 'fas fa-cog';
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';


		if(!empty($_POST)){
//			Debugger::dump('更新');
			if ($_POST['action'] == 'edited') {
				$theData = array();
				$theData['id'] = ($_POST['uid'] != 0) ? $_POST['uid'] : null;
//				$theData['is_view'] = (!empty($_POST['is_view'])) ? 1 : 0;
				$theData['name'] = $_POST['name'];
				$theData['info'] = $_POST['info'];
				$theData['ios_url'] = $_POST['ios_url'];
				$theData['android_url'] = $_POST['android_url'];
//				$theData['dev_start'] = $_POST['dev_start'];
				$theData['image'] = $_POST['image'];

				if($_POST['uid'] == 0){ //新規作成なら紐付ける

					//新規作成して新規のID取得
					$this->Application->create(); // Create a new record
					$myApplication = $this->Application->save($theData); // And save it
					$updatedId = $myApplication['Application']['id'];
					$msg = '#' . $updatedId . 'を新規作成しました。';
				}else{
					$myApplication = $this->Application->save($theData); //更新
					$updatedId = $id;
					$msg = '#' . $updatedId . 'を更新しました。';
				}

				$this->Set(compact('title', 'myApplication'));
//				return;
			}

			$this->Flash->admin_flash($msg);
			$this->redirect( '/admin/applications/editApplication/'.$updatedId.'/'.$backId.$queryStr );
			return;
		}

		if($id != 0) {
			$myApplication = $this->Application->findById($id);
		}else{
//			Debugger::dump('新規');
			$theInitData = array();
			$theInitData['id'] = 0;
			$theInitData['name'] = '';
			$theInitData['info'] = '';
			$theInitData['ios_url'] = '';
			$theInitData['android_url'] = '';
//			$theInitData['dev_start'] = '';
			$theInitData['image'] = '';

			$myApplication = $this->Application->set($theInitData);
		}
//		$this->_renderJson($myApplication);
		$isAdmin = $this->isAdmin();
		$this->Set(compact('title', 'icon','myApplication', 'id', 'backId', 'isAdmin'));
	}

	public function admin_viewApplication($id = 0){

		if($id == 0){
			$this->redirect( '/admin/' );
		}

		$title = 'APP MANAGER TOP';
		$icon = 'fab fa-app-store';

		$myApplication = $this->Application->findById($id);
		$isAdmin = $this->isAdmin();
		$this->Set(compact('title', 'icon','myApplication', 'id', 'isAdmin'));
	}

	public function admin_deleteApplication($id = 0, $backId = 1){
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';
		if($id != 0) {

			$this->Application->delete($id, false);
			$this->Flash->admin_flash(
				__('#' . $id . 'を削除しました。'),
				array(
					'params' => array(
						'class' => 'alert-danger'
					)
				)
			);
		}else{
			$this->Flash->admin_flash(
				__('何も削除されませんでした。'),
				array(
					'params' => array(
						'class' => 'alert-warning'
					)
				)
			);
		}
		$this->redirect( '/admin/' );
	}

	public function admin_duplicateApplication($id = 0, $backId = 1){
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';
		if($id != 0) {

			$row = $this->Application->findById($id);
			$row['Application']['id'] = null;

			$this->Application->create(); // Create a new record
			$res = $this->Application->save($row); // And save it

			$this->Flash->admin_flash(
				__('#' . $id . 'を複製し、'. $res['Application']['id'] .'を新規に作成しました。'),
				array(
					'params' => array(
						'class' => 'alert-info'
					)
				)
			);
		}else{
			$this->Flash->admin_flash(
				__('何も複製されませんでした。'),
				array(
					'params' => array(
						'class' => 'alert-warning'
					)
				)
			);
		}
		$this->redirect( '/admin/applications/editApplication/' );
	}


	public function admin_uploadfile($id = 0, $backId = 0){ //redirectのための引数

		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

		// mysqlにデータを格納する方法もあるようだが、ここでは単純にファイルアップロードに。
		// http://cakephpクッキング.jp/image-save-db/

		//パラメータよりイメージ情報を取得
//		$image = $this->request->data('upload_file');
		$image = $this->params['form']['upload_file'];

		//イメージ保存先パス
		$img_save_path = IMAGES.'applications' ;

		//拡張子取得
		$ext = pathinfo($image['name'], PATHINFO_EXTENSION);
		$isOkExt = false;
		switch ($ext){
			case "gif":
			case "GIF":
			case "png":
			case "PNG":
			case "jpg":
			case "JPG":
			case "jpeg":
			case "JPEG":
				$isOkExt = true;
				break;
			default:
				$isOkExt = false;
				break;
		}

//		if($id == 0 || $backId == 0){
//			$isOkExt = false;
//		}

		$msg = '';
		if ($isOkExt && $this->request->data('action') == 'uploaded'){

			$id = $this->request->data('upload_id');
			$existing_file = $this->request->data('existing_file');

			//イメージの保存処理
			$randomFileName = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 16);
			$theFileName = 'app_'.sprintf('%04d', $id).'_'.$randomFileName.'.'.$ext;
			move_uploaded_file($image['tmp_name'], $img_save_path.DS.$theFileName);
			$msg = 'アップロードしました。';

			$theData = array();
			$theData['id'] = $id;
			$theData['image'] = $theFileName;

			$this->Application->save($theData);

			//既存ファイル削除処理
			if($existing_file != ''){
				$deleteMsg = $this->deleteLocalFile('applications', $existing_file);
				$msg = $msg.'既存ファイルについては、'.$deleteMsg;
			}

		}else{
			$msg = 'エラーが発生してアップロードできませんでした。';
		}


		$this->Flash->admin_flash(__($msg));

		$this->redirect( '/admin/applications/editApplication/'.$id.'/');
	}

	public function admin_deletefile($id = 0, $backId = 0){ //redirectのための引数
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

		$target = $this->Application->findById($id);
		$filename = $target['Application']['image'];
		$msg = $this->deleteLocalFile('applications', $filename);

		$theData = array();
		$theData['id'] = $id;
		$theData['image'] = null;

		$this->Application->save($theData);

		$this->Flash->admin_flash(__('画像ファイル'.$msg));
		$this->redirect( '/admin/applications/editApplication/'.$id.'/');
	}

	protected function deleteLocalFile($filepath, $filename){
		$img_save_path = IMAGES.$filepath; //イメージ保存先パス
		$filefullpath = $img_save_path.DS.$filename;
		$this->log(file_exists($filefullpath));

		if(file_exists($filefullpath)){
			unlink($filefullpath);
			$msg = 'ファイルを削除しました。';
		}else{
			$msg = 'ファイルが存在せず削除できませんでした。';
		}
		return $msg;
	}
}
