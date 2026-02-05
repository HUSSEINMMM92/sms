<?php 
/**
 * Periods Page Controller
 * @category  Controller
 */
class PeriodsController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "periods";
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
		$fields = array("periods.PID", 
			"periods.Sub_ID", 
			"subjects.sub_Name AS subjects_sub_Name", 
			"periods.class_id", 
			"grade.Class_name AS grade_Class_name", 
			"periods.teacher_id", 
			"teachers.Name AS teachers_Name", 
			"periods.Day", 
			"periods.Time", 
			"periods.room", 
			"periods.Duration", 
			"periods.academic_year_id", 
			"academic_year.academic_year AS academic_year_academic_year");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				periods.PID LIKE ? OR 
				periods.Sub_ID LIKE ? OR 
				periods.class_id LIKE ? OR 
				periods.teacher_id LIKE ? OR 
				periods.Day LIKE ? OR 
				periods.Time LIKE ? OR 
				periods.room LIKE ? OR 
				periods.Duration LIKE ? OR 
				periods.academic_year_id LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "periods/search.php";
		}
		$db->join("subjects", "periods.Sub_ID = subjects.Sub_ID", "INNER");
		$db->join("grade", "periods.class_id = grade.gra_id", "INNER");
		$db->join("teachers", "periods.teacher_id = teachers.Tea_id", "INNER");
		$db->join("academic_year", "periods.academic_year_id = academic_year.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("periods.PID", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Periods";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("periods/list.php", $data); //render the full page
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
			$fields = $this->fields = array("PID","Sub_ID","class_id","teacher_id","Day","Time","room","Duration","academic_year_id");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'PID' => 'required',
				'Sub_ID' => 'required',
				'class_id' => 'required',
				'teacher_id' => 'required',
				'Day' => 'required',
				'Time' => 'required',
				'room' => 'required',
				'Duration' => 'required',
				'academic_year_id' => 'required',
			);
			$this->sanitize_array = array(
				'PID' => 'sanitize_string',
				'Sub_ID' => 'sanitize_string',
				'class_id' => 'sanitize_string',
				'teacher_id' => 'sanitize_string',
				'Day' => 'sanitize_string',
				'Time' => 'sanitize_string',
				'room' => 'sanitize_string',
				'Duration' => 'sanitize_string',
				'academic_year_id' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("periods");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Periods";
		$this->render_view("periods/add.php");
	}
// No Edit Function Generated Because No Field is Defined as the Primary Key
// No Delete Function Generated Because No Field is Defined as the Primary Key on the Database Table/View
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function student_time_table($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("periods.PID", 
			"periods.Sub_ID", 
			"subjects.sub_Name AS subjects_sub_Name", 
			"periods.class_id", 
			"grade.Class_name AS grade_Class_name", 
			"periods.teacher_id", 
			"teachers.Name AS teachers_Name", 
			"periods.Day", 
			"periods.Time", 
			"periods.room", 
			"periods.Duration", 
			"periods.academic_year_id", 
			"student_academic.std_id AS student_academic_std_id");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				periods.Day LIKE ? OR 
				periods.room LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "periods/search.php";
		}
		$db->join("subjects", "periods.Sub_ID = subjects.Sub_ID", "INNER");
		$db->join("grade", "periods.class_id = grade.gra_id", "INNER");
		$db->join("teachers", "periods.teacher_id = teachers.Tea_id", "INNER");
		$db->join("student_academic", "periods.class_id = student_academic.grade_id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("periods.PID", ORDER_TYPE);
		}
		$db->where("student_academic.std_id='".USER_NAME."'");
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
		$page_title = $this->view->page_title = "Periods";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("periods/student_time_table.php", $data); //render the full page
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function teacher_time_table($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("periods.PID", 
			"periods.Sub_ID", 
			"subjects.sub_Name AS subjects_sub_Name", 
			"periods.class_id", 
			"grade.Class_name AS grade_Class_name", 
			"periods.teacher_id", 
			"teachers.Name AS teachers_Name", 
			"periods.Day", 
			"periods.Time", 
			"periods.room", 
			"periods.Duration", 
			"periods.academic_year_id", 
			"academic_year.academic_year AS academic_year_academic_year");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				periods.PID LIKE ? OR 
				periods.Sub_ID LIKE ? OR 
				periods.class_id LIKE ? OR 
				periods.teacher_id LIKE ? OR 
				periods.Day LIKE ? OR 
				periods.Time LIKE ? OR 
				periods.room LIKE ? OR 
				periods.Duration LIKE ? OR 
				periods.academic_year_id LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "periods/search.php";
		}
		$db->join("subjects", "periods.Sub_ID = subjects.Sub_ID", "INNER");
		$db->join("grade", "periods.class_id = grade.gra_id", "INNER");
		$db->join("teachers", "periods.teacher_id = teachers.Tea_id", "INNER");
		$db->join("academic_year", "periods.academic_year_id = academic_year.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("periods.PID", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Periods";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("periods/teacher_time_table.php", $data); //render the full page
	}
}
