<?php 
/**
 * Ts_users Page Controller
 * @category  Controller
 */
class Ts_usersController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "ts_users";
	}
// No Edit Function Generated Because No Field is Defined as the Primary Key
}
