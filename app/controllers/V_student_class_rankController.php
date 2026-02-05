<?php 
/**
 * V_student_class_rank Page Controller
 * @category  Controller
 */
class V_student_class_rankController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "v_student_class_rank";
	}
}
