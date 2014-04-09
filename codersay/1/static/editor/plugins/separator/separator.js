
	KindEditor.plugin('separator', function(K) {
		var self = this, name = 'separator';
		self.clickToolbar(name, function() {
			var cmd = self.cmd, range = cmd.range;
			self.focus();
			range.enlarge(true);
			cmd.split(true);
			//var tail = self.newlineTag == 'br' || K.WEBKIT ? '' : '<p id="__kindeditor_tail_tag__"></p>';
			self.insertHtml('[separator]');
			/*if (tail !== '') {
				var p = K('#__kindeditor_tail_tag__', self.edit.doc);
				range.selectNodeContents(p[0]);
				p.removeAttr('id');
				cmd.select();
			}
			*/
		});
	});