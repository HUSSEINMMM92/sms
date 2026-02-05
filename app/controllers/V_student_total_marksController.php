<?php 
/**
 * V_student_total_marks Page Controller
 * @category  Controller
 */
class V_student_total_marksController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "v_student_total_marks";
	}
}
