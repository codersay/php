<?php
/**
 *  基本图片处理，用于完成图片缩入，水印添加
 *  当水印图超过目标图片尺寸时，水印图能自动适应目标图片而缩小
 *  水印图可以设置跟背景的合并度
 */

/**
 * ThumbHandler
 * @access public
 */
class ThumbHandler
{
    var $dst_img;// 目标文件
    var $h_src; // 图片资源句柄
    var $h_dst;// 新图句柄
    var $h_mask;// 水印句柄
    var $img_scale = 0;// 图片缩放比例
    var $src_w = 0;// 原图宽度
    var $src_h = 0;// 原图高度
    var $dst_w = 0;// 新图总宽度
    var $dst_h = 0;// 新图总高度
    var $fill_w;// 填充图形宽
    var $fill_h;// 填充图形高
    var $copy_w;// 拷贝图形宽
    var $copy_h;// 拷贝图形高
    var $src_x = 0;// 原图绘制起始横坐标
    var $src_y = 0;// 原图绘制起始纵坐标
    var $start_x;// 新图绘制起始横坐标
    var $start_y;// 新图绘制起始纵坐标
    var $mask_word;// 水印文字
    var $mask_img;// 水印图片
    var $mask_pos_x = 0;// 水印横坐标
    var $mask_pos_y = 0;// 水印纵坐标
    var $mask_offset_x = 0;// 水印横向偏移
    var $mask_offset_y = 0;// 水印纵向偏移
    var $font_w;// 水印字体宽
    var $font_h;// 水印字体高
    var $mask_w;// 水印宽
    var $mask_h;// 水印高
    var $mask_font_color = "#ffffff";// 水印文字颜色
    var $mask_font = 2;// 水印字体
    var $font_size;// 尺寸
    var $mask_position = 0;// 水印位置
    var $mask_img_alpha = 100;// 图片透明度,值越大，合并程序越低
    var $mask_txt_alpha = 100;// 文字透明度,值越大，合并程序越低
    var $img_border_size = 0;// 图片边框尺寸
    var $img_border_color;// 图片边框颜色
    var $_flip_x=0;// 水平翻转次数
    var $_flip_y=0;// 垂直翻转次数
    var $cancel_resize;// 是否缩放
    var $cut_type=0;// 剪切类型
    var $img_type;// 文件类型

    // 文件类型定义,并指出了输出图片的函数
    var $all_type = array(
        "jpg"  => array("output"=>"imagejpeg"),
        "gif"  => array("output"=>"imagegif"),
        "png"  => array("output"=>"imagepng"),
        "wbmp" => array("output"=>"image2wbmp"),
        "jpeg" => array("output"=>"imagejpeg"));

    /**
     * 构造函数
     */
    function __construct()
    {
    	$this->mask_font_color = "#ffffff";
        $this->font = 2;
        $this->font_size = 12;
    }

    /**
     * 取得图片的宽
     */
    function getImgWidth($src)
    {
        return imagesx($src);
    }

    /**
     * 取得图片的高
     */
    function getImgHeight($src)
    {
        return imagesy($src);
    }

    /**
     * 设置图片生成路径
     *
     * @param    string    $src_img   图片生成路径
     */
    function setSrcImg($src_img, $flip_x=0, $flip_y=0)
    {
        if(!file_exists($src_img))
        {
            die("图片不存在");
        }
		
		$this->img_type = $this->_getImgType($src_img);
        $this->_checkValid($this->img_type);

        // file_get_contents函数要求php版本>4.3.0
        $src = '';
        if(function_exists("file_get_contents"))
        {
            $src = file_get_contents($src_img);
        }
        else
        {
            $handle = fopen ($src_img, "r");
            while (!feof ($handle))
            {
                $src .= fgets($fd, 4096);
            }
            fclose ($handle);
        }
        if(empty($src))
        {
            //die("图片源为空");
            return '';
        }
        $this->h_src = @ImageCreateFromString($src);

        if(!empty($flip_x))
        {
            $this->_flipH($this->h_src);
        }

        if(!empty($flip_y))
        {
            $this->_flipV($this->h_src);
        }
        
        $this->src_w = $this->getImgWidth($this->h_src);
        $this->src_h = $this->getImgHeight($this->h_src);
    }

    /**
     * 设置图片生成路径
     *
     * @param    string    $dst_img   图片生成路径
     */
    function setDstImg($dst_img, $border_width=0, $border_color='')
    {
        $arr  = explode('/',$dst_img);
        $last = array_pop($arr);
        $path = implode('/',$arr);
        $this->_mkdirs($path);
        $this->dst_img = $dst_img;

        if(!empty($border_width) && $border_width > 0)
        {
            $this->img_border_size  = (int)$border_width;
            $this->img_border_color = $border_color;
        }
    }

    /**
     * 设置目标图片占原图的比例
     *
     * @param    int     $param_name    remark
     */
    function setDstImgSize($cut_type, $width, $height)
    {
        $this->_setNewImgSize($cut_type, $width, $height);
        $this->_drawCanvas();
       
        $this->_drawBorder();
    }

    /**
     * 设置目标图片占原图的比例
     *
     * @param    int     $param_name    remark
     */
    function setDstImgScale($scale)
    {
        $this->img_scale = $scale;
        $this->_setNewImageSizeByScale();
        $this->_drawCanvas();
        $this->_drawBorder();
    }

    /**
     * 设置文字水印
     *
     * @param    string|integer    $font    字体
     */
    function setMaskWord($word, $font=2, $font_size=12, $font_color="#ffffff", $alpha=100, $position=0, $offset_x=0, $offset_y=0)
    {
        $this->mask_word = iconv("GBK", "UTF-8", $word);
        if(!is_numeric($font) && !file_exists($font))
        {
            die("字体文件不存在");
        }
        $this->font = $font;
        $this->font_size = $font_size;
        $this->mask_font_color = $font_color;
        
        $text_alpha = abs(100 - (int)$alpha);
        if($text_alpha > 100)
        {
            $text_alpha = 100;
        }
        $this->mask_txt_alpha = (int)$text_alpha;
        $this->mask_position  = (int)$position;
        $this->mask_offset_x  = (int)$offset_x;
        $this->mask_offset_y  = (int)$offset_y;

        $this->_createMaskWord();
    }

    /**
     * 设置图片水印
     *
     * @param    string     $img        水印图片源
     * @param    int        $alpha      透明度，对于png图，100时可以完全透明
     * @param    int        $position   水印位置
     * @param    int        $x          横向偏移量
     * @param    int        $y          纵向偏移量
     */
    function setMaskImg($img, $alpha=0, $position=0, $offset_x=0, $offset_y=0)
    {
        $this->mask_img = $img;
        $this->mask_img_alpha = (int)$alpha;
        $this->mask_position  = (int)$position;
        $this->mask_offset_x  = (int)$offset_x;
        $this->mask_offset_y  = (int)$offset_y;

        $this->_createMaskImg();
    }

    /**
     * 设置图片剪切
     *
     * @param    integer     $width    矩形剪切
     */
    function setRectangleCut($width, $height)
    {
		$this->fill_w = (int)$width;
		$this->fill_h = (int)$height;
    }

	/**
	 * 设置源图剪切起始坐标点
	 *
	 * @param    (类型)     (参数名)    (描述)
	 */
	function setSrcCutPosition($x, $y)
	{
		$this->src_x  = (int)$x;
        $this->src_y  = (int)$y;
	}

    /**
     * 创建图片,主函数
     * @param    integer    $quality     图片生成质量，
     */
    function createImg($quality=100, $output_type=0)
    {
        if(empty($this->fill_w) || empty($this->fill_h))
        {
            echo '未指定缩略图尺寸';
        }

        // 如果没有水印，直接生成
        if(empty($this->mask_word) && empty($this->mask_img))
        {
            $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
            
            
            if($this->cancel_resize != 1)
            {
                imagecopyresampled( $this->h_dst, $this->h_src,
                                    $this->start_x, $this->start_y,
                                    $this->src_x, $this->src_y,
                                    $this->fill_w, $this->fill_h,
                                    $this->copy_w, $this->copy_h);
            }
            else
            {
                imagecopy($this->h_dst , $this->h_src, $this->start_x, $this->start_y, $this->src_x, $this->src_y, $this->copy_w , $this->copy_h);
            }
        }
        
        $this->_output($quality, $output_type);

        // 释放
        if(imagedestroy($this->h_src) && imagedestroy($this->h_dst))
        {
            Return true;
        }
        else
        {
            Return false;
        }
    }

    /**
     * 画边框
     */
    function _drawBorder()
    {
        if(!empty($this->img_border_size) && !empty($this->h_dst))
        {
            $c = $this->_parseColor($this->img_border_color);
            $color = ImageColorAllocate($this->h_src, $c[0], $c[1], $c[2]);
            imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$color);// 填充背景色
        }
    }

    /**
     * 绘制背景
     */
    function _drawCanvas()
    {
        // 生成背景
        if(!empty($this->img_border_size) && empty($this->h_dst))
        {
            $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
            $c = $this->_parseColor($this->img_border_color);
            $color = ImageColorAllocate($this->h_dst, $c[0], $c[1], $c[2]);
            imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$color);// 填充背景色
        } 
    }

    /**
     * 生成水印文字
     */
    function _genMaskWord($src)
    {
        $this->_countMaskPos();
        $this->_checkMaskValid();

        $c = $this->_parseColor($this->mask_font_color);
        $color = imagecolorallocatealpha($src, $c[0], $c[1], $c[2], $this->mask_txt_alpha);

        if(is_numeric($this->font))
        {
            imagestring($src,
                        $this->font,
                        $this->mask_pos_x, $this->mask_pos_y,
                        $this->mask_word,
                        $color);
        }
        else
        {
            imagettftext($src,
                        $this->font_size, 0,
                        $this->mask_pos_x, $this->mask_pos_y + $this->mask_h,
                        $color,
                        $this->font,
                        $this->mask_word);
        }
    }

    /**
     * 生成文字水印
     */
    function _createMaskWord()
    {
        if($this->mask_word)
        {
            // 获取字体信息
            $this->_setFontInfo();

            if($this->_isFull())
            {
                die("水印文字过大");
            }
            else
            {
                if(empty($this->h_dst))
                {
                    $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
                }
                //$this->_drawBorder();
                if(!empty($this->h_dst))
                {
                    if(empty($this->copy_image))
                    {
                        $rs = imagecopyresampled( $this->h_dst, $this->h_src,
                                        $this->start_x, $this->start_y,
                                        $this->src_x, $this->src_y,
                                        $this->fill_w, $this->fill_h,
                                        $this->copy_w, $this->copy_h);

                        if($rs)
                        {
                            $this->copy_image = 1;
                        }
                    }
                }
                $this->_genMaskWord($this->h_dst);
            }
        }
    }

    /**
     * 生成水印图
     */
    function _genMaskImg($src)
    {
        $this->_countMaskPos();
        $this->_checkMaskValid();

        if($this->mask_img_alpha == 0)
        {
            imagecopy($src,
                    $this->h_mask,
                    $this->mask_pos_x ,$this->mask_pos_y,
                    0, 0,
                    $this->mask_w, $this->mask_h);
        }
        else
        {
            imagecopymerge($src,
                        $this->h_mask,
                        $this->mask_pos_x ,$this->mask_pos_y,
                        0, 0,
                        $this->mask_w, $this->mask_h,
                        $this->mask_img_alpha);    
        }

        imagedestroy($this->h_mask);
    }

    /**
     * 生成图片水印
     */
    function _createMaskImg()
    {
        if($this->mask_img)
        {
            $this->_loadMaskImg();//加载时，取得宽高

            if($this->_isFull())
            {
                // 将水印生成在原图上再拷
                $this->_genMaskImg($this->h_src);
               
            }

            if(empty($this->h_dst))
            {
                $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
                $white = ImageColorAllocateAlpha($this->h_dst,255,255,255, 0);
                imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$white);// 填充背景色
            }

            //$this->_drawBorder();
            if(!empty($this->h_dst))
            {
                if(empty($this->copy_image))
                {
                    $rs = imagecopyresampled( $this->h_dst, $this->h_src,
                                    $this->start_x, $this->start_y,
                                    $this->src_x, $this->src_y,
                                    $this->fill_w, $this->fill_h,
                                    $this->copy_w, $this->copy_h);

                    if($rs)
                    {
                        $this->copy_image = 1;
                    }
                }                    
            }

            if(!$this->_isFull())
            {
                $this->_genMaskImg($this->h_dst);
            }
        }
    }

    /**
     * 加载水印图
     */
    function _loadMaskImg()
    {
        $mask_type = $this->_getImgType($this->mask_img);
        $this->_checkValid($mask_type);

        // file_get_contents函数要求php版本>4.3.0
        $src = '';
        if(function_exists("file_get_contents"))
        {
            $src = file_get_contents($this->mask_img);
        }
        else
        {
            $handle = fopen ($this->mask_img, "r");
            while (!feof ($handle))
            {
                $src .= fgets($fd, 4096);
            }
            fclose ($handle);
        }
        if(empty($this->mask_img))
        {
            die("水印图片为空");
        }
        $this->h_mask = ImageCreateFromString($src);
        $this->mask_w = $this->getImgWidth($this->h_mask);
        $this->mask_h = $this->getImgHeight($this->h_mask);
    }

    /**
     * 图片输出
     */
    function _output($quality, $output_type=0)
    {
        imagealphablending($this->h_dst, true); 
        $img_type  = $this->img_type;
        $func_name = $this->all_type[$img_type]['output'];
        if(function_exists($func_name))
        {
            $output_quality = abs($quality);
            if($output_quality > 100)
            {
                $output_quality = 100;
            }

            if($output_type == 0)
            {
                // 判断浏览器,若是IE就不发送头
                if(isset($_SERVER['HTTP_USER_AGENT']))
                {
                    $ua = strtoupper($_SERVER['HTTP_USER_AGENT']);
                    if(!preg_match('/^.*MSIE.*\)$/i',$ua))
                    {
                        header("Content-type:$img_type");
                    }
                }
                //2012-11-07修复Png无法生成缩略图的Bug。
                if ( $img_type == 'jpg' || $img_type == 'jpeg' ){
                	$func_name($this->h_dst, $this->dst_img, $output_quality);
                }else{
                	$func_name($this->h_dst, $this->dst_img);
                }
            }
            else
            {
                header("Content-type:$img_type");
                $func_name($this->h_dst, '', $output_quality);
            }
        }
        else
        {
            Return false;
        }
    }

    /**
     * 分析颜色
     *
     * @param    string     $color    十六进制颜色
     */
    function _parseColor($color)
    {
        $arr = array();
        for($ii=1; $ii<strlen($color); $ii++)
        {
            $arr[] = hexdec(substr($color,$ii,2));
            $ii++;
        }

        Return $arr;
    }

    /**
     * 计算出位置坐标
     */
    function _countMaskPos()
    {
        if($this->_isFull())
        {
            switch($this->mask_position)
            {
                case 1:
                    // 左上
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;

                case 2:
                    // 左下
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->src_h - $this->mask_h - $this->mask_offset_y;
                    break;

                case 3:
                    // 右上
                    $this->mask_pos_x = $this->src_w - $this->mask_w - $this->mask_offset_x;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;

                case 4:
                    // 右下
                    $this->mask_pos_x = $this->src_w - $this->mask_w - $this->mask_offset_x;
                    $this->mask_pos_y = $this->src_h - $this->mask_h - $this->mask_offset_y;
                    break;

                default:
                    // 默认将水印放到右下,偏移指定像素
                    $this->mask_pos_x = $this->src_w - $this->mask_w - $this->mask_offset_x;
                    $this->mask_pos_y = $this->src_h - $this->mask_h - $this->mask_offset_y;
                    break;
            }
        }
        else
        {
            switch($this->mask_position)
            {
                case 1:
                    // 左上
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;

                case 2:
                    // 左下
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->dst_h - $this->mask_h - $this->mask_offset_y - $this->img_border_size;
                    break;

                case 3:
                    // 右上
                    $this->mask_pos_x = $this->dst_w - $this->mask_w - $this->mask_offset_x - $this->img_border_size;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;

                case 4:
                    // 右下
                    $this->mask_pos_x = $this->dst_w - $this->mask_w - $this->mask_offset_x - $this->img_border_size;
                    $this->mask_pos_y = $this->dst_h - $this->mask_h - $this->mask_offset_y - $this->img_border_size;
                    break;

                default:
                    // 默认将水印放到右下,偏移指定像素
                    $this->mask_pos_x = $this->dst_w - $this->mask_w - $this->mask_offset_x - $this->img_border_size;
                    $this->mask_pos_y = $this->dst_h - $this->mask_h - $this->mask_offset_y - $this->img_border_size;
                    break;
            }
        }
    }

    /**
     * 设置字体信息
     */
    function _setFontInfo()
    {
        if(is_numeric($this->font))
        {
            $this->font_w  = imagefontwidth($this->font);
            $this->font_h  = imagefontheight($this->font);

            // 计算水印字体所占宽高
            $word_length   = strlen($this->mask_word);
            $this->mask_w  = $this->font_w*$word_length;
            $this->mask_h  = $this->font_h;
        }
        else
        {
            $arr = imagettfbbox ($this->font_size, 0, $this->font, $this->mask_word);
            $this->mask_w  = abs($arr[0] - $arr[2]);
            $this->mask_h  = abs($arr[7] - $arr[1]);
        }
    }

    /**
     * 设置新图尺寸
     *
     * @param    integer     $img_w   目标宽度
     * @param    integer     $img_h   目标高度
     */
    function _setNewImgSize($cut_type, $img_w, $img_h)
    {
        $this->cut_type = (int)$cut_type;

        $fill_w   = (int)$img_w - $this->img_border_size*2;
        $fill_h   = (int)$img_h - $this->img_border_size*2;
        if($fill_w <= 0 || $fill_h <= 0)
        {
            die("图片边框过大，已超过了图片的宽度");
        }
        $rate_w = $this->src_w/$fill_w;
        $rate_h = $this->src_h/$fill_h;

        switch($this->cut_type)
        {
            case 0:
                // 如果原图大于缩略图，产生缩小，否则不缩小
                if($rate_w < 1 && $rate_h < 1)
                {
                    $this->fill_w = (int)$this->src_w;
                    $this->fill_h = (int)$this->src_h;
                }
                else
                {
                    if($rate_w >= $rate_h)
                    {
                        $this->fill_w = (int)$fill_w;
                        $this->fill_h = round($this->src_h/$rate_w);
                    }
                    else
                    {
                        $this->fill_w = round($this->src_w/$rate_h);
                        $this->fill_h = (int)$fill_h;
                    }
                }

                $this->src_x  = 0;
                $this->src_y  = 0;

                $this->copy_w = $this->src_w;
                $this->copy_h = $this->src_h;

                // 目标尺寸
                $this->dst_w   = $this->fill_w + $this->img_border_size*2;
                $this->dst_h   = $this->fill_h + $this->img_border_size*2;

                // 目标文件起始坐标
                $this->start_x = $this->img_border_size;
                $this->start_y = $this->img_border_size;
                break;

            // 自动裁切
            case 1:
                // 如果图片是缩小剪切才进行操作
                if($rate_w > 1 && $rate_h > 1)
                {
                    // 模向缩得多
                    if($rate_w > $rate_h)
                    {
                        $this->copy_w = round($this->src_h * $fill_w/$fill_h);// 计算截取点坐标及宽度
                        $this->copy_h = $this->src_h;

                        $src_x = round(($this->src_w - $this->copy_w)/2);
                        $src_y = 0;
                    }
                    elseif($rate_w < $rate_h)
                    {
                        $this->copy_w = $this->src_w;
                        $this->copy_h = round($this->src_w * $fill_h/$fill_w);

                        $src_x = 0;
                        $src_y = round(($this->src_h - $this->copy_h)/2);
                    }
                    else
                    {
                        $this->copy_w = $this->src_w;
                        $this->copy_h = $this->src_h;

                        $src_x = 0;
                        $src_y = 0;
                    }
                    $this->setSrcCutPosition($src_x, $src_y);
                    $this->setRectangleCut($fill_w, $fill_h);   
                    
                    // 目标文件起始坐标
                    $this->start_x = $this->img_border_size;
                    $this->start_y = $this->img_border_size;

                }

                // 宽度变大，高度变小
                elseif($rate_w < 1 && $rate_h > 1)
                {
                    $this->copy_w = $this->src_w;
                    $this->copy_h = $fill_h;

                    $src_x = 0;
                    $src_y = round(($this->src_h - $fill_h)/2);
                    $this->setSrcCutPosition($src_x, $src_y);
                    $this->setRectangleCut($fill_w, $fill_h);

                    // 目标文件起始坐标
                    $this->start_x = $this->img_border_size + round(($fill_w - $this->src_w)/2);
                    $this->start_y = $this->img_border_size;  
                    
                    $this->cancel_resize = 1;// 取消缩放
                }

                // 宽度变小，高度变大
                elseif($rate_w > 1 && $rate_h < 1)
                {
                    $this->copy_w = $fill_w;
                    $this->copy_h = $this->src_h;

                    $src_x = round(($this->src_w - $fill_w)/2);
                    $src_y = 0;
                    $this->setSrcCutPosition($src_x, $src_y);
                    $this->setRectangleCut($fill_w, $fill_h);

                    // 目标文件起始坐标
                    $this->start_x = $this->img_border_size;
                    $this->start_y = $this->img_border_size + round(($fill_h - $this->src_h)/2);

                    $this->cancel_resize = 1;// 取消缩放
                }

                // 完全拷贝
                else
                {
                    $this->setSrcCutPosition(0, 0);
                    $this->setRectangleCut($this->src_w, $this->src_h);

                    $this->copy_w = $this->src_w;
                    $this->copy_h = $this->src_h;

                    // 目标文件起始坐标
                    $this->start_x = $this->img_border_size;
                    $this->start_y = $this->img_border_size;
                }

                // 目标尺寸
                $this->dst_w   = $this->fill_w + $this->img_border_size*2;
                $this->dst_h   = $this->fill_h + $this->img_border_size*2;                
                break;

            // 手工裁切
            case 2:
                $this->setRectangleCut($fill_w, $fill_h);
                $this->copy_w = $this->fill_w;
                $this->copy_h = $this->fill_h;

                // 目标尺寸
                $this->dst_w   = $this->fill_w + $this->img_border_size*2;
                $this->dst_h   = $this->fill_h + $this->img_border_size*2;
                
                // 目标文件起始坐标
                $this->start_x = $this->img_border_size;
                $this->start_y = $this->img_border_size;
                break;
            
            default:
                break;
        }
    }

    /**
     * 按比例调节图片
     *
     * @param    int     $param_name    remark
     */
    function _setNewImageSizeByScale()
    {
        if($this->img_scale)
        {
            $this->fill_w = round($this->src_w * $this->img_scale / 100) - $this->img_border_size*2;
            $this->fill_h = round($this->src_h * $this->img_scale / 100) - $this->img_border_size*2;

            // 源文件起始坐标
            $this->src_x  = 0;
            $this->src_y  = 0;
            $this->copy_w = $this->src_w;
            $this->copy_h = $this->src_h;

			// 目标尺寸
			$this->dst_w   = $this->fill_w + $this->img_border_size*2;
			$this->dst_h   = $this->fill_h + $this->img_border_size*2;
        }

        // 目标文件起始坐标
        $this->start_x = $this->img_border_size;
        $this->start_y = $this->img_border_size;
    }

    /**
     * 检查水印图是否大于生成后的图片宽高
     */
    function _isFull()
    {
        Return (   $this->mask_w + $this->mask_offset_x > $this->fill_w
                || $this->mask_h + $this->mask_offset_y > $this->fill_h)
                   ?true:false;
    }

    /**
     * 检查水印图是否超过原图
     */
    function _checkMaskValid()
    {
        if(    $this->mask_w + $this->mask_offset_x > $this->src_w
            || $this->mask_h + $this->mask_offset_y > $this->src_h)
        {
            die("水印图片尺寸大于原图，请缩小水印图");
        }
    }

    /**
     * 取得图片类型
     *
     * @param    string     $file_path    文件路径
     */
    function _getImgType($file_path)
    {
        $type_list = array("1"=>"gif","2"=>"jpg","3"=>"png","4"=>"swf","5" => "psd","6"=>"bmp","15"=>"wbmp");
        if(file_exists($file_path))
        {
            $img_info = @getimagesize ($file_path);
            if(isset($type_list[$img_info[2]]))
            {
                Return $type_list[$img_info[2]];
            }
        }
        else
        {
            die("文件不存在,不能取得文件类型!");
        }
    }

    /**
     * 检查图片类型是否合法,调用了array_key_exists函数，此函数要求
     * php版本大于4.1.0
     *
     * @param    string     $img_type    文件类型
     */
    function _checkValid($img_type)
    {
        if(!array_key_exists($img_type, $this->all_type))
        {
            Return false;
        }
    }

    /**
     * 按指定路径生成目录
     *
     * @param    string     $path    路径
     */
    function _mkdirs($path)
    {
        $adir = explode('/',$path);
        $dirlist = '';
        $rootdir = array_shift($adir);
        if(($rootdir!='.'||$rootdir!='..')&&!file_exists($rootdir))
        {
            @mkdir($rootdir);
        }
        foreach($adir as $key=>$val)
        {
            if($val!='.'&&$val!='..')
            {
                $dirlist .= "/".$val;
                $dirpath = $rootdir.$dirlist;
                if(!file_exists($dirpath))
                {
                    @mkdir($dirpath);
                    @chmod($dirpath,0777);
                }
            }
        }
    }

    /**
     * 垂直翻转
     *
     * @param    string     $src    图片源
     */
    function _flipV($src)
    {
        $src_x = $this->getImgWidth($src);
        $src_y = $this->getImgHeight($src);

        $new_im = imagecreatetruecolor($src_x, $src_y);
        for ($y = 0; $y < $src_y; $y++)
        {
            imagecopy($new_im, $src, 0, $src_y - $y - 1, 0, $y, $src_x, 1);
        }
        $this->h_src = $new_im;
    }

    /**
     * 水平翻转
     *
     * @param    string     $src    图片源
     */
    function _flipH($src)
    {
        $src_x = $this->getImgWidth($src);
        $src_y = $this->getImgHeight($src);

        $new_im = imagecreatetruecolor($src_x, $src_y);
        for ($x = 0; $x < $src_x; $x++)
        {
            imagecopy($new_im, $src, $src_x - $x - 1, 0, $x, 0, 1, $src_y);
        }
        $this->h_src = $new_im;
    }
}
?>