<?php /* Smarty version Smarty-3.0.6, created on 2017-11-02 21:37:30
         compiled from "E:/xiangmu/phpstudy/WWW/youshizhaopin/temp/admin\common/main.htm" */ ?>
<?php /*%%SmartyHeaderCode:2326759fb1f9a5f35d2-62699498%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2e43f9074cddd1a8c8ce084b66cf2c5be9b29e0' => 
    array (
      0 => 'E:/xiangmu/phpstudy/WWW/youshizhaopin/temp/admin\\common/main.htm',
      1 => 1506520244,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2326759fb1f9a5f35d2-62699498',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getVariable('sys_name')->value;?>
</title>
<link href="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/css/general.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/css/addon.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $_smarty_tpl->getVariable('admin_temp_path')->value;?>
/css/addmain.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="98%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="45%"><table width="100%" style="border:1px solid #bbdde5;" cellspacing="0" cellpadding="0">
  <tr>
    <td height="30" class="tbhead">服务器信息</td>
  </tr>
  <tr>
    <td class="newtable">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="160" height="38" class="dott">主机名：</td>
        <td class="dott"><?php echo $_smarty_tpl->getVariable('sys_info')->value['domain'];?>
</td>
      </tr>
      <tr>
        <td height="38" class="dott">服务器端口：</td>
        <td class="dott"><?php echo $_smarty_tpl->getVariable('sys_info')->value['server_port'];?>
</td>
      </tr>
      <tr>
        <td height="38" class="dott">服务器操作系统：</td>
        <td class="dott"><?php echo $_smarty_tpl->getVariable('sys_info')->value['os'];?>
</td>
      </tr>
      <tr>
        <td height="38" class="dott">WEB服务器： </td>
        <td class="dott"><?php echo $_smarty_tpl->getVariable('sys_info')->value['web_server'];?>
</td>
      </tr>
      <tr>
        <td height="38" class="dott">MySQL 版本：</td>
        <td class="dott"><?php echo $_smarty_tpl->getVariable('sys_info')->value['mysql'];?>
</td>
      </tr>
    </table>
	</td>
  </tr>
</table></td>
    <td width="55%"><table width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #bbdde5;">
  <tr>
    <td height="30" class="tbhead">PHP信息</td>
  </tr>
  <tr>
    <td class="newtable">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="160" height="38" class="dott">PHP版本：</td>
        <td class="dott"><?php echo $_smarty_tpl->getVariable('sys_info')->value['php_ver'];?>
</td>
      </tr>
      <tr>
        <td height="38" class="dott">安全模式：</td>
        <td class="dott"><?php echo $_smarty_tpl->getVariable('sys_info')->value['safe_mode'];?>
</td>
      </tr>
      <tr>
        <td height="38" class="dott">GD版本：</td>
        <td class="dott"><?php echo $_smarty_tpl->getVariable('sys_info')->value['gd'];?>
</td>
      </tr>
      <tr>
        <td height="38" class="dott">页面编码： </td>
        <td class="dott"><?php echo $_smarty_tpl->getVariable('sys_info')->value['char_set'];?>
</td>
      </tr>
      <tr>
        <td height="38" class="dott">Socket支持：</td>
        <td class="dott"><?php echo $_smarty_tpl->getVariable('sys_info')->value['socket'];?>
</td>
      </tr>
    </table>
	</td>
  </tr>
</table></td>
  </tr>

</table>
</body>
</html>
