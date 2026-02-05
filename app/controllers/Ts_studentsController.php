<?php 
/**
 * Ts_students Page Controller
 * @category  Controller
 */
class Ts_studentsController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "ts_students";
	}
// No Edit Function Generated Because No Field is Defined as the Primary Key
}
