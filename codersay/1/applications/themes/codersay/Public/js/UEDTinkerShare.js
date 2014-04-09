UEDTinkerShare = {
	api : {},
	detail : {
		url : "",
		title : "",
		summary : "",
	    text : "",
	    pic : ""
	},
	setApi : function(json){
		this.api = json;
	},
	setDetail : function(json){
		this.detail = json;
	},
	doShare : function(type){
		if(!type) return false;
		var api = '';
		var url = this.isString(this.detail.url) ? this.detail.url : location.href;
		var tit = this.isString(this.detail.title) ? this.detail.title : document.title;
		var sum = this.isString(this.detail.summary) ? this.detail.summary : document.getElementsByName("description")[0].content;
		var pic = this.isString(this.detail.pic) ? this.detail.pic : "";
		var txt = this.isString(this.detail.text) ? this.detail.text : "";
		api = this.api[type].apiurl;
		if(api.indexOf("?") < 0) api += "?";
		else if(api.slice(api.length - 1, api.length) != "&") api += "&";
		api = api + (this.isString(this.api[type].url) ? this.api[type].url + "=" + url : "") + (this.isString(this.api[type].title) ? "&" + this.api[type].title + "=" + tit : "") + (this.isString(this.api[type].summary) ? "&" + this.api[type].summary + "=" + sum : "") + (this.isString(this.api[type].pic) ? "&" + this.api[type].pic + "=" + pic : "") + (this.isString(this.api[type].text) ? "&" + this.api[type].text + "=" + txt : "");
		api = encodeURI(api);
		window.open(api,'','width=700, height=400, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, location=yes, resizable=no, status=no');
	},
	isString : function(str){
		if(typeof str == "string") return true;
		else return false;
	}
}
//USE
share = UEDTinkerShare;
share.setApi({
	qzone : { 
		apiurl : "http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey",
		url : "url",
		title : "title"
	},
	renren : {
		apiurl : "http://share.renren.com/share/buttonshare",
		url : "link",
		title : "title"
	},
	t_sina : {
		apiurl : "http://v.t.sina.com.cn/share/share.php",
		url : "url",
		title : "title",
		pic : "pic"
	},
	pengyou : {
		apiurl : "http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?to=pengyou",
		url : "url",
		title : "title"
	},
	douban : {
		apiurl : "http://www.douban.com/recommend/",
		url : "url",
		title : "title",
		text : "comment"
	},
	t_qq : {
		apiurl : "http://v.t.qq.com/share/share.php",
		url : "url",
		title : "title",
		pic : "pic"
	},
	kaixin : {
		apiurl : "http://www.kaixin001.com/repaste/bshare.php",
		url : "rurl",
		title : "rtitle",
		summary : "rcontent"
	},
	itieba : {
		apiurl : "http://tieba.baidu.com/i/app/open_share_api",
		url : "link",
		title : "title"
	},
	msn : {
		apiurl : "http://profile.live.com/badge/?url",
		url : "link",
		title : "title",
		text : '&msg=&screenshot=&description='
	},
	twitter : {
		apiurl : "http://twitter.com/home/?status=",
		url : "link",
		title : "title"
	},
	digg : {
		apiurl : "http://digg.com/submit?type=0&url=",
		url : "url"
	},
	facebook : {
		apiurl : "http://www.facebook.com/sharer.php?u=",
		url : "url",
		title : "title"
	},
	neteasy_weibo : {
		apiurl : "http://t.163.com/article/user/checkLogin.do?link=http://news.163.com/&source=&info=",
		url : "url",
		title : "title"
	},
	rss : {
		apiurl : " ",
		url : "url",
		title : "title"
	}
});
share.setDetail({
	url : "http://www.uedthinker.com",
});