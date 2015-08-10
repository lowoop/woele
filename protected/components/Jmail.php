<?php
class Jmail
{
	public static function sendMail($to,$subject,$content)
	{
		$mail=Yii::app()->Smtpmail;
		$mail->Host = JConfig::item("mail.host");
		$mail->Username = JConfig::item("mail.username");
		$mail->Password = JConfig::item("mail.password");
		$mail->Port = JConfig::item("mail.port");
		$mail->SetFrom($mail->Username, JConfig::item("mail.nickname"));
		$mail->Subject    = $subject;
		$mail->MsgHTML($content);
		$mail->ClearAddresses();
		$mail->AddAddress($to);
		if(!$mail->Send()) {
			return  "Mailer Error: " . $mail->ErrorInfo;
		}else {
			return  "success";
		}
	}
	public static function sendTest($config)
	{
		$mail=Yii::app()->Smtpmail;
		$mail->Host = $config['host'];
		$mail->Username = $config['username'];
		$mail->Password = $config['password'];
		$mail->Port = $config['port'];
		$mail->SetFrom($mail->Username, $config['nickname']);
		$mail->Subject    = "mail test";
		$mail->MsgHTML("Hello! It's a test mail!");
		$mail->ClearAddresses();
		$mail->AddAddress($config['receiver']);
		if(!$mail->Send()) {
			return  "Mailer Error: " . $mail->ErrorInfo;
		}else {
			return  "success";
		}
	}
}