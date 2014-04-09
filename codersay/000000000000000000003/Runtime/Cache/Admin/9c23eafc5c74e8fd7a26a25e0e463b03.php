<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv='Refresh' content='<?php echo ($waitSecond); ?>;URL=<?php echo ($jumpUrl); ?>'>
<link rel="stylesheet" href="/Tpl/default/Admin/css/common.css" type="text/css" />
<title>页面提示</title>
</head>

<body>
<form action="/Admin/Login/login" method="post">
<div id="man_zone" style="border:0; margin-top:20px; padding-top: 0px;">
  <table width="50%" border="0" align="center"  cellpadding="3" cellspacing="1" class="table_style">
    <caption></caption>
	<tr>
		<td class="left_title_1" style="text-align:center;color:#000000;"><?php echo ($msgTitle); ?></td>
	</tr>
    <tr>
      <td width="100%" class="left_title_2" style="text-align:left;">
	  <?php if(isset($message)): ?><font style="color:blue;"><?php echo ($message); ?></font><?php endif; ?>
	  <?php if(isset($error)): ?><font style="color:red;"><?php echo ($error); ?></font><?php endif; ?>
	  </td>
    </tr>
    <tr>
      <td class="left_title_2" style="text-align:left;">
	  <?php if(isset($closeWin)): ?>系统将在 <span style="color:blue;font-weight:bold"><?php echo ($waitSecond); ?></span> 秒后自动关闭，如果不想等待,直接点击 <a href="<?php echo ($jumpUrl); ?>" style="color:blue;">这里</a> 关闭<?php endif; ?>
	  <?php if(!isset($closeWin)): ?>系统将在 <span style="color:blue;font-weight:bold"><?php echo ($waitSecond); ?></span> 秒后自动跳转,如果页面没有自动跳转或不想等待,直接点击 <a href="<?php echo ($jumpUrl); ?>" style="color:blue;">这里</a> 跳转<?php endif; ?>
	  </td>
    </tr>
  </table>
</div>
</form>
</body>
</html>