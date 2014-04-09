<?php

	/*

		Widget Name: WelcomeInfos

		Widget URI: http://www.codersay.net/

		Remark: 来访者欢迎信息，配合ndlog_unreal主题小工具，可单独调用。

		Title: 来访者欢迎信息

		Author: NickDraw

		Version: 1.0

		Author URI: http://www.codersay.net/

		Position: other

		Param: 

	*/

	class WelcomeInfosWidget extends Widget{

		public function render($data) {

			$var = array();

			//浏览器

			$browser = $this->getBrowser();

			if ( preg_match("/InternetsExplorer/i", $browser) && intval( end( explode(' ',$browser) ) ) <= 7 ){

				$var['browser'] = '哎呀，你OUT了，都神马年代了，你还使用这么低级的浏览器啊！推荐使用 Google Chrome。';

			}else{

				$var['browser'] = '你的浏览器：' . $browser;

			}

			//系统

			$os = $this->getOS();

			if ( $os == "Windows 95"

				|| $os == 'Windows ME'

				|| $os == 'Windows 98'

				|| $os == 'Windows 2000'

				|| $os == 'Windows NT'

				|| $os == 'Windows 32'

			){

				$var['os'] = '天哪，这年代你还在用这么神奇的系统！' . $os;

			}elseif( $os == 'Windows XP' ){

				$var['os'] = '你的系统：' . $os . '已经过时了！赶快升级吧。';

			}else{

				$var['os'] = '你的系统：' . $os;

			}

			//IP和定位

			import('ORG.Net.IpLocation'); // 导入IpLocation类

			$location = new IpLocation('UTFWry.dat');

			$ip = get_client_ip();

			$area = $location->getlocation($ip);

			$var['ipinfo'] = '嗨，欢迎你，来自' . $area['country'] . $area['area'] . '的朋友，你的IP：' . $ip;

			$var = array_merge($var,$data);

			// 渲染模版

	        $content = $this->renderFile('list', $var);

	        // 输出数据

	        return $content;

		}



		private function getBrowser() {

			global $_SERVER;



			$agent = $_SERVER['HTTP_USER_AGENT'];

			$browser = '';

			$browser_ver = '';



			if (preg_match('/OmniWeb/(v*)([^s|;]+)/i', $agent, $regs)) {

				$browser = 'OmniWeb';

				$browser_ver = $regs[2];

			}



			if (preg_match('/Netscape([d]*)/([^s]+)/i', $agent, $regs)) {

				$browser = 'Netscape';

				$browser_ver = $regs[2];

			}



			if (preg_match('/safari/([^s]+)/i', $agent, $regs)) {

				$browser = 'Safari';

				$browser_ver = $regs[1];

			}



			if (preg_match('/chrome/([^s]+)/i', $agent, $regs)) {

				$browser = 'Chrome';

				$browser_ver = $regs[1];

			}



			if (preg_match('/MSIEs([^s|;]+)/i', $agent, $regs)) {

				$browser = 'Internet Explorer';

				$browser_ver = $regs[1];

			}



			if (preg_match('/Opera[s|/]([^s]+)/i', $agent, $regs)) {

				$browser = 'Opera';

				$browser_ver = $regs[1];

			}



			if (preg_match('/NetCaptors([^s|;]+)/i', $agent, $regs)) {

				$browser = '(Internet Explorer ' . $browser_ver . ') NetCaptor';

				$browser_ver = $regs[1];

			}



			if (preg_match('/Maxthon/i', $agent, $regs)) {

				$browser = '(Internet Explorer ' . $browser_ver . ') Maxthon';

				$browser_ver = '';

			}



			if (preg_match('/FireFox/([^s]+)/i', $agent, $regs)) {

				$browser = 'FireFox';

				$browser_ver = $regs[1];

			}



			if (preg_match('/Lynx/([^s]+)/i', $agent, $regs)) {

				$browser = 'Lynx';

				$browser_ver = $regs[1];

			}



			if ($browser != '') {

				return $browser . ' ' . $browser_ver;

			} else {

				return 'Unknow browser';

			}

		}



		/**

		 * 取得客户真个操作体系

		 *

		 * @access private

		 * @return void

		 */

		private function getOS() {

			$agent = $_SERVER['HTTP_USER_AGENT'];

			$os = false;



			if (eregi('win', $agent) && strpos($agent, '95')) {

				$os = 'Windows 95';

			} else if (eregi('win 9x', $agent) && strpos($agent, '4.90')) {

				$os = 'Windows ME';

			} else if (eregi('win', $agent) && ereg('98', $agent)) {

				$os = 'Windows 98';

			} else if (eregi('win', $agent) && eregi('nt 6.0', $agent)) {

				$os = 'Windows Vista';

			} else if (eregi('win', $agent) && eregi('nt 6.1', $agent)) {

				$os = 'Windows 7';

			} else if (eregi('win', $agent) && eregi('nt 6.2', $agent)) {

				$os = 'Windows 8';

			} else if (eregi('win', $agent) && eregi('nt 5.1', $agent)) {

				$os = 'Windows XP';

			} else if (eregi('win', $agent) && eregi('nt 5', $agent)) {

				$os = 'Windows 2000';

			} else if (eregi('win', $agent) && eregi('nt', $agent)) {

				$os = 'Windows NT';

			} else if (eregi('win', $agent) && ereg('32', $agent)) {

				$os = 'Windows 32';

			} else if (eregi('linux', $agent)) {

				$os = 'Linux';

			} else if (eregi('unix', $agent)) {

				$os = 'Unix';

			} else if (eregi('sun', $agent) && eregi('os', $agent)) {

				$os = 'SunOS';

			} else if (eregi('ibm', $agent) && eregi('os', $agent)) {

				$os = 'IBM OS/2';

			} else if (eregi('Mac', $agent) && eregi('PC', $agent)) {

				$os = 'Macintosh';

			} else if (eregi('PowerPC', $agent)) {

				$os = 'PowerPC';

			} else if (eregi('AIX', $agent)) {

				$os = 'AIX';

			} else if (eregi('HPUX', $agent)) {

				$os = 'HPUX';

			} else if (eregi('NetBSD', $agent)) {

				$os = 'NetBSD';

			} else if (eregi('BSD', $agent)) {

				$os = 'BSD';

			} else if (ereg('OSF1', $agent)) {

				$os = 'OSF1';

			} else if (ereg('IRIX', $agent)) {

				$os = 'IRIX';

			} else if (eregi('FreeBSD', $agent)) {

				$os = 'FreeBSD';

			} else if (eregi('teleport', $agent)) {

				$os = 'teleport';

			} else if (eregi('flashget', $agent)) {

				$os = 'flashget';

			} else if (eregi('webzip', $agent)) {

				$os = 'webzip';

			} else if (eregi('offline', $agent)) {

				$os = 'offline';

			} else {

				$os = 'Unknown';

			}

			return $os;

		}



	}