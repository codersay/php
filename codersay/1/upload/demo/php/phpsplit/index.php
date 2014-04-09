<?
error_reporting(E_NOTICE);
require("lib_splitword_full.php");

#$str = "浅析我国旅行社运作模式前景";
/*
 *经测试发现如果相邻的词是词组，则词会以当前的词与后一个词拼接为结果，这样会有问题的，比如我搜索
 *
 * '心田里' ,匹配的结果为 '心   田里' ,理论上来说'心田','田里','心田里' 都将被匹配为词组，这样
 * 才是正确的结果。
 */
$str = $_GET['str'];


$t1 = ExecTime();

$sp = new SplitWord();

$t2 = ExecTime();

$t0 = $t2-$t1;

echo "载入时间： $t0 <br><br>";


echo $sp->FindNewWord($sp->SplitRMM($str))."<hr>";
//echo $sp->SplitRMM($str)."<hr>";

$sp->Clear();

echo $str."<br>";

$t3 = ExecTime();
$t0 = $t3-$t2;
echo "<br>处理时间： $t0 <br><br>";


function ExecTime(){ 
	$time = explode(" ", microtime());
	$usec = (double)$time[0]; 
	$sec = (double)$time[1]; 
	return $sec + $usec; 
}
?>