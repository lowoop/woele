<?php

class UploadController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array ('accessControl');  // perform access control for CRUD operations
				
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array (
			array (
					'allow',
					//'actions' => array ('*'),
					'roles' => array ('admin','shop') 
			),
			array (
					'deny', // deny all users
					'users' => array ('*')
			) 
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		/*
		 // Support CORS
		header("Access-Control-Allow-Origin: *");
		// other CORS headers if any...
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		exit; // finish preflight CORS requests here
		}
		*/
		
		// 5 minutes execution time
		@set_time_limit(5 * 60);
		
		// Uncomment this one to fake upload time
		// usleep(5000);
		
		// Settings
		$extdir = strtotime(date("Y-m-d"));
		$targetDir = WW_ROOT."/img/upload" . DIRECTORY_SEPARATOR . $extdir;
		//$targetDir = 'uploads';
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds
		
		
		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}
		
		// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}
		$file_path = pathinfo($fileName); 
		$fileName = md5(time().rand(100, 999)).".".$file_path ['extension'];
		
		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		$url = $extdir."/".$fileName;
		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
		
		// Remove old temp files
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0","status":"error", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}
		
			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
		
				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}.part") {
					continue;
				}
		
				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}
		
		
		// Open temp file
		if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
			die('{"jsonrpc" : "2.0","status":"error", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}
		
		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0","status":"error", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}
		
			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0","status":"error", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0","status":"error", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}
		
		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}
		
		@fclose($out);
		@fclose($in);
		
		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off
			rename("{$filePath}.part", $filePath);
		}
		
		// Return Success JSON-RPC response
		die('{"status":"success","url":"'.$url.'"}');
	}
	
	public function actionAd()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	
		/*
		 // Support CORS
		header("Access-Control-Allow-Origin: *");
		// other CORS headers if any...
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		exit; // finish preflight CORS requests here
		}
		*/
	
		// 5 minutes execution time
		@set_time_limit(5 * 60);
	
		// Uncomment this one to fake upload time
		// usleep(5000);
	
		// Settings
		$extdir = strtotime(date("Y-m-d"));
		$targetDir = WW_ROOT."/img/ad";
		//$targetDir = 'uploads';
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds
	
	
		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}
	
		// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}
		$file_path = pathinfo($fileName);
		$fileName = md5(time().rand(100, 999)).".".$file_path ['extension'];
	
		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		$url = $fileName;
		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
	
		// Remove old temp files
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0","status":"error", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}
	
			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
	
				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}.part") {
					continue;
				}
	
				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}
	
	
		// Open temp file
		if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
			die('{"jsonrpc" : "2.0","status":"error", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}
	
		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0","status":"error", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}
	
			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0","status":"error", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0","status":"error", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}
	
		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}
	
		@fclose($out);
		@fclose($in);
	
		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off
			rename("{$filePath}.part", $filePath);
		}
	
		// Return Success JSON-RPC response
		die('{"status":"success","url":"'.$url.'"}');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
