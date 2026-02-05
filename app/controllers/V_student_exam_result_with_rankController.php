<?php 
/**
 * V_student_exam_result_with_rank Page Controller
 * @category  Controller
 */
class V_student_exam_result_with_rankController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "v_student_exam_result_with_rank";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("Std_id", 
			"std_Name", 
			"class_id", 
			"Class_name", 
			"Sub_ID", 
			"sub_Name", 
			"teacher_id", 
			"Academic_year_id", 
			"month1", 
			"midterm", 
			"month2", 
			"final", 
			"total_marks", 
			"class_rank", 
			"academic_year");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				v_student_exam_result_with_rank.Std_id LIKE ? OR 
				v_student_exam_result_with_rank.std_Name LIKE ? OR 
				v_student_exam_result_with_rank.class_id LIKE ? OR 
				v_student_exam_result_with_rank.Class_name LIKE ? OR 
				v_student_exam_result_with_rank.Sub_ID LIKE ? OR 
				v_student_exam_result_with_rank.sub_Name LIKE ? OR 
				v_student_exam_result_with_rank.teacher_id LIKE ? OR 
				v_student_exam_result_with_rank.Academic_year_id LIKE ? OR 
				v_student_exam_result_with_rank.month1 LIKE ? OR 
				v_student_exam_result_with_rank.midterm LIKE ? OR 
				v_student_exam_result_with_rank.month2 LIKE ? OR 
				v_student_exam_result_with_rank.final LIKE ? OR 
				v_student_exam_result_with_rank.total_marks LIKE ? OR 
				v_student_exam_result_with_rank.class_rank LIKE ? OR 
				v_student_exam_result_with_rank.academic_year LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "v_student_exam_result_with_rank/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("v_student_exam_result_with_rank.Std_id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "V Student Exam Result With Rank";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("v_student_exam_result_with_rank/list.php", $data); //render the full page
	}
// No View Function Generated Because No Field is Defined as the Primary Key on the Database Table
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function teacher_exam_result_view($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("Std_id", 
			"std_Name", 
			"Class_name", 
			"sub_Name", 
			"month1", 
			"midterm", 
			"month2", 
			"final", 
			"month1 + midterm + month2 + final AS Total", 
			"total_marks", 
			"class_rank", 
			"Academic_year_id", 
			"teacher_id", 
			"academic_year");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				v_student_exam_result_with_rank.academic_year LIKE ?
			)";
			$search_params = array(
				"%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "v_student_exam_result_with_rank/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("v_student_exam_result_with_rank.Std_id", ORDER_TYPE);
		}
		$db->where("teacher_id='".USER_NAME."'");
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		if(!empty($request->v_student_exam_result_with_rank_class_id)){
			$val = $request->v_student_exam_result_with_rank_class_id;
			$db->where("v_student_exam_result_with_rank.class_id", $val , "=");
		}
		if(!empty($request->v_student_exam_result_with_rank_Sub_ID)){
			$val = $request->v_student_exam_result_with_rank_Sub_ID;
			$db->where("v_student_exam_result_with_rank.Sub_ID", $val , "=");
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "V Student Exam Result With Rank";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("v_student_exam_result_with_rank/teacher_exam_result_view.php", $data); //render the full page
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function temp_($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("std_Name", 
			"Class_name", 
			"class_rank", 
			"total_marks", 
			"teacher_id", 
			"Academic_year_id", 
			"sub_Name", 
			"month1", 
			"midterm", 
			"month2", 
			"final", 
			"Month1 + midterm + month2 + final AS Total", 
			"Std_id", 
			"academic_year");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				v_student_exam_result_with_rank.academic_year LIKE ?
			)";
			$search_params = array(
				"%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "v_student_exam_result_with_rank/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("v_student_exam_result_with_rank.Std_id", ORDER_TYPE);
		}
		$db->where("std_id='".USER_NAME."'");
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "V Student Exam Result With Rank";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("v_student_exam_result_with_rank/temp_.php", $data); //render the full page
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function temp2($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("std_Name", 
			"Class_name", 
			"class_rank", 
			"total_marks", 
			"teacher_id", 
			"Academic_year_id", 
			"sub_Name", 
			"month1", 
			"midterm", 
			"month2", 
			"final", 
			"Month1 + midterm + month2 + final AS Total", 
			"academic_year");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				v_student_exam_result_with_rank.academic_year LIKE ?
			)";
			$search_params = array(
				"%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "v_student_exam_result_with_rank/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("v_student_exam_result_with_rank.Std_id", ORDER_TYPE);
		}
		$db->where("std_id='".USER_NAME."'");
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "V Student Exam Result With Rank";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("v_student_exam_result_with_rank/temp2.php", $data); //render the full page
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function student_exams_result($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("std_Name", 
			"Class_name", 
			"class_rank", 
			"total_marks", 
			"teacher_id", 
			"Academic_year_id", 
			"sub_Name", 
			"month1", 
			"midterm", 
			"month2", 
			"final", 
			"Month1 + midterm + month2 + final AS Total", 
			"class_id", 
			"academic_year");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				v_student_exam_result_with_rank.academic_year LIKE ?
			)";
			$search_params = array(
				"%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "v_student_exam_result_with_rank/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("v_student_exam_result_with_rank.Std_id", ORDER_TYPE);
		}
		$db->where("std_id='".USER_NAME."'");
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "V Student Exam Result With Rank";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("v_student_exam_result_with_rank/student_exams_result.php", $data); //render the full page
	}
}
