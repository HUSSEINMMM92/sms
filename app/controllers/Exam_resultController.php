<?php 
/**
 * Exam_result Page Controller
 * @category  Controller
 */
class Exam_resultController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "exam_result";
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
		$fields = array("ER_id", 
			"Sub_ID", 
			"E_id", 
			"class_id", 
			"Std_id", 
			"marks", 
			"teacher_id", 
			"Academic_year_id");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				exam_result.ER_id LIKE ? OR 
				exam_result.Sub_ID LIKE ? OR 
				exam_result.E_id LIKE ? OR 
				exam_result.class_id LIKE ? OR 
				exam_result.Std_id LIKE ? OR 
				exam_result.marks LIKE ? OR 
				exam_result.teacher_id LIKE ? OR 
				exam_result.Academic_year_id LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "exam_result/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("exam_result.ER_id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Exam Result";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("exam_result/list.php", $data); //render the full page
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
			$fields = $this->fields = array("Sub_ID","E_id","class_id","Std_id","marks","teacher_id","Academic_year_id");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'Sub_ID' => 'required',
				'E_id' => 'required',
				'class_id' => 'required',
				'Std_id' => 'required',
				'marks' => 'required|numeric',
				'teacher_id' => 'required',
				'Academic_year_id' => 'required|numeric',
			);
			$this->sanitize_array = array(
				'Sub_ID' => 'sanitize_string',
				'E_id' => 'sanitize_string',
				'class_id' => 'sanitize_string',
				'Std_id' => 'sanitize_string',
				'marks' => 'sanitize_string',
				'teacher_id' => 'sanitize_string',
				'Academic_year_id' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("exam_result");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Exam Result";
		$this->render_view("exam_result/add.php");
	}
// No Edit Function Generated Because No Field is Defined as the Primary Key
// No Delete Function Generated Because No Field is Defined as the Primary Key on the Database Table/View
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function teacher_exam_result_entry($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("E_id","class_id","Sub_ID","Std_id","marks","teacher_id","Academic_year_id");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'E_id' => 'required',
				'class_id' => 'required',
				'Sub_ID' => 'required',
				'Std_id' => 'required',
				'marks' => 'required|numeric',
				'Academic_year_id' => 'required',
			);
			$this->sanitize_array = array(
				'E_id' => 'sanitize_string',
				'class_id' => 'sanitize_string',
				'Sub_ID' => 'sanitize_string',
				'Std_id' => 'sanitize_string',
				'marks' => 'sanitize_string',
				'Academic_year_id' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$modeldata['teacher_id'] = USER_NAME;
			if($this->validated()){
		# Statement to execute before adding record
		        $db->where("EID", $modeldata['E_id']);
        $marks = $db->getValue("exams", "max_marks");
        if ($modeldata['marks'] < 0) {
        set_flash_msg("Exam marks can't be lower then 0", "danger");
            return redirect_to_action("list");
        } elseif($modeldata['marks'] > $marks ) {
        set_flash_msg("Exam marks can't be great then given limit", "danger");
            return redirect_to_action("list");
            }   else{
                }
		# End of before add statement
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("exam_result/teacher_exam_result_entry");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Exam Result";
		$this->render_view("exam_result/teacher_exam_result_entry.php");
	}
}
