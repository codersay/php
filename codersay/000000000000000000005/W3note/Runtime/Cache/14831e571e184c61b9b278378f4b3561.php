<?php if (!defined('THINK_PATH')) exit();?> <li><span><strong><a href="<?php echo (C("rooturl")); ?>">首页</a></strong></span></li>
 <li><a href="<?php echo (C("rooturl")); ?>blog">微博客</a></li>
 <?php if(is_array($nav)): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/cat/'.$menu['colId']);?>"><?php echo ($menu['colTitle']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
  <li> <a href="<?php echo (C("rooturl")); ?>guestbook" title="给我留言，有问必答">给我留言</a></li>