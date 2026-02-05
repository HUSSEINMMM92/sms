<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * attendance_class_id_option_list Model Action
     * @return array
     */
	function attendance_class_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT p.class_id AS value, g.class_name AS label FROM periods p join grade g on p.class_id = g.gra_id WHERE p.teacher_id=?"  ;
		$queryparams = array(USER_NAME);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * attendance_sub_id_option_list Model Action
     * @return array
     */
	function attendance_sub_id_option_list($lookup_class_id){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT p.Sub_ID AS value, s.Sub_name AS label FROM periods p JOIN subjects s ON p.Sub_ID = s.sub_id JOIN grade g ON p.class_id = g.gra_id WHERE p.class_id=? and p.teacher_id=?"     ;
		$queryparams = array($lookup_class_id, USER_NAME);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * attendance_class_id_option_list_2 Model Action
     * @return array
     */
	function attendance_class_id_option_list_2(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT p.class_id AS value, g.class_name AS label FROM periods p join grade g on p.class_id = g.gra_id WHERE p.teacher_id=?"   ;
		$queryparams = array(USER_NAME);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * attendance_sub_id_option_list_2 Model Action
     * @return array
     */
	function attendance_sub_id_option_list_2(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT Sub_ID AS value , sub_Name AS label FROM subjects ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * exam_result_E_id_option_list Model Action
     * @return array
     */
	function exam_result_E_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT EID AS value,exam_name AS label FROM exams WHERE status='active'";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * exam_result_class_id_option_list Model Action
     * @return array
     */
	function exam_result_class_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT p.class_id AS value, g.class_name AS label FROM periods p JOIN grade g ON g.gra_id = p.class_id WHERE p.teacher_id=? ORDER BY p.class_id" ;
		$queryparams = array(USER_NAME);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * exam_result_Sub_ID_option_list Model Action
     * @return array
     */
	function exam_result_Sub_ID_option_list($lookup_class_id){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT p.sub_id AS value, s.sub_name AS label FROM periods p JOIN subjects s ON s.sub_id = p.sub_id WHERE p.teacher_id=? and class_id=? ORDER BY p.class_id"

     ;
		$queryparams = array(USER_NAME, $lookup_class_id);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * exam_result_Std_id_option_list Model Action
     * @return array
     */
	function exam_result_Std_id_option_list($lookup_class_id){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT s.std_id AS value, s.std_name AS label FROM students s JOIN student_academic sa ON s.std_id = sa.std_id WHERE sa.grade_id =? ORDER BY s.std_name" ;
		$queryparams = array($lookup_class_id
);
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * exam_result_Academic_year_id_option_list Model Action
     * @return array
     */
	function exam_result_Academic_year_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,academic_year AS label FROM academic_year WHERE CURDATE() BETWEEN start_date AND end_date";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * exams_Academic_year_id_option_list Model Action
     * @return array
     */
	function exams_Academic_year_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,academic_year AS label FROM academic_year WHERE CURDATE() BETWEEN start_date AND end_date";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * periods_Sub_ID_option_list Model Action
     * @return array
     */
	function periods_Sub_ID_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT Sub_ID AS value , sub_Name AS label FROM subjects ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * periods_class_id_option_list Model Action
     * @return array
     */
	function periods_class_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT gra_id AS value , Class_name AS label FROM grade ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * periods_teacher_id_option_list Model Action
     * @return array
     */
	function periods_teacher_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT Tea_id AS value , Name AS label FROM teachers ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * periods_academic_year_id_option_list Model Action
     * @return array
     */
	function periods_academic_year_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , id AS label FROM academic_year ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * student_academic_std_id_option_list Model Action
     * @return array
     */
	function student_academic_std_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT std_id AS value , std_Name AS label FROM students ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * student_academic_grade_id_option_list Model Action
     * @return array
     */
	function student_academic_grade_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT gra_id AS value , Class_name AS label FROM grade ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * student_academic_academic_year_option_list Model Action
     * @return array
     */
	function student_academic_academic_year_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , id AS label FROM academic_year ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * users_username_value_exist Model Action
     * @return array
     */
	function users_username_value_exist($val){
		$db = $this->GetModel();
		$db->where("username", $val);
		$exist = $db->has("users");
		return $exist;
	}

	/**
     * users_email_value_exist Model Action
     * @return array
     */
	function users_email_value_exist($val){
		$db = $this->GetModel();
		$db->where("email", $val);
		$exist = $db->has("users");
		return $exist;
	}

	/**
     * v_student_exam_result_with_rank_v_student_exam_result_with_rankclass_id_option_list Model Action
     * @return array
     */
	function v_student_exam_result_with_rank_v_student_exam_result_with_rankclass_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT gra_id AS value,Class_name AS label FROM grade";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * v_student_exam_result_with_rank_v_student_exam_result_with_rankSub_ID_option_list Model Action
     * @return array
     */
	function v_student_exam_result_with_rank_v_student_exam_result_with_rankSub_ID_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT Sub_ID AS value,sub_Name AS label FROM subjects";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

}
