<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	public $source;
	private $_id;
	
	public function __construct($username,$password,$source="")
	{
		$this->source=$source;
		$this->username=$username;
		$this->password=$password;
	}
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{

		$user=User::model()->find('(LOWER(username)=:username or LOWER(mobile)=:username or LOWER(email)=:username) and source=:source and status=1',array('username'=>strtolower($this->username),'source'=>$this->source)); 
		 if($user===null)  
            $this->errorCode=self::ERROR_USERNAME_INVALID;  
        else if($this->source==="" && !$user->validatePassword($this->password))  
            $this->errorCode=self::ERROR_PASSWORD_INVALID;  
        else  
        {  
            $this->_id=$user->id;  
            $this->username=$user->username; 
            $this->setState('role', $user->role);
            $this->errorCode=self::ERROR_NONE;  
        }
        return $this->errorCode==self::ERROR_NONE; 
	}
	
	public function getId()
    {
        return $this->_id;
    }
}