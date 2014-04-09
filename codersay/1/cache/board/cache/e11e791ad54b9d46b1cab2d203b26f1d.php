<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta http-equiv='refresh' content='<?php echo ($waitSecond); ?>;URL=<?php echo ($jumpUrl); ?>'><style type="text/css">
			body			{ background-image:url(../Public/images/bg.gif); font-size:12px; margin:0; padding:0; }
			a				{ text-decoration:none; color:c20000; }
			a:hover			{ color:#000; }
			p, h1			{ margin:0; padding:0; text-indent:35px; }
			p				{ margin-top:4px; }
			.title			{ font-size:14px; padding-top:12px; }
			.message_warp	{ 
				position:absolute;left:50%;top:50%;width:650px;height:82px;
				margin:-41px 0px 0px -325px; 
				background:#fff url(../Public/images/loading.gif) no-repeat 14px 12px;
				border:1px solid #999; 
        		-webkit-border-radius: 4px; 
        		-moz-border-radius: 4px;  
        	}
			.blue			{ color:blue; }
			.green			{ color:green; }
			.red			{ color:red; }
			.refresh		{ margin-bottom:20px; }
		</style></head><body><div class="message_warp"><div class="angle_warp"><?php if(isset($message)): ?><h1 class="title green"><?php echo ($msgTitle); ?></h1><p class="message green"><?php echo ($message); ?></p><?php else: ?><h1 class="title red"><?php echo ($msgTitle); ?></h1><p class="message red"><?php echo ($error); ?></p><?php endif; ?><p class="refresh"><?php if(isset($closeWin)): ?>系统将在 <span style="font-weight:bold;" class="green"><?php echo ($waitSecond); ?></span> 秒后自动关闭， 请稍后...... 如果不想等待，直接点击 <a href="<?php echo ($jumpUrl); ?>">这里</a> 关闭。
					<?php else: ?>
						系统将在 <span style="font-weight:bold;" class="green"><?php echo ($waitSecond); ?></span> 秒后自动跳转， 请稍后...... 如果不想等待，直接点击 <a href="<?php echo ($jumpUrl); ?>">这里</a> 跳转。<?php endif; ?></p></div></div></body></html>