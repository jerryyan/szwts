$._id=1;
$._getId=function(){
	var id=$._id;
	$._id++;
	return id;
}

$.loadEditor=function(obj){
	obj.xheditor({upLinkUrl:'',upLinkExt:"zip,rar,txt",upMultiple:'1',upImgUrl:'',upImgExt:"jpg,jpeg,gif,png",upFlashUrl:'',upFlashExt:"swf",upMediaUrl:'',upMediaExt:"wmv,avi,wma,mp3,mid"});
}

$.loadCalendar=function(obj){
	
	obj.datebox({
		editable:false,
		formatter:function(date){
			var y = date.getFullYear();
			var m = date.getMonth() + 1;
			if(m < 10) m = '0'+m;
			var d = date.getDate();
			if(d < 10) d='0'+ d;
			return y + "-" + m + "-" + d;
		}
	});
	obj.datebox('calendar').calendar({
		weeks:['日','一','二','三','四','五','六'],
		months:['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月',]
	});
}

$(document).ready(function(){
	$('#tt').tabs();	
	var p = window._menu_;
	for(var i=0; i<p.length; i++){
		var o = p[i];
		$("#allmenu").accordion('add',{
			title: o.title,
			content: '<div id="navTree'+i+'" class="all_menu easyui-tree"></div>'
		});
		if(o.children)
		$('#navTree'+i).tree("loadData", o.children);
	}
	$('.all_menu').tree({
		onClick:function(node){
			var title=node.attributes.title;
			var name=node.text;			
			if(title!=""){
				var tab=$('#tt').tabs("getTab",name);				
				if(tab==null || tab==undefined){
					$("#tt").tabs("add",{
						title:name,
						closable:true,
						href:node.attributes.title
					});	
					//alert('aa');
				}else{
					$("#tt").tabs("select",name);
				}
			}
			return false;
		}
	});
});

$.addWindow=function(divObj,obj){	
	var tid='s'+$._getId();
	
	divObj.append("<div id='"+tid+"'></div>");
	obj['height']= obj.height==undefined?500:obj.height;
	obj['onClose'] = function(){
			$(this).window('destroy');
		};
	$("#"+tid).data("parent_window",divObj);
	$("#"+tid).window(obj);
}