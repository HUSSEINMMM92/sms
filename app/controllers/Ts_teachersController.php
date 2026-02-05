<?php 
/**
 * Ts_teachers Page Controller
 * @category  Controller
 */
class Ts_teachersController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "ts_teachers";
	}
// No Edit Function Generated Because No Field is Defined as the Primary Key
}
