
	var NDlog = {

		/*
		 * 设置默认表格隔行换色
		 * 如：setTableStyle( 'input[name="all"]', 'input[name="ids[]"]', '.rows_style' );
		 * __object 点击对象
		 * __selected 表格中需要选中的 checkbox 对象
		*/
		_setTableStyle : function( __object, __selected, __rows ){
			//设置全选元素事件
			var _object = $(__object);
			var _selected = $(__selected);
			var _rows = $(__rows);
			_object.click( function(){

			var _self = $(this);
				$.each( _selected, function(){
					var _this = $(this);
					if ( _this.attr('checked') ){
						_this.removeAttr('checked').parent().parent().removeClass('tr_selected tr_hover');
					}else{
						_this.attr("checked","checked").parent().parent().addClass('tr_selected tr_hover');
					}
				});
			});

			_rows.bind({
				click : function(){
					var _self = $(this);
					if ( _self.hasClass('tr_selected') == false ){
						_self.addClass('tr_selected tr_hover').find(__selected).attr("checked","checked");
					}else{
						_self.removeClass('tr_selected tr_hover').find(__selected).removeAttr("checked");
					}
				},
				mouseout : function(){
					if ( $(this).hasClass('tr_selected') == false ) $(this).removeClass('tr_hover');
				},
				mouseover : function(){
					if ( $(this).hasClass('tr_hover') == false ) $(this).addClass('tr_hover');
				}
			});
		},

		_showErrorInfo : function (element,info){
			var errorElement = element.next('.error_text');
			if ( errorElement.length == 0 ){
				element.addClass('error_input').focus().after('<span class="error_text">'+info+'</span>');
			}else{
				if ( !element.hasClass('error_input') ) element.addClass('error_input');
				element.focus();
				errorElement.text(info);
			}
		},

		_checkErrorInput : function ( element ){
			element.live('blur',function(){
				if ( $.trim( $(this).val() ) != '' ){
					var element = $(this).next('.error_text');
					if ( element.length > 0 ) element.remove();
					if ( $(this).hasClass('error_input') ) $(this).removeClass('error_input');
				}
			});
		},

		_getEnumOption : function( __object, __URL, __name_value ){
			var _object = $(__object);
			_object.live('change',function(){
				var _self = $(this);
				var _value = _self.val();
				var _name = _self.find('option:selected').text();
				var _type = _self.find('option:selected').attr('type');
				if ( _value == 0 ){
					_self.nextAll().remove();
				}else{
					_self.attr('name',__name_value);
					$.ajax({
						url : __URL,
						success : function ( _result ){
							if ( _result.status == 1 ){
								var _on = ' &nbsp;&nbsp;&nbsp; <select class="input_text getEnum">';
								_on += '<option value="0">不选为'+_name+'</option>';
								if(_result.data != null){
									for ( var i = 0; i < _result.data.length; i++ ) {
										_on += '<option value="'+_result.data[i].id+'" type="'+_result.data[i].type+'">'+_result.data[i].name+'</option>';
									}
									_on += '</select>';
									if ( _self.next('.getEnum').length > 0 ){
										_self.nextAll().remove();
									}

									_self.after(_on);
								}else{
									_self.nextAll().remove();
								}
							}else{
								_self.nextAll().remove();
							}
						},
						data : '&pid='+_value+'&type='+_type,
						type : 'GET',
						dataType : 'json',
						cache : false
					});
				}
			});
		}

	};