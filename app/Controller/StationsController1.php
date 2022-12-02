<?php
App::uses('AdminsController', 'Controller');
/**
 * Stations Controller
 */
class StationsController extends AdminsController {

/**
 * Scaffold
 *
 * @var mixed
 */
//	public $scaffold = 'admin';

	public $uses = array(
		'Station',
	);

	public function admin_listStations($appid = 0, $backId = 0){
		$title = 'STAMP POINT MANAGER TOP';
		$icon = 'fas fa-stamp';

		$theConditions = array(
			'conditions' => array(
				'Station.application_id =' => $appid,
			),
			'order' => array(
//                    'Item.orderby' => 'DESC',
			),
			'fields' => array(
//                'Category.id',
//                'Category.name',
//                'Category.Item.id'
			),
			'recursive' => 2 //第二階層まで
		);

		$myStations = $this->Station->find('all', $theConditions);

		$isAdmin = $this->isAdmin();
		$this->Set(compact('title', 'icon','myStations', 'appid', 'isAdmin'));
	}

	public function admin_editStation($id = 0, $backId = 0)
	{
		$title = 'EDIT STAMP POINT';
		$icon = 'fas fa-stamp';
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
					$this->Station->create(); // Create a new record
					$myStation = $this->Station->save($theData); // And save it
					$updatedId = $myStation['Station']['id'];
					$msg = '#' . $updatedId . 'を新規作成しました。';
				}else{
					$myStation = $this->Station->save($theData); //更新
					$updatedId = $id;
					$msg = '#' . $updatedId . 'を更新しました。';
				}

				$this->Set(compact('title', 'myStation'));
//				return;
			}

			$this->Flash->admin_flash($msg);
			$this->redirect( '/admin/stations/editStation/'.$updatedId.'/'.$backId.$queryStr );
			return;
		}

		if($id != 0) {
			$myStation = $this->Station->findById($id);
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

			$myStation = $this->Station->set($theInitData);
		}
//		$this->_renderJson($myApplication);
		$isAdmin = $this->isAdmin();
		$this->Set(compact('title', 'icon','myStation', 'id', 'backId', 'isAdmin'));
	}

	public function admin_viewStation($id = 0){
		$title = 'VIEW STAMP POINT';
		$icon = 'fas fa-stamp';

		$myStation = $this->Station->findById($id);
		$isAdmin = $this->isAdmin();
		$this->Set(compact('title', 'icon','myStation', 'id', 'isAdmin'));
	}

	public function admin_deleteStation($id = 0, $backId = 1){
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';
		if($id != 0) {

			$this->Station->delete($id, false);
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
		$this->redirect( '/admin/stations/editStation/' );
	}

	public function admin_duplicateStation($id = 0, $backId = 1){
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';
		if($id != 0) {

			$row = $this->Station->findById($id);
			$row['Station']['id'] = null;

			$this->Station->create(); // Create a new record
			$res = $this->Station->save($row); // And save it

			$this->Flash->admin_flash(
				__('#' . $id . 'を複製し、'. $res['Station']['id'] .'を新規に作成しました。'),
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
		$this->redirect( '/admin/stations/editStation/' );
	}


	public function admin_uploadfile($id = 0, $backId = 0){ //redirectのための引数

		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

		// mysqlにデータを格納する方法もあるようだが、ここでは単純にファイルアップロードに。
		// http://cakephpクッキング.jp/image-save-db/

		//パラメータよりイメージ情報を取得
//		$image = $this->request->data('upload_file');
		$image = $this->params['form']['upload_file'];

		//イメージ保存先パス
		$img_save_path = IMAGES.'stations' ;

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

			$this->Station->save($theData);

			//既存ファイル削除処理
			if($existing_file != ''){
				$deleteMsg = $this->deleteLocalFile('applications', $existing_file);
				$msg = $msg.'既存ファイルについては、'.$deleteMsg;
			}

		}else{
			$msg = 'エラーが発生してアップロードできませんでした。';
		}


		$this->Flash->admin_flash(__($msg));

		$this->redirect( '/admin/stations/editStation/'.$id.'/');
	}

	public function admin_deletefile($id = 0, $backId = 0){ //redirectのための引数
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

		$target = $this->Station->findById($id);
		$filename = $target['Station']['image'];
		$msg = $this->deleteLocalFile('stations', $filename);

		$theData = array();
		$theData['id'] = $id;
		$theData['image'] = null;

		$this->Station->save($theData);

		$this->Flash->admin_flash(__('画像ファイル'.$msg));
		$this->redirect( '/admin/stations/editStation/'.$id.'/');
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
