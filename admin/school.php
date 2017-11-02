
<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/8/4 0004
 * Time: 20:49
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();
$action = crequest("action");
$action = $action == '' ? 'list' : $action;

switch ($action)
{
	case "list":
		school_list();
		break;
	case "add_school":
		add_school();
		break;
	case "do_add_school":
		do_add_school();
		break;
	case "mod_school":
		mod_school();
		break;
	case "do_mod_school":
		do_mod_school();
		break;
	case "del_school":
		del_school();
		break;
	case "del_sel_school":
		del_sel_school();
		break;
	case "upload_batch_photo";
		upload_batch_photo();
		break;
	case "region";
		region();
		break;
}

/*------------------------------------------------------ */
//-- 案例列表
/*------------------------------------------------------ */
function school_list()
{
	global $db, $smarty;

	//搜索条件
	$con = "WHERE is_delete=0";
	$keyword 	= crequest('keyword');
	if($keyword){
		$con.=" and name like %$keyword%";
	}
	$smarty->assign('keyword'    ,   $keyword);

	$order 	 	= 'ORDER BY listorder DESC ,userid DESC';

	//列表信息
	$now_page 	= irequest('page');
	$now_page 	= $now_page == 0 ? 1 : $now_page;
	$page_size 	= 30;
	$start    	= ($now_page - 1) * $page_size;
	$sql 		= "SELECT * FROM school {$con} {$order} LIMIT {$start},{$page_size}";
	$arr 		= $db->get_all($sql);

	$sql 		= "SELECT COUNT(id) FROM school {$con}";
	$total 		= $db->get_one($sql);
	$page     	= new page(array('total'=>$total, 'page_size'=>$page_size));

	$smarty->assign('school_list',$arr);
	$smarty->assign('pageshow',$page->show(6));
	$smarty->assign('now_page',$page->now_page);

	$smarty->assign('page_title', '幼教机构列表');
	$smarty->display('school/school_list.htm');
}

/*------------------------------------------------------ */
//-- 添加案例
/*------------------------------------------------------ */
function add_school()
{
	global $smarty;

	$smarty->assign('action', 'do_add_school');
	$smarty->assign('page_title', '添加幼教机构');
	$smarty->display('school/school.htm');
}

/*------------------------------------------------------ */
//-- 添加案例
/*------------------------------------------------------ */
function do_add_school()
{
	global $db, $smarty;
	$data=array();
	$data['admin_user_name']    	= crequest('admin_user_name');
	$data['password']   = crequest('password');
	$data['logo']   	= crequest('logo');
	$data['name']   = crequest('name');
	$data['mobile']    	= crequest('mobile');
	$data['type']   = crequest('type');
	$data['address']    	= crequest('address');
	$data['regionid']   = crequest('regionid');
	$data['region']    	= crequest('region');
	$data['introduction']   = crequest('introduction');
	$image[]   = crequest('image1');
	$image[]   = crequest('image2');
	$image[]   = crequest('image3');
	$image[]   = crequest('image4');
	$image[]   = crequest('image5');
	$image[]   = crequest('image6');
	$image[]   = crequest('image7');
	$image[]   = crequest('image8');
	$image[]   = crequest('image9');
	$data['albums'] = implode(',',$image);
	$data['cityid'] = 1;
	$data['city_name'] = "南昌";
	$data['add_time'] = time();
	$data['add_time_format'] = now_time();

	check_null($data['admin_user_name']  	,   '登录账号');
	check_null($data['password']  	,   '登录密码');
	check_null($data['name']  	,   '机构名称');
	check_null($data['mobile']  	,   '联系电话');
	include_once("admin/init.php");



	$sql = "SELECT * FROM school WHERE admin_user_name = '{$data['admin_user_name']}'";
	$school = $db->get_row($sql);
	if($school){
		alert_back('系统已存在该账号，请勿重复添加！');
	}

	$id = $db->insert('school',$data);
	$aid  = $_SESSION['admin_id'];
	$text = '添加用户，添加用户ID：' . $id;
	operate_log($aid, 'school', 1, $text);

	$url_to = "school.php?action=list";
	url_locate($url_to, '添加成功');
}

/*------------------------------------------------------ */
//-- 修改案例
/*------------------------------------------------------ */
function mod_school()
{
	global $db, $smarty;

	$userid = irequest('userid');
	$sql = "SELECT * FROM school WHERE userid = '{$userid}'";
	$school = $db->get_row($sql);
	$smarty->assign('school', $school);
	$smarty->assign('url_path', URL_PATH);

	$smarty->assign('now_page', irequest('now_page'));
	$smarty->assign('action', 'do_mod_school');
	$smarty->assign('page_title', '修改用户');
	$smarty->display('school/school.htm');
}

/*------------------------------------------------------ */
//-- 修改案例
/*------------------------------------------------------ */
function do_mod_school()
{
	global $db;

	$id 	  	= irequest('id');


	$sql = "UPDATE school SET "
			. "name = '{$name}', "
			. "mobile = '{$mobile}' "
			. "WHERE userid = '{$userid}'";
	$db->query($sql);

	$aid  = $_SESSION['admin_id'];
	$text = '修改用户，修改用户ID：' . $userid;
	operate_log($aid, 'school', 2, $text);

	$now_page = irequest('now_page');
	$url_to = "school.php?action=list&page={$now_page}";
	url_locate($url_to, '修改成功');
}

/*------------------------------------------------------ */
//-- 删除案例
/*------------------------------------------------------ */
function del_school()
{
	global $db;

	$userid = irequest('userid');
	/*$sql = "DELETE FROM school WHERE userid = '{$userid}'";
	$db->query($sql);*/

	$update_col = "is_delete = '1'";
	$sql = "UPDATE school SET {$update_col} WHERE userid = '{$userid}'";
	$db->query($sql);

	$aid  = $_SESSION['admin_id'];
	$text = '删除用户，删除用户ID：' . $userid;
	operate_log($aid, 'school', 3, $text);

	$now_page = irequest('now_page');
	$url_to = "school.php?action=list&page={$now_page}";
	href_locate($url_to);
}

/*------------------------------------------------------ */
//-- 批量删除案例
/*------------------------------------------------------ */
function del_sel_school()
{
	global $db;

	$userid = crequest('checkboxes');
	if (empty($userid))alert_back('请选中需要删除的选项');

	/*$sql = "DELETE FROM school WHERE userid IN ({$userid})";
	$db->query($sql);*/

	$sql = "SELECT * FROM school WHERE userid IN ({$userid})";
	$school_all = $db->get_all($sql);
	$update_col = "is_delete = '1'";
	foreach($school_all as $key=>$val){
		$sql = "UPDATE school SET {$update_col} WHERE userid = '{$val['userid']}'";
		$db->query($sql);
	}

	$aid  = $_SESSION['admin_id'];
	$text = '批量删除会员，批量删除会员ID：' . $userid;
	operate_log($aid, 'school', 4, $text);

	$now_page = irequest('now_page');
	$url_to = "school.php?action=list&page={$now_page}";
	href_locate($url_to);
}


?>

