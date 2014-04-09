// 导航栏配置文件
var outlookbar=new outlook();
var t;
t=outlookbar.addtitle('基本设置','系统设置',1)
outlookbar.additem('更改登录密码',t,'/Admin/Sys/changePwd')

t=outlookbar.addtitle('日志类别管理','日志管理',1)
outlookbar.additem('添加分类',t,'/Admin/Post/addPostCtg')
outlookbar.additem('管理分类',t,'/Admin/Post/postCtgList')

t=outlookbar.addtitle('日志管理','日志管理',1)
outlookbar.additem('添加日志',t,'/Admin/Post/addPost')
outlookbar.additem('管理日志',t,'/Admin/Post/postList')

t=outlookbar.addtitle('单页管理','日志管理',1)
outlookbar.additem('添加单页',t,'/Admin/Page/addPage')
outlookbar.additem('管理单页',t,'/Admin/Page/pageList')

t=outlookbar.addtitle('友情链接','SEO管理',1)
outlookbar.additem('添加链接',t,'/Admin/Link/addLink')
outlookbar.additem('链接管理',t,'/Admin/Link/linkList')
