<?php
/*
 * 远程获取图片类
 * 
 * 要求开启curl扩展
 * 模拟php上传原理,创建一个缓存目录,将远程获取的文件存放到缓存目录下. 
 * 
 * 
 */

class url_pic{
    
    protected $cache; //缓存路径
    
    public function  __construct($cache='')
    {
        if(!empty($cache))
        {
            $this->cache = $cache;
        }
        else
        {
            $this->cache = './static/uploads/cache/';
        }
    }
    
    //设置缓存目录
    public function set_cache($cache='')
    {
        if(!empty($cache))
        {
            $this->cache = $cache;
        }
    }
    /*
     * 获取远程图片 将文件存入cache文件夹
     * 
     * $url 获取远程的文件的链接
     * $error 
     * @return 777 则返回不能建立文件夹 
     * @return 存入缓存的文件名
     */
    public function get_file($url,$error=777)
    {
            $path = $this->build_folder($this->cache);
            if($path==false) return $error;
            
            $curl = curl_init();
            // 设置你需要抓取的URL
            curl_setopt($curl, CURLOPT_URL, $url);
            // 设置header
            curl_setopt($curl, CURLOPT_HEADER, 0);
            // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // 运行cURL，请求网页
            $file = curl_exec($curl);
            // 关闭URL请求
            curl_close($curl);
            
            //将文件写入获得的数据
            $filename = $this->cache.date("YmdHis");
            if(self::build_file($file, $filename)==false)
            {
                return false;
            }
            return $filename;
    }
    
    //建立文件夹
    public function build_folder($dir)
    {
        if (!is_dir($dir))
        {
            if (!mkdir($dir,0777,TRUE) || !chmod($dir,0777))
            {
                    return false;
            }
        }
        return true;
    }
    
    /*
     * 移动文件 模拟php的move_uploaded_file方法
     * 
     * $cache 缓存文件路径
     * $filename 需要生成的文件名的绝对路径
     * 
     * @return $filename
     */
    public function move_file($cache,$filename)
    {
        $file = @file_get_contents($cache);
        if(self::build_file($file, $filename)==false)
        {
            return false;
        }
        unlink($cache); //清除缓存图片
        return $filename;
    }
    
    /*
     * 生成文件
     * $file 需要写入的文件或者二进制流
     * $newname 需要生成的文件名的绝对路径
     */
    protected static function build_file($file,$filename)
    {
        $write = @fopen($filename,"w");
        if($write==false)
        {
            return false;
        }
        if(fwrite($write,$file)==false)
        {
            return false;
        }
        if(fclose($write)==false)
        {
            return false;
        }
        return true; 
    }

}
?>
