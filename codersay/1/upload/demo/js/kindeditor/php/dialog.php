<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>KindEditor PHP</title>
	<link rel="stylesheet" href="../themes/default/default.css" />
	<link rel="stylesheet" href="../plugins/code/prettify.css" />
	<script charset="utf-8" src="../kindeditor.js"></script>
	<script charset="utf-8" src="../lang/zh_CN.js"></script>
	<script charset="utf-8" src="../plugins/code/prettify.js"></script>
	<script>
		KindEditor.ready(function(K) {
			var string = document.body.innerHTML;
			var dialog = K.dialog({
			        width : 500,
			        title : '测试窗口',
			        //body : '<div style="margin:10px;"><strong>内容</strong></div>',
			        body : string,
			        closeBtn : {
			                name : '关闭',
			                click : function(e) {
			                        dialog.remove();
			                }
			        },
			        yesBtn : {
			                name : '确定',
			                click : function(e) {
			                        alert(this.value);
			                }
			        },
			        noBtn : {
			                name : '取消',
			                click : function(e) {
			                        dialog.remove();
			                }
			        }
			});

		});
	</script>
</head>
<body>
<p>
啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊
</p>
</body>
</html>

