<?php
/**
 * JController is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 *
 */
class BController extends Controller {
    
    public $layout = "main";
    public $breadcrumbs=array();

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
    					'roles' => array ('admin')
    			),
    			array (
    					'deny', // deny all users
    					'users' => array ('*')
    			)
    	);
    }
    /**
     * @param string $id
     * @param string $module
     */
    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    protected function beforeAction($action) {
		parent::beforeAction($action);
        return true;
    }
    
    public function update_config($new_config, $config_file = '') 
	{
		if(!is_file($config_file))
		{
			$fp = fopen($config_file,"w+");
			fwrite($fp, "<?php \nreturn array();");
			fclose($fp);
		}
		if (is_writable($config_file)) 
		{
			$config = require $config_file;
			$config = array_merge($config, $new_config);
			file_put_contents($config_file, "<?php \nreturn " . stripslashes(var_export($config, true)) . ";", LOCK_EX);
			@unlink(RUNTIME_FILE);
			return true;
		} 
		else 
		{
			return false;
		}
	}

}