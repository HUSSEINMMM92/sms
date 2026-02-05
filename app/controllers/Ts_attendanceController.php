<?php 
/**
 * Ts_attendance Page Controller
 * @category  Controller
 */
class Ts_attendanceController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "ts_attendance";
	}
// No Edit Function Generated Because No Field is Defined as the Primary Key
}
