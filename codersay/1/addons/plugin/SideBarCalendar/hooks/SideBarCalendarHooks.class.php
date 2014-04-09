<?php
	/**
	* 
	*/
	class SideBarCalendarHooks extends Hooks
	{
		protected $table;//table表格
	    protected $currentDate;//当前日期
	    protected $year;    //年
	    protected $month;    //月
	    protected $days;    //给定的月份应有的天数
	    protected $dayofweek;//给定月份的 1号 是星期几
		
		public function sidebar_calendar($param)
		{
			$this->table="";
	        $this->year  = (isset($_GET["_URL_"][1]) && strtolower( $_GET["_URL_"][0] ) ==='archiver')? $_GET["_URL_"][1]:date("Y");
	        $this->month = isset($_GET["_URL_"][2])? $_GET["_URL_"][2]:date("m");
	        if ($this->month>12){//处理出现月份大于12的情况
	            $this->month=1;
	            $this->year++;
	        }
	        if ($this->month<1){//处理出现月份小于1的情况
	            $this->month=12;
	            $this->year--;
	        }
	        $this->currentDate = $this->year.'年'.$this->month.'月';//当前得到的日期信息
	        $this->days        = date("t",mktime(0,0,0,$this->month,1,$this->year));//得到给定的月份应有的天数
	        $this->dayofweek   = date("w",mktime(0,0,0,$this->month,1,$this->year));//得到给定的月份的 1号 是星期几

	        
			/*echo $style;
			echo '<div class="panel_content">' . $this->showCalendar() . '</div>';*/
			$this->assign('calendar', $this->showCalendar() );
			$this->display('showCalendar');
		}

	    /**
	     * 输出标题和表头信息
	     */
	    private function _showTitle()
	    {
	        $this->table="<table id=\"sidebar_calendar\"><thead><tr align='center'><th colspan='7' style='border:0; background:none;'>".$this->currentDate."</th></tr></thead>";
	        $this->table.="<tbody><tr>";
	        /*$this->table .="<th style='color:red'>星期日</th>";
	        $this->table .="<th>星期一</th>";
	        $this->table .="<th>星期二</th>";
	        $this->table .="<th>星期三</th>";
	        $this->table .="<th>星期四</th>";
	        $this->table .="<th>星期五</th>";
	        $this->table .="<th style='color:red'>星期六</th>";*/
	        $this->table .="<th style='color:red'>Sun</th>";
	        $this->table .="<th>Mon</th>";
	        $this->table .="<th>Tue</th>";
	        $this->table .="<th>Wed</th>";
	        $this->table .="<th>Thu</th>";
	        $this->table .="<th>Fri</th>";
	        $this->table .="<th style='color:green'>Sat</th>";
	        $this->table.="</tr>";
	    }
	    /**
	     * 输出日期信息
	     * 根据当前日期输出日期信息
	     */
	    private function _showDate()
	    {
	        $nums = $this->dayofweek+1;
	        $dmodel = M('Archives');
        
	        for ($i=1;$i<=$this->dayofweek;$i++){//输出1号之前的空白日期
	            $this->table.="<td style='background:#eee;'>&nbsp</td>";
	        }
	        for ($i=1;$i<=$this->days;$i++){//输出天数信息
	        	$trtime = strtotime($this->year.'-'.$this->month.'-'.$i.' 00:00:01');
	        	$sttime = strtotime($this->year.'-'.$this->month.'-'.$i.' 23:59:59');
	        	$count = $dmodel->where("create_time > '".$trtime."' AND create_time < '".$sttime."'")->count();
	        	if ( strlen( $i ) == 1 ) $i = '0'.$i;
	        	if ( $count > 0 ){
	        		$link = '<a href="'.U('/archiver/'.$this->year.'/'.$this->month.'/'.$i).'">'.$i.'<div class="acount">'.$count.'</div></a>';
	        	}else{
	        		$link = $i;
	        	}
	            if ($nums%7==0){//换行处理：7个一行
	                $this->table.="<td>$link</td></tr><tr>";
	            }else{
	                $this->table.="<td>$link</td>";
	            }
	            $nums++;
	        }
	        $this->table.="</tbody></table>";
	        $this->table.="<div class='calendar_btn'><a href='".U('/archiver/'.($this->year-1))."'>上一年</a>";
	        if ( ($this->month-1) < 1 ){
	        	$this->table.="<a href='".U('/archiver/'.($this->year-1).'/12')."'>上一月</a>";
	        }else{
	        	$this->table.="<a href='".U('/archiver/'.$this->year.'/'.($this->month-1))."'>上一月</a>";
	        }
	        if ( ($this->month+1) > 12 ){
	        	$this->table.="<a href='".U('/archiver/'.($this->year+1).'/01')."'>下一月</a>";
	        }else{
	        	$this->table.="<a href='".U('/archiver/'.$this->year.'/'.($this->month+1))."'>下一月</a>";
	        }
	        $this->table.="<a href='".U('/archiver/'.($this->year+1))."'>下一年</a></div><div class='clear'></div>";
	    }

	    private function showCalendar()
	    {
	        $this->_showTitle();
	        $this->_showDate();
	        return $this->table;
	    }

	}
?>