<?php
//检测用户系统支持的图片格式
global $cfg_photo_type,$cfg_photo_typenames,$cfg_photo_support;
$cfg_photo_type['gif'] = false;
$cfg_photo_type['jpeg'] = false;
$cfg_photo_type['png'] = false;
$cfg_photo_type['wbmp'] = false;
$cfg_photo_typenames = Array();
$cfg_photo_support = '';
if(function_exists("imagecreatefromgif") && function_exists("imagegif"))
{
	$cfg_photo_type["gif"] = true;
	$cfg_photo_typenames[] = "image/gif";
	$cfg_photo_support .= "GIF ";
}
if(function_exists("imagecreatefromjpeg") && function_exists("imagejpeg"))
{
	$cfg_photo_type["jpeg"] = true;
	$cfg_photo_typenames[] = "image/pjpeg";
	$cfg_photo_typenames[] = "image/jpeg";
	$cfg_photo_support .= "JPEG ";
}
if(function_exists("imagecreatefrompng") && function_exists("imagepng"))
{
	$cfg_photo_type["png"] = true;
	$cfg_photo_typenames[] = "image/png";
	$cfg_photo_typenames[] = "image/xpng";
	$cfg_photo_support .= "PNG ";
}
if(function_exists("imagecreatefromwbmp") && function_exists("imagewbmp"))
{
	$cfg_photo_type["wbmp"] = true;
	$cfg_photo_typenames[] = "image/wbmp";
	$cfg_photo_support .= "WBMP ";
}
//缩图片自动生成函数，来源支持bmp、gif、jpg、png
//但生成的小图只用jpg或png格式
function ImageResize($srcFile,$toW,$toH,$toFile="")
{
	global $cfg_photo_type;
	if($toFile=='') $toFile = $srcFile;
	$info = '';
	$srcInfo = GetImageSize($srcFile,$info);
	switch ($srcInfo[2])
	{
		case 1:
			if(!$cfg_photo_type['gif']) return false;
			$im = imagecreatefromgif($srcFile);
			break;
		case 2:
			if(!$cfg_photo_type['jpeg']) return false;
			$im = imagecreatefromjpeg($srcFile);
			break;
		case 3:
			if(!$cfg_photo_type['png']) return false;
			$im = imagecreatefrompng($srcFile);
			break;
		case 6:
			if(!$cfg_photo_type['bmp']) return false;
			$im = imagecreatefromwbmp($srcFile);
			break;
	}
	$srcW=ImageSX($im);
	$srcH=ImageSY($im);
	if($srcW<=$toW && $srcH<=$toH ) return true;
	$toWH=$toW/$toH;
	$srcWH=$srcW/$srcH;
	if($toWH<=$srcWH)
	{
		$ftoW=$toW;
		$ftoH=$ftoW*($srcH/$srcW);
	}
	else
	{
		$ftoH=$toH;
		$ftoW=$ftoH*($srcW/$srcH);
	}
	if($srcW>$toW||$srcH>$toH)
	{
		if(function_exists("imagecreatetruecolor"))
		{
			@$ni = imagecreatetruecolor($ftoW,$ftoH);
			if($ni)
			{
				imagecopyresampled($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
			}
			else
			{
				$ni=imagecreate($ftoW,$ftoH);
				imagecopyresized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
			}
		}
		else
		{
			$ni=imagecreate($ftoW,$ftoH);
			imagecopyresized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
		}
		switch ($srcInfo[2])
		{
			case 1:
				imagegif($ni,$toFile);
				break;
			case 2:
				imagejpeg($ni,$toFile,100);
				break;
			case 3:
				imagepng($ni,$toFile);
				break;
			case 6:
				imagebmp($ni,$toFile);
				break;
			default:
				return false;
		}
		imagedestroy($ni);
	}
	imagedestroy($im);
	return true;
}

function getFckEditor($fname, $fvalue, $nheight="350", $toolBarSet="HC", $gtype="", $fullPage="false") {
	require_once('Public/js/fckeditor/fckeditor.php');
	$fck = new FCKeditor($fname);
	$fck->BasePath = WEB_PUBLIC_PATH.'/js/fckeditor/';
	$fck->Width = '100%' ;
	$fck->Height = $nheight ;
	$fck->ToolbarSet = $toolBarSet ;
	$fck->Config['FullPage'] = $fullpage;
	$fck->Value = $fvalue;
	if($gtype=="print")
	{
		$fck->Create();
	}
	else
	{
		return $fck->CreateHtml();
	}
}
?>