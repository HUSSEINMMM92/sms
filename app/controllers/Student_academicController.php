<?php 
/**
 * Student_academic Page Controller
 * @category  Controller
 */
class Student_academicController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "student_academic";
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
		$fields = array("student_academic.SA_ID", 
			"student_academic.std_id", 
			"students.std_Name AS students_std_Name", 
			"student_academic.grade_id", 
			"grade.Class_name AS grade_Class_name", 
			"student_academic.academic_year", 
			"academic_year.academic_year AS academic_year_academic_year");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				student_academic.SA_ID LIKE ? OR 
				student_academic.std_id LIKE ? OR 
				student_academic.grade_id LIKE ? OR 
				student_academic.academic_year LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "student_academic/search.php";
		}
		$db->join("students", "student_academic.std_id = students.std_id", "INNER");
		$db->join("grade", "student_academic.grade_id = grade.gra_id", "INNER");
		$db->join("academic_year", "student_academic.academic_year = academic_year.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("student_academic.SA_ID", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Student Academic";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("student_academic/list.php", $data); //render the full page
	}
// No View Function Generated Because No Field is Defined as the Primary Key on the Database Table
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("std_id","grade_id","academic_year");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'std_id' => 'required',
				'grade_id' => 'required',
				'academic_year' => 'required',
			);
			$this->sanitize_array = array(
				'std_id' => 'sanitize_string',
				'grade_id' => 'sanitize_string',
				'academic_year' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("student_academic");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Student Academic";
		$this->render_view("student_academic/add.php");
	}
// No Edit Function Generated Because No Field is Defined as the Primary Key
// No Delete Function Generated Because No Field is Defined as the Primary Key on the Database Table/View
}
