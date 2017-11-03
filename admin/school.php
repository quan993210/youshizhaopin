
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

	$order 	 	= 'ORDER BY listorder DESC ,id DESC';

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
	$data=$_POST['info'];
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

	$sql = "SELECT * FROM school WHERE admin_user_name = '{$data['admin_user_name']}' and is_delete=0";
	$school = $db->get_row($sql);
	if($school){
		alert_back('系统已存在该账号，请勿重复添加！');
	}

	$id = $db->insert('school',$data);
	$aid  = $_SESSION['admin_id'];
	$text = '添加幼教机构，添加幼教机构ID：' . $id;
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
	$id = irequest('id');
	$sql = "SELECT * FROM school WHERE id = '{$id}' and is_delete =0";
	$school = $db->get_row($sql);
	$smarty->assign('school', $school);
	$smarty->assign('url_path', URL_PATH);

	$smarty->assign('now_page', irequest('now_page'));
	$smarty->assign('action', 'do_mod_school');
	$smarty->assign('page_title', '修改');
	$smarty->display('school/school.htm');
}

/*------------------------------------------------------ */
//-- 修改案例
/*------------------------------------------------------ */
function do_mod_school()
{
	global $db;

	$id 	  	= irequest('id');
	$data=$_POST['info'];
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

	check_null($data['admin_user_name']  	,   '登录账号');
	check_null($data['password']  	,   '登录密码');
	check_null($data['name']  	,   '机构名称');
	check_null($data['mobile']  	,   '联系电话');


	$sql = "SELECT * FROM school WHERE admin_user_name = '{$data['admin_user_name']}' and is_delete=0";
	$school = $db->get_row($sql);
	if($school['id'] != $id){
		alert_back('系统已存在该账号！');
	}
	$db->update('school',$data,"id=$id");
	$aid  = $_SESSION['admin_id'];
	$text = '修改幼教机构，修改幼教机构ID：' . $id;
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
	$id = irequest('id');
	$update_col = "is_delete = '1'";
	$sql = "UPDATE school SET {$update_col} WHERE id = '{$id}'";
	$db->query($sql);
	$aid  = $_SESSION['admin_id'];
	$text = '删除幼教机构，删除幼教机构ID：' . $id;
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
	$id = crequest('checkboxes');
	if (empty($id))alert_back('请选中需要删除的选项');
	$sql = "SELECT * FROM school WHERE id IN ({$id}) and is_delete =0";
	$school_all = $db->get_all($sql);
	$update_col = "is_delete = '1'";
	foreach($school_all as $key=>$val){
		$sql = "UPDATE school SET {$update_col} WHERE id = '{$val['id']}'";
		$db->query($sql);
	}
	$aid  = $_SESSION['admin_id'];
	$text = '批量删除会员，批量删除会员ID：' . $id;
	operate_log($aid, 'school', 4, $text);
	$now_page = irequest('now_page');
	$url_to = "school.php?action=list&page={$now_page}";
	href_locate($url_to);
}


?>

