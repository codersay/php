<?php
	/**
	* 
	*/
	class SideBarWeatherHooks extends Hooks
	{
		public function sidebar_weather(){
			$IP = get_client_ip();
			$cityCode = $this->getIPLocSina($IP);
			$this->assign('weather', $cityCode );
			$this->display('showWeather');
		}

		public function proxy($param)
	    {
	        $city = h($param['city']);
	        $data = file_get_contents('http://php.weather.sina.com.cn/iframe/index/w_cl.php?day=2&code=js&cbf=show&city='.$city);
	        $data = iconv("GB2312","UTF-8",$data);
	        echo $data;
	    }

		/**
	     * 通过IP获取地区信息，新浪接口，使用需要开启php.ini中的curl
	     * @param string $queryIP 查询的IP地址
	     * @return string IP的相关地区信息
	     */
	    private function getIPLocSina($queryIP)
	    {   
	        // 获取地区信息API接口数据
	        $location = file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP);
	        $location = json_decode($location);   
	        $loc = "";   
	        if($location === false) {
	            return "";   
	        }   
	        if(empty($location->desc)) {   
	            $loc = $location->city;   
	            $full_loc = $location->province.$location->city.$location->district.$location->isp;   
	        } else {   
	            $loc = $location->desc;   
	        }
	        
	        return $loc;   
	    }
	}
?>