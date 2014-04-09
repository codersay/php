<?php
if (!defined('THINK_PATH')) exit();
return  array(
    /* 日志设置 */
    'LOG_RECORD'=>true,  // 进行日志记录

    /* 数据库设置 */
    'LOG_RECORD_LEVEL'       =>   array('EMERG','ALERT','CRIT','ERR','WARN','NOTIC','INFO','DEBUG','SQL'),  // 允许记录的日志级别
    'DB_FIELDS_CACHE'=> false,

    /* 运行时间设置 */
    'SHOW_RUN_TIME'=>false,          // 运行时间显示
    'SHOW_ADV_TIME'=>false,          // 显示详细的运行时间
    'SHOW_DB_TIMES'=>false,          // 显示数据库查询和写入次数
    'SHOW_CACHE_TIMES'=>false,       // 显示缓存操作次数
    'SHOW_USE_MEM'=>false,           // 显示内存开销
    'SHOW_PAGE_TRACE'=>false,        // 显示页面Trace信息 由Trace文件定义和Action操作赋值
    'APP_FILE_CASE'  =>   false, // 是否检查文件的大小写 对Windows平台有效 
	'HTML_CACHE_ON' => false,
'TMPL_CACHE_ON' => false, 
);
?>