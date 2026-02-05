<?php 
/**
 * Attendance Page Controller
 * @category  Controller
 */
class AttendanceController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "attendance";
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
		$fields = array("attendance.ATID", 
			"attendance.std_id", 
			"students.std_Name AS students_std_Name", 
			"attendance.class_id", 
			"attendance.sub_id", 
			"subjects.sub_Name AS subjects_sub_Name", 
			"attendance.date", 
			"attendance.Status", 
			"attendance.market_by", 
			"attendance.created_at", 
			"attendance.is_locked");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				attendance.ATID LIKE ? OR 
				attendance.std_id LIKE ? OR 
				attendance.class_id LIKE ? OR 
				attendance.sub_id LIKE ? OR 
				attendance.date LIKE ? OR 
				attendance.Status LIKE ? OR 
				attendance.market_by LIKE ? OR 
				attendance.created_at LIKE ? OR 
				attendance.is_locked LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "attendance/search.php";
		}
		$db->join("students", "attendance.std_id = students.std_id", "INNER");
		$db->join("subjects", "attendance.sub_id = subjects.Sub_ID", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("attendance.ATID", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Attendance";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("attendance/list.php", $data); //render the full page
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
			$fields = $this->fields = array("ATID","std_id","class_id","sub_id","date","Status","market_by","is_locked");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'ATID' => 'required',
				'std_id' => 'required',
				'class_id' => 'required|numeric',
				'sub_id' => 'required|numeric',
				'date' => 'required|numeric',
				'Status' => 'required',
				'market_by' => 'required',
				'is_locked' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'ATID' => 'sanitize_string',
				'std_id' => 'sanitize_string',
				'class_id' => 'sanitize_string',
				'sub_id' => 'sanitize_string',
				'date' => 'sanitize_string',
				'Status' => 'sanitize_string',
				'market_by' => 'sanitize_string',
				'is_locked' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("attendance");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Attendance";
		$this->render_view("attendance/add.php");
	}
// No Edit Function Generated Because No Field is Defined as the Primary Key
// No Delete Function Generated Because No Field is Defined as the Primary Key on the Database Table/View
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function teacher_add_attendance($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("class_id","sub_id","market_by");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'class_id' => 'required',
				'sub_id' => 'required',
			);
			$this->sanitize_array = array(
				'class_id' => 'sanitize_string',
				'sub_id' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
		# Statement to execute before adding record
		//$fields = array('std_id','grade_id');
$test = $modeldata['marked_by'];
$db->where("grade_id", $modeldata['class_id']); // or class_id
$students = $db->get("student_academic", null, array('std_id','grade_id'));
if (empty($students)) {
    set_flash_msg("No students found for this class", "danger");
    return redirect_to_action("list");
}
 else {
     foreach ($students as $row) {
    $data = array(
        "std_id"           => $row['std_id'],
        "class_id"         => $row['grade_id'],
        "sub_id"         => $test,
        "date"  => date("Y-m-d"),
        "status"           => "present"
    );
    $db->insert("attendance", $data);
}
     set_flash_msg("Students inserted successfully", "success");
    return redirect_to_action("list");
}
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("attendance");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Attendance";
		$this->render_view("attendance/teacher_add_attendance.php");
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function edit_test($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("attendance.ATID", 
			"attendance.std_id", 
			"students.std_Name AS students_std_Name", 
			"attendance.class_id", 
			"attendance.sub_id", 
			"attendance.date", 
			"attendance.Status", 
			"attendance.market_by", 
			"attendance.created_at", 
			"attendance.is_locked");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				attendance.ATID LIKE ? OR 
				attendance.std_id LIKE ? OR 
				attendance.class_id LIKE ? OR 
				attendance.sub_id LIKE ? OR 
				attendance.date LIKE ? OR 
				attendance.Status LIKE ? OR 
				attendance.market_by LIKE ? OR 
				attendance.created_at LIKE ? OR 
				attendance.is_locked LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "attendance/search.php";
		}
		$db->join("students", "attendance.std_id = students.std_id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("attendance.ATID", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Attendance";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("attendance/edit_test.php", $data); //render the full page
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function test_add_attendance($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("class_id","sub_id","market_by");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'class_id' => 'required',
				'sub_id' => 'required',
			);
			$this->sanitize_array = array(
				'class_id' => 'sanitize_string',
				'sub_id' => 'sanitize_string',
				'market_by' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
		# Statement to execute before adding record
		$market_by = USER_NAME; // or USER_ID (better)
$sub_id    = $modeldata['sub_id'];
$class_id  = $modeldata['class_id'];
$db->where("grade_id", $class_id);
$students = $db->get("student_academic", null, ['std_id','grade_id']);
if (empty($students)) {
    set_flash_msg("No students found for this class", "danger");
    return redirect_to_action("list");
}
$inserted = false; // track if any row is inserted
foreach ($students as $row) {
    // ✅ check if attendance already exists
    $db->where("std_id", $row['std_id']);
    $db->where("class_id", $class_id);
    $db->where("sub_id", $sub_id);
    $db->where("date", date("Y-m-d"));
    $exists = $db->getOne("attendance");
    if ($exists) {
        continue; // skip this student
    }
    $data = array(
        "std_id"     => $row['std_id'],
        "class_id"   => $class_id,
        "sub_id"     => $sub_id,
        "date"       => date("Y-m-d"),
        "status"     => "Absent",
        "market_by"  => $market_by
    );
    $db->insert("attendance", $data);
    $inserted = true;
}
// ✅ final message
if (!$inserted) {
    set_flash_msg("Attendance already exists for today", "danger");
} else {
    set_flash_msg("Attendance created successfully", "success");
}
return redirect_to_action("list");
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("attendance");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Attendance";
		$this->render_view("attendance/test_add_attendance.php");
	}
}
