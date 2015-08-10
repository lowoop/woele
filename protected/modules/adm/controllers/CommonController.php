<?php

class CommonController extends BController
{
	public function actionIndex()
	{
		$config_file = WW_ROOT."/protected/config/common.php";
		$mail_file = WW_ROOT."/protected/config/mail.php";
		if(isset($_POST['fee']))
		{
			$fee = $_POST['fee'];
			$first_discount = $_POST['first_discount'];
			$this->update_config(array('fee'=>$fee,'first_discount'=>$first_discount),$config_file);
		}
        if(isset($_POST['notice']))
        {
            $notice = $_POST['notice'];
            $this->update_config(array('notice'=>$notice),$config_file);
        }
		if(isset($_POST['username']))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$host = $_POST['host'];
			$port = $_POST['port'];
			$nickname = $_POST['nickname'];
			$receiver = $_POST['receiver'];
			$this->update_config(array(
					'username'=>$username,
					'password'=>$password,
					'host'=>$host,
					'port'=>$port,
					'nickname'=>$nickname,
					'receiver'=>$receiver,
			),$mail_file);
		}
		if(isset($_POST['adconfig']))
		{
			$adimg = array_key_exists("adimg", $_POST)?$_POST['adimg']:array();
			$adlink = array_key_exists("adlink", $_POST)?$_POST['adlink']:array();
			$arr_ad = array();
			$len = count($adimg);
			for($i=0;$i<$len;$i++)
			{
				if($adimg[$i]=="")
					continue;
				$arr_ad[$adimg[$i]] = $adlink[$i];
			}
			$this->update_config(array('ad'=>$arr_ad),$config_file);
		}
		if(file_exists($config_file))
		{
			$config = require $config_file;
		}
		else 
		{
			$config = array();
		}
		if(file_exists($mail_file))
		{
			$mail = require $mail_file;
		}
		else
		{
			$mail = array();
		}
		
		$this->render('index',array('config'=>$config,'mail'=>$mail));
	}
	public function actionMailtest()
	{
		$send = Jmail::sendTest($_POST);
		if($send == "success")
		{
			echo json_encode(array('status'=>'success'));
		}
		else
		{
			echo json_encode(array('status'=>'failed'));
		}
	}
}
