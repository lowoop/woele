<?php

class TestController extends Controller
{
	public $layout='/';
	public function actions()
	{
		return array(
				// captcha action renders the CAPTCHA image displayed on the contact page
				'captcha'=>array(
						'class'=>'CCaptchaAction',
						'backColor'=>0xFFFFFF,
//						'fixedVerifyCode' => substr(md5(microtime()),11,4),
						'testLimit'=>999,
				),
		);
	}

	public function actionIndex()
	{
// 		$mail=Yii::app()->Smtpmail;
// 		$mail->SetFrom($mail->Username, 'From NAme');
// 		$mail->Subject    = "aaaaa";
// 		$mail->MsgHTML("flsadjflsadjfljsadlfjl");
// 		$mail->AddAddress("gdt@qq.com", "aaa");
// 		$mail->AddAddress("lowoop@126.com", "bbb");
// 		if(!$mail->Send()) {
// 			echo "Mailer Error: " . $mail->ErrorInfo;
// 		}else {
// 			echo "Message sent!";
// 		}
		$this->render("index");
	}
    public function actionIndexa()
    {
// 		$mail=Yii::app()->Smtpmail;
// 		$mail->SetFrom($mail->Username, 'From NAme');
// 		$mail->Subject    = "aaaaa";
// 		$mail->MsgHTML("flsadjflsadjfljsadlfjl");
// 		$mail->AddAddress("gdt@qq.com", "aaa");
// 		$mail->AddAddress("lowoop@126.com", "bbb");
// 		if(!$mail->Send()) {
// 			echo "Mailer Error: " . $mail->ErrorInfo;
// 		}else {
// 			echo "Message sent!";
// 		}
        $this->render("index");
    }
	public function actionVerify()
	{
		$code = Yii::app()->request->getParam("code");
		$model = new Code();
		$model->verifyCode = $code;
		if($model->validate())
		{
			echo json_encode(array('msg'=>'success'));
		}
		else
		{
			echo json_encode(array('msg'=>'failed'));
		}
	}
	
	
}