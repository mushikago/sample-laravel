<?php
App::uses('AdminsController', 'Controller');
/**
 * Events Controller
 */
class EventsController extends AdminsController {

/**
 * Scaffold
 *
 * @var mixed
 */
//	public $scaffold = 'admin';

	public $components = array('Auth','Paginator');

	public $uses = array(
//		'Event',
	);

	public function admin_listEvents($appid = 0, $backId = 0){
		$title = 'EVENT MANAGER TOP';
		$icon = 'fas fa-flag-checkered';

		$theConditions = array(
			'limit' => 20,
			'conditions' => array(
				'Event.application_id =' => $appid,
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

//		$myEvents = $this->Event->find('all', $theConditions);
		$this->Paginator->settings = $theConditions;
		$myEvents = $this->Paginator->paginate();

		$isAdmin = $this->isAdmin();
//		$this->_renderJson($myEvents);
		$this->Set(compact('title', 'icon','myEvents', 'appid', 'isAdmin'));
	}

	public function admin_editEvent($id = 0, $appid = 0)
	{
		$title = 'EDIT EVENTS';
		$icon = 'fas fa-flag-checkered';
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';


		if(!empty($_POST)){
//			Debugger::dump('更新');
			if ($_POST['action'] == 'edited') {
				$theData = array();
				$theData['id'] = ($_POST['uid'] != 0) ? $_POST['uid'] : null;
				$theData['application_id'] = $_POST['application_id'];
				$theData['name'] = $_POST['name'];
				$theData['info'] = $_POST['info'];
				$theData['start'] = $_POST['start'];
				$theData['end'] = $_POST['end'];
				$theData['dev_start'] = $_POST['dev_start'];
//				$theData['status'] = $_POST['status'];
//				$theInitData['event_code'] = $_POST['event_code'];

				if($_POST['uid'] == 0){ //新規作成なら紐付ける

					//新規作成して新規のID取得
					$this->Event->create(); // Create a new record
					$myEvent = $this->Event->save($theData); // And save it
					$updatedId = $myStation['Event']['id'];
					$msg = '#' . $updatedId . 'を新規作成しました。';
				}else{
					$myEvent = $this->Event->save($theData); //更新
					$updatedId = $id;
					$msg = '#' . $updatedId . 'を更新しました。';
				}

				$isAdmin = $this->isAdmin();
				$this->Set(compact('title', 'icon','myEvent', 'id', 'appid', 'isAdmin'));
//				return;
			}

			$this->Flash->admin_flash($msg);
			$this->redirect( '/admin/events/editEvent/'.$updatedId.'/'.$appid.$queryStr );
			return;
		}

		if($id != 0) {
			$myEvent = $this->Event->findById($id);
		}else{
//			Debugger::dump('新規');
			$theInitData = array();
			$theInitData['id'] = 0;
			$theInitData['application_id'] = $appid;
			$theInitData['name'] = '';
			$theInitData['info'] = '';
			$theInitData['start'] = '';
			$theInitData['end'] = '';
			$theInitData['dev_start'] = '';
			$theInitData['image'] = ''; //？
			$theInitData['status'] = 1;
			$theInitData['event_code'] = '';


			$myEvent = $this->Event->set($theInitData);
		}
//		$this->_renderJson($myApplication);
		$isAdmin = $this->isAdmin();
		$this->Set(compact('title', 'icon','myEvent', 'id', 'appid', 'isAdmin'));
	}

	public function admin_viewEvent($id = 0){
		$title = 'VIEW EVENT';
		$icon = 'fas fa-flag-checkered';

		$myEvent = $this->Event->findById($id);
		$isAdmin = $this->isAdmin();
		$this->Set(compact('title', 'icon','myEvent', 'id', 'isAdmin'));
	}

	public function admin_deleteEvent($id = 0, $appid = 1){
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';
		if($id != 0) {

			$this->Event->delete($id, false);
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
		$this->redirect( '/admin/events/editEvent/'.$id.'/'.$appid.'/' );
	}

	public function admin_duplicateEvent($id = 0, $appid = 1){
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';
		if($id != 0) {

			$row = $this->Event->findById($id);
			$row['Event']['id'] = null;

			$this->Event->create(); // Create a new record
			$res = $this->Event->save($row); // And save it

			$this->Flash->admin_flash(
				__('#' . $id . 'を複製し、'. $res['Event']['id'] .'を新規に作成しました。'),
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
		$this->redirect( '/admin/events/editEvent/'.$id.'/'.$appid.'/' );
	}


	public function admin_uploadfile($id = 0, $appid = 0){ //redirectのための引数

		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

		// mysqlにデータを格納する方法もあるようだが、ここでは単純にファイルアップロードに。
		// http://cakephpクッキング.jp/image-save-db/

		//パラメータよりイメージ情報を取得
//		$image = $this->request->data('upload_file');
		$image = $this->params['form']['upload_file'];

		//イメージ保存先パス
		$img_save_path = IMAGES.'events' ;

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

			$this->Event->save($theData);

			//既存ファイル削除処理
			if($existing_file != ''){
				$deleteMsg = $this->deleteLocalFile('events', $existing_file);
				$msg = $msg.'既存ファイルについては、'.$deleteMsg;
			}

		}else{
			$msg = 'エラーが発生してアップロードできませんでした。';
		}


		$this->Flash->admin_flash(__($msg));

		$this->redirect( '/admin/events/editEvent/'.$id.'/'.$appid.'/');
	}

	public function admin_deletefile($id = 0, $appid = 0){ //redirectのための引数
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

		$target = $this->Event->findById($id);
		$filename = $target['Event']['image'];
		$msg = $this->deleteLocalFile('events', $filename);

		$theData = array();
		$theData['id'] = $id;
		$theData['image'] = null;

		$this->Event->save($theData);

		$this->Flash->admin_flash(__('画像ファイル'.$msg));
		$this->redirect( '/admin/events/editEvent/'.$id.'/'.$appid.'/');
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
