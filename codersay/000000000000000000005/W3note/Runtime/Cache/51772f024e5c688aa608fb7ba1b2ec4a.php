<?php if (!defined('THINK_PATH')) exit(); if(is_array($newscomments)): $i = 0; $__LIST__ = $newscomments;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ct): $mod = ($i % 2 );++$i;?><ul>
          <li>
          <?php if($ct['nid'] == 0): ?><a  href="<?php echo U('/blog/'.$ct['bid']);?>#cmt<?php echo ($ct['id']); ?>">
          <?php else: ?>
          <a  href="<?php echo U('/read/'.$ct['nid']);?>#cmt<?php echo ($ct['id']); ?>"><?php endif; ?>
           <span>    </span>  <?php echo (msubstr($ct['content'],0,50)); ?></a>
           <li style="text-align:right">--<?php echo ($ct['username']); ?></li>
          </li>
           </ul><?php endforeach; endif; else: echo "" ;endif; ?>