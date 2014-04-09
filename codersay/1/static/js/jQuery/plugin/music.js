var musicPage = 1;

var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
browserVersion({'ie':'msie','firefox':'','chrome':'','opera':'','safari':'','maxthon':'','mozilla':'','webkit':''});
if(BROWSER.safari) {
	BROWSER.firefox = true;
}
BROWSER.opera = BROWSER.opera ? opera.version() : 0;

function browserVersion(types) {
	var other = 1;
	for(i in types) {
		var v = types[i] ? types[i] : i;
		if(USERAGENT.indexOf(v) != -1) {
			var re = new RegExp(v + '(\\/|\\s)([\\d\\.]+)', 'ig');
			var matches = re.exec(USERAGENT);
			var ver = matches != null ? matches[2] : 0;
			other = ver !== 0 ? 0 : other;
		}else {
			var ver = 0;
		}
		eval('BROWSER.' + i + '= ver');
	}
	BROWSER.other = other;
}

function _attachEvent(obj, evt, func) {
	if(obj.addEventListener) {
		obj.addEventListener(evt, func, false);
	} else if(obj.attachEvent) {
		obj.attachEvent("on" + evt, func);
	}
}

// search_input 按Enter搜索
function search_input_onkeypress(event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode
	if(keyCode == 13) {
		if((document.search_form.search_input.value != document.search_form.search_input.title) && (trim(document.search_form.search_input.value) != '')) {
			searchMusicList(1)
		} else {
			document.search_form.search_input.value = document.search_form.search_input.title;
		}
	}
}

// trim函数
function trim(str){  
	str = str.replace(/^(\s|\u00A0)+/,'');  
	for(var i=str.length-1; i>=0; i--){  
		if(/\S/.test(str.charAt(i))){  
			str = str.substring(0, i+1);  
			break;  
		}  
	}  
	return str;  
}

// search_bt 鼠标点击
function search_bt_onclick() {
	if((document.search_form.search_input.value != document.search_form.search_input.title) && (trim(document.search_form.search_input.value) != '')) {
		searchMusicList(1);
	}
}

function searchMusicList(Page){
	searchMusicLoading(true);
	musicPage = Page;
	var head = "search_result";
	var src1 = "http://www.xiami.com/app/nineteen/search/key/"+ encodeURIComponent(document.search_form.search_input.value) +"/page/"+ musicPage +"?random="+new Date().getTime()+".js&callback=getXiamiData";
	var JSONP = document.createElement("script") ;
	JSONP.type = "text/javascript";
	JSONP.src = src1;
	//在head之后添加js文件
	setTimeout(function(){document.getElementsByTagName("head")[0].appendChild(JSONP)}, 0);
	JSONP.onload = JSONP.onreadystatechange = function(){
		if (!this.readyState || this.readyState === "loaded" || this.readyState === "complete") {
			JSONP.onload = JSONP.onreadystatechange = null;//清内存，防止IE memory leaks
		}
	}
}

function searchMusicLoading(show) {
	if(show == true) {
		document.getElementById('search_zt').innerHTML = '搜索状态：正在搜索中……';
	} else {
		document.getElementById('search_zt').innerHTML = '搜索状态：';
	}
}

function getXiamiData(jsonData) {
	if(BROWSER.firefox) {
		document.getElementById('music_list').innerHTML = '';
		document.getElementById('self_set_pager_ui').innerHTML = '';
	} else {
		music_list.innerHTML = '';
		self_set_pager_ui.innerHTML = '';
	}
	var __musicList = '';
	if(jsonData.total == 0) {
		__musicList = '抱歉，没有找到关于 <font color="red">'+ document.search_form.search_input.value +'</font> 的音乐。';
		if(BROWSER.firefox) {
			document.getElementById('self_set_pager_ui').innerHTML = '';
		} else {
			self_set_pager_ui.innderHTML = '';
		}
		// return false;
	} else {
		for(var i in jsonData.results){
			__musicList += '<li id="'+jsonData.results[i].song_id+'" name="'+ decodeURIComponent(jsonData.results[i].song_name) +' -- '+ decodeURIComponent(jsonData.results[i].artist_name)+'">'+ decodeURIComponent(jsonData.results[i].song_name) +' -- '+ decodeURIComponent(jsonData.results[i].artist_name)+'</li>';
		}

		// pager
		if(jsonData.total > 8) {
			if(BROWSER.firefox) {
				document.getElementById('self_set_pager_ui').innerHTML = pagerView(parseInt(jsonData.total), parseInt(musicPage));
				var obja = document.getElementById('music_pager').getElementsByTagName("A");
				var objb = document.getElementById('music_list').getElementsByTagName("A");
			} else {
				self_set_pager_ui.innerHTML = pagerView(parseInt(jsonData.total), parseInt(musicPage));
				var obja = music_pager.getElementsByTagName("A");
				var objb = music_list.getElementsByTagName("A");
			}
			for(i=0; i<obja.length; i++) {
				_attachEvent(obja[i],'click', function(e){
					e = e ? e : event;
					obj = BROWSER.ie ? event.srcElement : e.target;
					searchMusicList(parseInt(obj.id.replace('page_to_', '')));
				});
			}
		} else {
			if(BROWSER.firefox) {
				document.getElementById('self_set_pager_ui').innerHTML = '';
			} else {
				self_set_pager_ui.innderHTML = '';
			}
		}
	}
	if(BROWSER.firefox) {
		document.getElementById('music_list').innerHTML = __musicList;
	} else {
		music_list.innerHTML = __musicList;
	}
	searchMusicLoading(false);
}

function pagerView(dataCount, currentPage){
	var __musicListPager = '<div class="pages" id="music_pager"><ul><li class="prevpage"><a href="javascript:void(0);" onFocus="this.blur()" unselectable="on" title="上一页" id="'+ (currentPage <= 1 ? 1 : currentPage - 1) +'">上一页</a></li>';

	var __totalPage = dataCount/8;
	__totalPage = __totalPage > parseInt(__totalPage) ? parseInt(__totalPage) + 1 : parseInt(__totalPage);
	var __forLength = currentPage > 10 ? (currentPage > 1000 ? 2 : 3) : 4;
	var __forStep = 2;
	var __forStart = (__totalPage > 4 && currentPage > __forStep) ? (currentPage < __totalPage - __forLength ? currentPage - __forStep : __totalPage - __forLength) : 1;
	var __forEnd = __forStart + __forLength < __totalPage + 1 ? __forStart + __forLength + 1 : __totalPage + 1;

	if(__totalPage > 4 && currentPage > __forStep + 1) __musicListPager += '<li><a href="javascript:void(0)" onFocus="this.blur()" unselectable="on" title="1" id="page_to_1">1...</a></li>';

	for ( var i = __forStart; i < __forEnd; i++ ) {
		if(currentPage == i) {
			__musicListPager += '<li><a href="javascript:void(0)" onFocus="this.blur()" unselectable="on" title="'+ i +'" id="page_to_'+ i +'" style="background-color:#839B1B; border:1px solid #839B1B;color: #FFFFFF">'+ i +'</a></li>';
		} else {
			__musicListPager += '<li><a href="javascript:void(0)" onFocus="this.blur()" unselectable="on" title="'+ i +'" id="page_to_'+ i +'" >'+ i +'</a></li>';
		}
	}

	if(__forEnd < __totalPage) __musicListPager += '<li><a href="javascript:void(0)" onFocus="this.blur()" unselectable="on" title="'+ __totalPage +'" id="page_to_'+ __totalPage +'">...'+ __totalPage +'</a></li>';

	if(currentPage < __totalPage) {
		currentPage++
		__musicListPager += '<li class="nextpage"><a href="javascript:void(0)" onFocus="this.blur()" unselectable="on" title="下一页" id="page_to_'+ currentPage +'">下一页</a></li>';
	}
	__musicListPager += '<li class="lastpage"><a href="javascript:void(0)" onFocus="this.blur()" unselectable="on" title="最后一页" id="page_to_'+ __totalPage +'">最后一页</a></li></ul></div>';
	return __musicListPager;
}

function insertMusic() {
	if(BROWSER.firefox) {
		var useShortcode = document.getElementById('useShortcode_chkbox').checked;
	} else {
		var useShortcode = document.search_form.useShortcode_chkbox.checked;
	}
	var musicInfo = document.getElementsByName("musicInfo")
	var txt = "";
	if(useShortcode) {
		for(i = 0; i < musicInfo.length; i++) {
			if(musicInfo[i].checked) {
				txt += '[xiami id="' + musicInfo[i].id + '"]' + musicInfo[i].value + '[/xiami]';
			}
		}
	} else {
		for(i = 0; i < musicInfo.length; i++) {
			if(musicInfo[i].checked) {
				txt += '<embed src="http://www.xiami.com/widget/470304_' + musicInfo[i].id + '/singlePlayer.swf" type="application/x-shockwave-flash" width="257" height="33" wmode="transparent"></embed>';
			}
		}
	}
	if(txt != "") {
		var ed = tinyMCEPopup.editor;
		ed.execCommand('mceInsertContent', false, txt);
		tinyMCEPopup.close();
	}
}