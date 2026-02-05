<?php 
/**
 * V_student_exam_results Page Controller
 * @category  Controller
 */
class V_student_exam_resultsController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "v_student_exam_results";
	}
}
