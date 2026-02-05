<?php
/**
 * Page Access Control
 * @category  RBAC Helper
 */
defined('ROOT') or exit('No direct script access allowed');
class ACL
{
	

	/**
	 * Array of user roles and page access 
	 * Use "*" to grant all access right to particular user role
	 * @var array
	 */
	public static $role_pages = array(
			'admin' =>
						array(
							'academic_year' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'attendance' => array('list','view','add','edit', 'editfield','delete','import_data','teacher_add_attendance','edit_test','test_add_attendance'),
							'exam_result' => array('list','view','add','edit', 'editfield','delete','import_data','teacher_exam_result_entry'),
							'exams' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'grade' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'periods' => array('list','view','add','edit', 'editfield','delete','import_data','student_time_table','teacher_time_table'),
							'student_academic' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'students' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'subjects' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'teachers' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'ts_attendance' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'ts_exam_result' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'ts_exams' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'ts_grade' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'ts_students' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'ts_subject' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'ts_teachers' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'ts_time_table' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'ts_users' => array('list','view','add','edit', 'editfield','delete','import_data'),
							'users' => array('list','view','add','edit', 'editfield','delete','import_data','userregister','accountedit','accountview'),
							'v_student_exam_result_with_rank' => array('list','view','teacher_exam_result_view','temp2','student_exams_result','temp_'),
							'v_student_total_marks' => array('list','view'),
							'mytest' => array('list','view')
						),
		
			'student' =>
						array(
							'attendance' => array('teacher_add_attendance','edit_test','test_add_attendance'),
							'periods' => array('student_time_table'),
							'v_student_exam_result_with_rank' => array('student_exams_result')
						),
		
			'teacher' =>
						array(
							'attendance' => array('list','edit', 'editfield','teacher_add_attendance','edit_test','test_add_attendance'),
							'exam_result' => array('list','teacher_exam_result_entry'),
							'periods' => array('teacher_time_table'),
							'v_student_exam_result_with_rank' => array('teacher_exam_result_view','temp2','student_exams_result','temp_')
						)
		);

	/**
	 * Current user role name
	 * @var string
	 */
	public static $user_role = null;

	/**
	 * pages to Exclude From Access Validation Check
	 * @var array
	 */
	public static $exclude_page_check = array("", "index", "home", "account", "info", "masterdetail");

	/**
	 * Init page properties
	 */
	public function __construct()
	{	
		if(!empty(USER_ROLE)){
			self::$user_role = USER_ROLE;
		}
	}

	/**
	 * Check page path against user role permissions
	 * if user has access return AUTHORIZED
	 * if user has NO access return UNAUTHORIZED
	 * if user has NO role return NO_ROLE
	 * @return string
	 */
	public static function GetPageAccess($path)
	{
		$rp = self::$role_pages;
		if ($rp == "*") {
			return AUTHORIZED; // Grant access to any user
		} else {
			$path = strtolower(trim($path, '/'));

			$arr_path = explode("/", $path);
			$page = strtolower($arr_path[0]);

			//If user is accessing excluded access contrl pages
			if (in_array($page, self::$exclude_page_check)) {
				return AUTHORIZED;
			}

			$user_role = strtolower(USER_ROLE); // Get user defined role from session value
			if (array_key_exists($user_role, $rp)) {
				$action = (!empty($arr_path[1]) ? $arr_path[1] : "list");
				if ($action == "index") {
					$action = "list";
				}
				//Check if user have access to all pages or user have access to all page actions
				if ($rp[$user_role] == "*" || (!empty($rp[$user_role][$page]) && $rp[$user_role][$page] == "*")) {
					return AUTHORIZED;
				} else {
					if (!empty($rp[$user_role][$page]) && in_array($action, $rp[$user_role][$page])) {
						return AUTHORIZED;
					}
				}
				return FORBIDDEN;
			} else {
				//User does not have any role.
				return NOROLE;
			}
		}
	}

	/**
	 * Check if user role has access to a page
	 * @return Bool
	 */
	public static function is_allowed($path)
	{
		return (self::GetPageAccess($path) == AUTHORIZED);
	}

}
