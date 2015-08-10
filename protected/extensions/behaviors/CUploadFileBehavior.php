<?php
/**
 * CTimestampBehavior class file.
 *
 * @author Tang Yi <yitang@sohu-inc.com>
 */

/**
 * CUploadFileBehavior extends the upload behaviors provided by CUploadFile class.
 *
 * @author Tang Yi <yitang@sohu-inc.com>
 * @since 1.0
 */

class CUploadFileBehavior extends CBehavior
{
	/**
	 * Saves the uploaded file to sohu scs server.
	 * @param string $file the file path used to save the uploaded file
	 * @return boolean true whether the file is saved successfully
	 */
	public function saveToScs($file)
	{
		if($this->owner->getError()==UPLOAD_ERR_OK)
		{
			$tempfile = $this->owner->getTempName();
			$res = Yii::app()->itc->upload_file($file, $tempfile);
			return $res['status'] == 1 ? true : false;
		}
		return false;
	}
}