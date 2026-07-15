function send_buycheaper(idProduct){
	var settings=window['sw24Buycheaper'+idProduct];
	var cForm=document.querySelector('#buycheaperPopup'+idProduct+' form');
	cForm.onsubmit=function(e){
		try {
			var checkbox = cForm.querySelectorAll('[type="checkbox"]')[0];
			if (!checkbox.checked) {
				return false;
			}
		} catch (error) {
		}
		
		e.preventDefault();
		var elements = this.querySelectorAll( "input, select, textarea" ), obj={};
		for(var i = 0; i < elements.length; i++) {
			var element = elements[i];
			if(element.name && element.value){
				obj[element.name] = element.value;
			}
		}

		BX.ajax({
			url: this.action,
			data: {
				'params':settings.params,
				'form':obj
			},
			method: 'POST',
			dataType: 'html',
			//dataType: 'json',
			timeout:300,
			scriptsRunFirst:true,
			async: true,
			onsuccess: function(data){
				cForm.innerHTML=data;
			},
			onfailure: function(data){
				console.warn(data);
			}
		});
		
		return false;
	}
	var popup = new BX.PopupWindow("popup-buycheaper", null, {
		content: BX('buycheaperPopup'+idProduct),
		autoHide : true,
		zIndex: 0,
		offsetTop : 1,
		offsetLeft : 0,
		className: 'sw24Buycheaper',
		lightShadow : true,
		closeIcon : true,
		closeByEsc : true,
		onPopupClose: function() {},
		overlay:{
			backgroundColor:'#000'
		}
	});
	popup.show();
}