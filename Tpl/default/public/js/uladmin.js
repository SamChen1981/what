var isie6 = navigator.userAgent.search(/msie 6.0/gi) != -1;
var isSafari = navigator.userAgent.search(/AppleWebKit/gi) != -1;
var temporary = new Date().getTime();
var tfengyun = {
	$: function() {
		return document.getElementById(arguments[0]);
	},
	add : function(obj,type,val) { // add Event
		if(obj.attachEvent) {
			obj.attachEvent('on'+type,val);
		}else {
			obj.addEventListener(type,val,false);
		}
	},
	del : function(obj,type,val) {  // del Event
		if(obj.detachEvent) {
			obj.detachEvent('on'+type,val);
		}else {
			obj.removeEventListener(type,val,false);
		}
	}
}

/* firefox */
function __firefox(){
    HTMLElement.prototype.__defineGetter__("runtimeStyle", __element_style);
    window.constructor.prototype.__defineGetter__("event", __window_event);
    Event.prototype.__defineGetter__("srcElement", __event_srcElement);
}
function __element_style(){
    return this.style;
}
function __window_event(){
    return __window_event_constructor();
}
function __event_srcElement(){
    return this.target;
}
function __window_event_constructor(){
    if(document.all){
        return window.event;
    }
    var _caller = __window_event_constructor.caller;
    while(_caller!=null){
        var _argument = _caller.arguments[0];
        if(_argument){
            var _temp = _argument.constructor;
            if(_temp.toString().indexOf("Event")!=-1){
                return _argument;
            }
        }
        _caller = _caller.caller;
    }
    return null;
}
var ua = navigator.userAgent.toLowerCase();
if(window.addEventListener && ua.match(/firefox/)){
    __firefox();
   
}
/* end firefox */

//cookie
var CookieHelper = {
	setCookie:function(name, value, expiry, path, domain, secure){
		var nameString = name + "=" + value;
		var expiryString = "";
		if (expiry != null) {
			try {
				expiryString = "; expires=" + expiry.toGMTString();
			} 
			catch (e) {
				if (expiry) {
					var lsd = new Date();
					lsd.setTime(lsd.getTime() + expiry * 1000);
					expiryString = "; expires=" + lsd.toGMTString()
				}
			}
		}
		var pathString = (path == null) ? " ;path=/" : " ;path = " + path;
		var domainString = (domain == null) ? "" : " ;domain = " + domain;
		var secureString = (secure) ? ";secure=" : "";
		document.cookie = nameString + expiryString + pathString + domainString + secureString;
	},
	getCookie : function(name) {
		var i, aname, value, ARRcookies = document.cookie.split(";");
		for (i = 0; i < ARRcookies.length; i++) {
			aname = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
			value = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
			aname = aname.replace(/^\s+|\s+$/g, "");
			if (aname == name) {
				return unescape(value);
			}
		}

		return '';
	}
};

function GetItemData(data, item)
{
	data = "data" + data;
	var SItem = "<" + item + ">";
	var EItem = "</" + item + ">";
	var StrLen = SItem.length;
	var Begin = 0;

	if((Begin =  data.indexOf(SItem, Begin))){
		var End = data.indexOf(EItem, Begin + StrLen);
		if(End - Begin > StrLen){
			var ItemText = data.substring(Begin + StrLen,End);
			return ItemText;
		}
	}
	return "";
}

function ExtractStringList(data, item)
{
    data = "data" + data;
	if (data.length == 0)
		return;

	var itemlist = [];
	var strStart = "<" + item + ">";
	var strEnd = "</" + item + ">";

	var Start = 1;
	var End   = 1;

	while ((Start = data.indexOf(strStart, Start)) > 0) {
		var End = data.indexOf(strEnd, Start+1);
		if (End > Start) {
			var LineData = data.substring(Start + strStart.length, End);
			itemlist.push(LineData);
		
			// 载入完成
			Start = End;
		} else break;
	}

	return itemlist;
}





function barSwitch(options) {
	this.o = {
		obj:'',
		switchButton:'',
		SwitchDiv:''
	};
	for(var i in options) {
		this.o[i] = options[i];
	}
	this.obj=typeof this.o.obj=='string'?$('#'+this.o.obj):this.o.obj;
	this._switch();
}

barSwitch.prototype={
	_switch:function() {
		var scope_this=this;
		this.obj.find(this.o.switchButton).each(function() {
			$(this).hover(function() {
				$(this).find(scope_this.o.SwitchDiv).show();
			},function() {
				$(this).find(scope_this.o.SwitchDiv).hide();
			});
		});
	}
};

function SelectOptionFn(obj,options) {
	this.divId = obj;
	this.obj = typeof obj=='string'?$('#'+obj):obj;//div 
	this.o={
		opDiv: '', //div class
		openClose: false,
		nodeType:'',
		run: function() {}
	};
	for(var i in options) {
		this.o[i] = options[i];
	}
	var scope_this=this;
	this.o.openClose ? this.obj.find('.'+this.o.opDiv).hide() : this.obj.find('.'+this.o.opDiv).show();
	this.registerObjClick();
	this.optionFn();
}

SelectOptionFn.prototype={
		registerObjClick:function() {
			//show the child div and register body click		
			var scope_this=this;
			this.obj.click(function(){
				scope_this.showHideOptions();
			});	
		},
		//show the child div and register body click event
		showHideOptions:function(){
			if(this.o.openClose) {
				this.obj.css('position','relative');
				this.obj.find('.'+this.o.opDiv).show();
				this.o.openClose=false;
				
				//registerHideEvent
				this.registerHideEvent();
				
			}else {

				this.obj.css('position','static');
				this.obj.find('.'+this.o.opDiv).hide();
				this.o.openClose=true;
				//removeHideEvent
				this.removeHideEvent();
			}
		},

		//add body click
		registerHideEvent:function(){
			var scope_this=this;
			if(!this.bodyClickHandler){
				
				this.bodyClickHandler=function(){
						scope_this.showHideOptions();
				}
			}
			setTimeout(function() {
				if (window.attachEvent){
					document.body.attachEvent('onclick',scope_this.bodyClickHandler);
				}else{
					document.body.addEventListener('click',scope_this.bodyClickHandler,false);
				}
			},200);
		},
		//remove body click
		removeHideEvent:function(){
			if(this.bodyClickHandler) {
				if (window.attachEvent){
					document.body.detachEvent('onclick',this.bodyClickHandler);
				}else{
					document.body.removeEventListener('click',this.bodyClickHandler,false);
				}
			}
		},
		optionFn:function() {
			var scope_this=this;
			this.obj.find('.'+this.o.opDiv).find(this.o.nodeType).each(function(i) {
				$(this).hover(function() {
					$(this).removeClass('style2').addClass('style1');			   
				},function() {
					$(this).removeClass('style1').addClass('style2');										 
				});
				$(this).click(function() {
					scope_this.obj.find('em').text($(this).text());
					scope_this.o.run($(this).attr('val'));
				});
			});
		}
};


function SaveAccount(businessman_id,repost_status_price,send_status_price) {
	this.businessman_id=businessman_id;
	this.repost_status_price=repost_status_price;
	this.send_status_price=send_status_price;
}

var actionData=[];
var pagingBase = 10;
var actionArr=['','','','','','','','','','','','','','','',''];
var pageNum = 1,actionPage='',pubAction=''; 
function getActionList(action) {
	pubAction=action;
	loadDiv(true,'正在加载...');
	if(action=='star') {
		$('#weetFilter').hide();
		$('#dxtbg').hide();
		$('#keywordTitle').text('搜索');
		var requrl = 'ads.php?action=bm_view_famous'+'&keyword='+actionArr[11]+'&page='+pageNum+'&count=12';
		getData({url:requrl,successFn:function(txt) {
			var listNum = ExtractStringList(txt , 'total_count');
			var accountLi = ExtractStringList(txt , 'famousaccount');
			var str = '';
			if(accountLi.length<1) {
				loadDiv(false);
				$('#bloggerlist>ul').html('<li style="text-align:center;line-height:40px;font-size:14px;">没有符合条件的数据</li>');
				$('#page').html('');
				$('#pageT').html('');
				return;
			}
			for(var i=0;i<accountLi.length;i++) {
				var des = GetItemData(accountLi[i] , 'description'),ld=0,s='';
				for(var loop=0;loop<des.length;loop++){
					des.charCodeAt(loop)>255?ld+=2:ld++;
					if(ld<44) s+=des.substring(loop,loop+1);
				}
				if(ld>=44) s+='...';
				str+='<dl style="width:209px; margin-right:21px; _margin-right:18px; margin-left:4px; _margin-left:3px; margin-top:15px;">' +
										  '<dt style="width:209px; height:209px;  border:1px solid #d8d8d8; margin-bottom:6px;" >' +
											   '<a href="'+GetItemData(accountLi[i] , 'url')+'" target="_blank"><img border="0" style="margin:4px; _margin-bottom:-1px;width:201px;" src="'+GetItemData(accountLi[i] , 'head_image')+'"/></a>' +
										  '</dt>' +
										  '<dd style="width:205px;">' +
												'<dl>' +
													' <dt style="font-size:14px;"><a href="'+GetItemData(accountLi[i] , 'url')+'" target="_blank" class="bluelink"><b>'+GetItemData(accountLi[i] , 'title')+'</b></a> '+GetItemData(accountLi[i] , 'location')+'</dt>' +
													' <dd><img style="margin-top:2px; _margin-top:5px;" src="images/sv.png" /> <img style="margin-top:2px; _margin-top:5px;" src="'+(GetItemData(accountLi[i] , 'gender')==1?'images/m.png':'images/icon7.png')+'" /></dd>' +
												'</dl>' +
										  '</dd>' +
										  ' <dd style="width:205px;">' +
											  '<b class="blue">粉丝数：</b>'+GetItemData(accountLi[i] , 'followers_count')+
										   '</dd>' +
										   '<dd style="width:205px; height:48px;overflow:hidden;">' +
											   '<P>'+s+'</P>' +
										   '</dd>' +
								  ' </dl>';
			}
			$('#bloggerlist>ul').html(str);
			loadDiv(false);
			var total_pages=Math.ceil(parseInt(listNum)/12);
			
			if(total_pages>1) {
			$('#page').show();
			$('#pageT').show();
			var  paging=SmnPagination.load_paging_data(pageNum,12,total_pages);
	
			//首页和上一页
			var html='<li num="'+paging.first_link+'" >首页</li>'+
			'<li num="'+paging.prev_link+'" >上一页</li>';
			
			//中间的页码
			for(var i=0;i<paging.numbers.length;i++){
				
				if(paging.numbers[i].is_current){
					//当前页
				html+='<li num="'+paging.numbers[i].number+'" class="h">'+paging.numbers[i].number+'</li>';
				}else{
					//非当前页
				html+='<li num="'+paging.numbers[i].number+'" >'+paging.numbers[i].number+'</li>';
				}
			}
			
			//下一页和末页
			html+='<li num="'+paging.next_link+'" >下一页</li>'+
				'<li num="'+paging.last_link+'">末页</li>';
			$('#page').html(html);
			$('#pageT').html(html);
			//注册点击具体页事件
			$('#page li').click(function(){
				$(document).scrollTop(0);
				pageNum=parseInt($(this).attr('num'));
				getActionList(action);
			});
			$('#pageT li').click(function(){
				$(document).scrollTop(0);
				pageNum=parseInt($(this).attr('num'));
				getActionList(action);
			});
			}else {
				$('#page').hide();
				$('#pageT').hide();
			}
		},errorFn:function() {
			loadDiv(false);
			alert('加载失败');
		}});
		
		
	}else {
	//$('#centerCount').show();
	var requrl = 'ads.php?action=bm_query_account&query='+action+'&id='+$CONFIG.id+"&activity_id="+$CONFIG['activity_id']+"&rd="+Math.random()+'&orderby='+actionArr[0]+'&platform='+actionArr[1]+'&verified='+actionArr[2]+'&sendprice_min='+actionArr[5]+'&sendprice_max='+actionArr[6]+'&repostprice_min='+actionArr[7]+'&repostprice_max='+actionArr[8]+'&followers_count_min='+actionArr[9]+'&followers_count_max='+actionArr[10]+'&activefans_ratio_min='+actionArr[12]+'&activefans_ratio_max='+actionArr[13]+'&keyword='+actionArr[11]+'&gender='+actionArr[14]+'&province='+actionArr[15]+'&page='+pageNum+'&count='+pagingBase;
	
	
	getData({url:requrl,successFn:function(txt) {
		$('#allCheckbox').attr('checked',false);
			var listNum = ExtractStringList(txt , 'total_count');
			var accountLi = ExtractStringList(txt , 'account');
			var str = '';
			if(accountLi.length<1) {
				loadDiv(false);
				$('#bloggerlist>ul').html('<li style="text-align:center;line-height:40px;font-size:14px;">没有符合条件的数据</li>');
				$('#page').html('');
				$('#pageT').html('');
				return;
			}
			for(var i=0;i<accountLi.length;i++) {
				actionData[i] = new SaveAccount(GetItemData(accountLi[i] , 'id'),GetItemData(accountLi[i] , 'repost_status_price'),GetItemData(accountLi[i] , 'send_status_price'));
				var verified = GetItemData(accountLi[i] , 'verified')=='true'?'<img src="http://image.tfengyun.com/image/v.gif" border="0" style="margin-top:-2px;" />':'';
						var weibo_type =  GetItemData(accountLi[i] , 'platform')=='新浪微博'?'<img src="images/XL.png" style="margin-top:3px;" alt="新浪微博主" />':'<img src="images/TX.png" style="margin-top:3px;" align="absmiddle" alt="腾讯微博主" />';
						
						if(parseInt(GetItemData(accountLi[i] , 'activefans_ratio'))<5) {
							var activefans_ratio = '<b>低</b> <img src="images/lowlevel.png" align="absmiddle" />';
						}else if(parseInt(GetItemData(accountLi[i] , 'activefans_ratio'))>=5&&parseInt(GetItemData(accountLi[i] , 'activefans_ratio'))<30) {
							var activefans_ratio = '<b>中</b> <img src="images/midlevel.png" align="absmiddle" />';
						}else if(parseInt(GetItemData(accountLi[i] , 'activefans_ratio'))>=30){
							var activefans_ratio = '<b>高</b> <img src="images/level.png" align="absmiddle" />';
						}else {
							var activefans_ratio = '--';
						}
						
						var province_ratio = ExtractStringList(accountLi[i], 'item');
						var pr = '';
						for(var o=0,loop=province_ratio.length;o<loop;o++) {

							pr += GetItemData(province_ratio[o],'name')+'('+parseFloat(parseFloat(GetItemData(province_ratio[o],'ratio'))*1000)/10+'% , '+GetItemData(province_ratio[o],'value')+') ';
						}
						
						if(action=='collecting') {
						
						
							var workstatic='<span style="cursor:pointer;" class="collection" title="移出收藏">移出收藏</span>' +
						  '</tr>';
						  }else if(action=='black') {
							var workstatic = '<span style="cursor:pointer;" class="blankd" title="移出黑名单">移出黑名单</span>' +
						  '</tr>';
						  }else {
							if(GetItemData(accountLi[i] , 'is_collected')==1) {
									var workstatic = '已收藏';
							}else {
							var workstatic = '<span style="cursor:pointer;" class="collection" title="点击收藏">收藏</span> | <span style="cursor:pointer;" class="blankd" title="点击加入黑名单">黑名单</span>';
							}
						  }
						  if((parseInt(GetItemData(accountLi[i] , 'handle_direct'))!=0)) 
							var zfj = '￥'+GetItemData(accountLi[i] , 'send_status_price');
						else 
							var zfj = '<s style="color:#646464;">￥'+GetItemData(accountLi[i] , 'send_status_price')+'</s>';
						  
						 if( GetItemData(accountLi[i] , 'female')!='') 
							var female = parseInt(parseFloat(GetItemData(accountLi[i] , 'female'))*100);
						 else 
							var female = '--';
						  if(GetItemData(accountLi[i] , 'male')!='')
							var male = parseInt(parseFloat(GetItemData(accountLi[i] , 'male'))*100);
						  else 
							var male = '--';
				switch($CONFIG.pageName) {
					case 'worder':
						if(GetItemData(accountLi[i] , 'platform')=='新浪微博') {
							var jd='<dd style="width:274px;">受众性别比例：<img style="margin-right:2px;"src="images/man.png" /><b>'+male+'%</b><img style="margin-right:2px;" src="images/women.png" /><b>'+female+'%</b></dd>' 
						}else {
							var jd='';
						}
						str+='<li>' +
								  '<dl style="width:102px; margin:0 0 0 2px;">' +
										 '<dt style="width:90px; height:90px; border:1px solid #d8d8d8; margin:0 0 4px 0;" >' +
											 '<img style="margin:2px; _margin-bottom:-2px;width:86px; height:86px;" src="'+GetItemData(accountLi[i] , 'head_image')+'"/></dt>' +
										 '<dd style="width:90px; height:20px;  border:1px solid #d8d8d8;">' +
												 '<dl>' +
													'<dt style="height:20px; line-height:19px; width:88px; text-align:center; padding-top:1px;">'+workstatic+'</dt>' +
												'</dl>' +
										   '</dd>' +
								   '</dl>' +
								   '<dl style="width:298px; margin:0;">' +
										'<dd>' +
												 '<dl style="width:290px;">' +
												 '<dd>'+weibo_type+'</dd>' +
													   '<dt>　<a href="'+GetItemData(accountLi[i] , 'url')+'" class="bluelink" target="_blank"><b style="font-size:16px;">'+GetItemData(accountLi[i] , 'title')+'</b></a></dt>' +
													   '<dd style="padding:0 3px;">'+verified+'</dd>' +
													   '<dd style="padding-top:2px; height:22px;">('+GetItemData(accountLi[i] , 'province')+')</dd>' +
													     '<dd style="padding:0 3px;"><img style="margin-top:5px;" src="'+(GetItemData(accountLi[i] , 'gender')==1?'images/m.png':'images/icon7.png')+'" /></dd>' +
												 '</dl>' +
										  '</dd>' +
										  '<dd>' +
												  '<dl style="width:290px;">' +
														'<dt  style="padding-top:2px; height:22px; color:#0e72e0;">粉丝数量</dt>' +
														'<dd style="font-size:16px; color:#ff2900;margin-left:4px;"><b>'+GetItemData(accountLi[i] , 'followers_count1')+'</b></dd>' +
												  '</dl>' +
										  '</dd>' +
										 '<dt style="width:285px;">'+GetItemData(accountLi[i] , 'description')+'</dt>' +
										  '<dd style="width:285px;"><b>标签：</b><span class="blue">'+GetItemData(accountLi[i] , 'tags')+'</span></dd>' +
								   '</dl>' +
								   '<dl style="width:165px;">' +
										'<dt style="width:165px;">转发价格</dt>' +
										'<dd style="width:165px; font-size:16px; color:#ff2900;"><b>￥'+GetItemData(accountLi[i] , 'repost_status_price')+'</b><span style="font-size:12px; color:#666;">元</span></dd>' +
										'<dd style="width:165px;">直发价格</dd>' +
										'<dd style="width:165px; font-size:16px; color:#0e72e0;"><b>'+zfj+'</b><span style="font-size:12px; color:#666;">元</span></dd>' +
										'<dd style="width:165px;">万粉丝直发单价￥'+Math.round(parseInt(GetItemData(accountLi[i] , 'send_status_price'))/parseInt(GetItemData(accountLi[i] , 'followers_count'))*10000*100)/100+'元</dd>' + 
								   '</dl>' +
								   '<dl  style="width:274px;">' +
									   '<dt style="width:274px;">活跃粉丝率 '+activefans_ratio+'</dt>' +
										'<dd style="width:274px;">平均评论数 <b>'+GetItemData(accountLi[i] , 'comment_count')+'</b></dd>' +
										'<dd style="width:274px;">平均转发数 <b>'+GetItemData(accountLi[i] , 'repost_count')+'</b></dd>' +jd +
										'<dd style="width:274px;">受众地域：<span style="color:#999;">'+pr+'</span></dd>' +
								   '</dl>' +
								   '<dl style="width:78px;">' +
										 '<dt style="width:78px;">' +
											   '<dl>' +
													 '<dt style="width:65px;">是否接单</dt>' +
													 '<dd>'+(parseInt(GetItemData(accountLi[i] , 'handle_order'))!=0?'<b style="color:#3dbe01;">是</b>':'<b style="color:#ff2900">否</b>')+'</dd>' +
											   '</dl>' +
										 '</dt>' +
										 '<dd style="width:78px;">' +
											  '<dl>' +
													 '<dt style="width:65px;">是否直发</dt>' +
													 '<dd>'+(parseInt(GetItemData(accountLi[i] , 'handle_direct'))!=0?'<b style="color:#3dbe01;">是</b>':'<b style="color:#ff2900">否</b>')+'</dd>' +
											  '</dl>' +
										 '</dd style="width:78px;">' +
										  '<dd>' +
											   '<dl>' +
													'<dt style="width:65px;">是否接硬广</dt>' +
													'<dd>'+(parseInt(GetItemData(accountLi[i] , 'handle_hard'))!=0?'<b style="color:#3dbe01;">是</b>':'<b style="color:#ff2900">否</b>')+'</dd>' +
											  '</dl>' +
										 '</dd>' +
								   '</dl>' +
					   '</li>';
					  actionPage = action;
					break;
					case 'step2':
						var checkbox = parseInt(GetItemData(accountLi[i] , 'handle_order'))!=0?'<input type="checkbox"  />':'&nbsp;';
						var add = parseInt(GetItemData(accountLi[i] , 'handle_order'))!=0?'<span style="cursor:pointer;" class="add blue"><img src="images/icon_tj.jpg" /></span>':'';
						if($CONFIG['activity_type']=='1') {
							var jd='<dd style="width:274px;">受众性别比例：<img style="margin-right:2px;"src="images/man.png" /><b>'+male+'%</b><img style="margin-right:2px;" src="images/women.png" /><b>'+female+'%</b></dd>' 
						}else {
							var jd='';
						}
						str+='<li>' +
									 '<dl style="width:20px;">'+checkbox+'</dl>' +
									  ' <dl style="width:102px; margin:0 0 0 2px;">' +
											   '<dt style="width:90px; height:90px; border:1px solid #d8d8d8; margin:0 0 4px 0;" >' +
												   '<img style="margin:2px; _margin-bottom:-2px;width:86px; height:86px;" src="'+GetItemData(accountLi[i] , 'head_image')+'"/></dt>' +
											   '<dd style="width:90px; height:20px;  border:1px solid #d8d8d8;">' +
													 '<dl>' +
														  '<dt style="height:20px; line-height:19px; width:88px; text-align:center; padding-top:1px;">'+workstatic+'</dt>' +
										 '</dl>' +
											  ' </dd>' +
									   '</dl>' +
									   '<dl style="width:278px; margin:0;">' +
											'<dd>' +
													' <dl style="width:270px;">' +
														'<dd>'+weibo_type+'</dd>' +
														   '<dt>　<a href="'+GetItemData(accountLi[i] , 'url')+'" class="bluelink" target="_blank"><b style="font-size:16px;">'+GetItemData(accountLi[i] , 'title')+'</b></a></dt>' +
														   '<dd style="padding:0 3px;">'+verified+'</dd>' +
													   '<dd style="padding-top:2px; height:22px;">('+GetItemData(accountLi[i] , 'province')+')</dd>' +
													     '<dd style="padding:0 3px;"><img style="margin-top:5px;" src="'+(GetItemData(accountLi[i] , 'gender')==1?'images/m.png':'images/icon7.png')+'" /></dd>' +
													 '</dl>' +
											  '</dd>' +
											  '<dd>' +
													   '<dl style="width:270px;">' +
														'<dt  style="padding-top:2px; height:22px; color:#0e72e0;">粉丝数量</dt>' +
														'<dd style="font-size:16px; color:#ff2900;margin-left:4px;"><b>'+GetItemData(accountLi[i] , 'followers_count1')+'</b></dd>' +
												  '</dl>' +
											  '</dd>' +
											  '<dt style="width:265px;">'+GetItemData(accountLi[i] , 'description')+'</dt>' +
										  '<dd style="width:265px;"><b>标签：</b><span class="blue">'+GetItemData(accountLi[i] , 'tags')+'</span></dd>' + 
									   '</dl>' +
									  ' <dl style="width:165px;">' +
											'<dt style="width:165px;">转发价格</dt>' +
										'<dd style="width:165px; font-size:16px; color:#ff2900;"><b>￥'+GetItemData(accountLi[i] , 'repost_status_price')+'</b><span style="font-size:12px; color:#666;">元</span></dd>' +
										'<dd style="width:165px;">直发价格</dd>' +
										'<dd style="width:165px; font-size:16px; color:#0e72e0;"><b>'+zfj+'</b><span style="font-size:12px; color:#666;">元</span></dd>' +
										'<dd style="width:165px;">万粉丝直发单价￥'+Math.round(parseInt(GetItemData(accountLi[i] , 'send_status_price'))/parseInt(GetItemData(accountLi[i] , 'followers_count'))*10000*100)/100+'元</dd>' + 
									  ' </dl>' +
									   '<dl  style="width:274px;">	' +  
											 '<dt style="width:274px;">活跃粉丝率 '+activefans_ratio+'</dt>' +
										'<dd style="width:274px;">平均评论数 <b>'+GetItemData(accountLi[i] , 'comment_count')+'</b></dd>' +
										'<dd style="width:274px;">平均转发数 <b>'+GetItemData(accountLi[i] , 'repost_count')+'</b></dd>' +jd+
										'<dd style="width:274px;">受众地域：<span style="color:#999;">'+pr+'</span></dd>' +
									  ' </dl>' +
									   '<dl style="width:78px;">' +
											  '<dt style="width:78px;">' +
											   '<dl>' +
													 '<dt style="width:65px;">是否接单</dt>' +
													 '<dd>'+(parseInt(GetItemData(accountLi[i] , 'handle_order'))!=0?'<b style="color:#3dbe01;">是</b>':'<b style="color:#ff2900">否</b>')+'</dd>' +
											   '</dl>' +
										 '</dt>' +
										 '<dd style="width:78px;">' +
											  '<dl>' +
													 '<dt style="width:65px;">是否直发</dt>' +
													 '<dd>'+(parseInt(GetItemData(accountLi[i] , 'handle_direct'))!=0?'<b style="color:#3dbe01;">是</b>':'<b style="color:#ff2900">否</b>')+'</dd>' +
											  '</dl>' +
										 '</dd style="width:78px;">' +
										  '<dd>' +
											   '<dl>' +
													'<dt style="width:65px;">是否接硬广</dt>' +
													'<dd>'+(parseInt(GetItemData(accountLi[i] , 'handle_hard'))!=0?'<b style="color:#3dbe01;">是</b>':'<b style="color:#ff2900">否</b>')+'</dd>' +
											  '</dl>' +
										 '</dd>' +
										  '<dd>' +
											   '<dl>' +
													'<dt style="width:65px;">'+add+'</dt>' +
											  '</dl>' +
										 '</dd>' +
										 
									   '</dl>' +
						  ' </li>';
						  actionPage = action;
					break;
				}
				
			}//end for
			$('#bloggerlist>ul').html(str);
			
			var total_pages=Math.ceil(parseInt(listNum)/pagingBase);
			if(total_pages>1) {
			$('#page').show();
			$('#pageT').show();
			var  paging=SmnPagination.load_paging_data(pageNum,10,total_pages);
	
			//首页和上一页
			var html='<li num="'+paging.first_link+'" >首页</li>'+
			'<li num="'+paging.prev_link+'" >上一页</li>';
			
			//中间的页码
			for(var i=0;i<paging.numbers.length;i++){
				
				if(paging.numbers[i].is_current){
					//当前页
				html+='<li num="'+paging.numbers[i].number+'" class="h">'+paging.numbers[i].number+'</li>';
				}else{
					//非当前页
				html+='<li num="'+paging.numbers[i].number+'" >'+paging.numbers[i].number+'</li>';
				}
			}
			
			//下一页和末页
			html+='<li num="'+paging.next_link+'" >下一页</li>'+
				'<li num="'+paging.last_link+'">末页</li>';
			$('#page').html(html);
			$('#pageT').html(html);

			//注册点击具体页事件
			$('#page li').click(function(){
				$(document).scrollTop(0);
				pageNum=parseInt($(this).attr('num'));
				getActionList(action);
			});
			$('#pageT li').click(function(){
				$(document).scrollTop(0);
				pageNum=parseInt($(this).attr('num'));
				getActionList(action);
			});
			}else {
				$('#page').hide();
				$('#pageT').hide();
			}
			loadDiv(false);
			accountOperate(action);
	},errorFn:function() {
		loadDiv(false);
		alert('加载失败');
	}});
	}

	

	
	
	
	
	///////////////////////////////
}

function province() {
	$('#provincecla').find('span').each(function() {
		$(this).click(function() {
				$(this).parent().children().css('font-weight','normal');
				$(this).css('font-weight','bold');
				actionArr[15] = $(this).attr('val');
				$('#province').val($(this).attr('val'));
				getActionList(pubAction);
		});
	});
	$('#province').change(function() {
		actionArr[15] = $(this).val();
		getActionList(pubAction);
		$('#provincecla').find('span').each(function(i) {
			parseInt($(this).attr('val'))==parseInt(actionArr[15])?$(this).css('font-weight','bold'):$(this).css('font-weight','normal');
		});
		
	});
	
	$('#genderF').click(function() {
		if($(this).attr('checked')) {
			$('#genderM').attr('checked',false);
			actionArr[14] = 0;
			getActionList(pubAction);
		}else {
			actionArr[14] = '';
			getActionList(pubAction);
		}
		
	});
	$('#genderM').click(function() {
		if($(this).attr('checked')) {
			$('#genderF').attr('checked',false);
			actionArr[14] = 1;
			getActionList(pubAction);
		}else {
			actionArr[14] = '';
			getActionList(pubAction);
		}
		
	});
}





function accountOperate(action) {
	var classN = $CONFIG['pageName']=='detail'?'tr':'li';
	var idN = $CONFIG['pageName']=='detail'?'#accountLi':'#bloggerlist';
	$(idN).find(classN).each(function(i) {
		var copy_this = $(this);
		$(this).find('.collection').click(function() {
			if($(this).attr('title')=='点击收藏') {
				_ck(copy_this,'bm_add_favourite',i);
			}else if($(this).attr('title')=='移出收藏') {
				_ck(copy_this,'bm_del_favourite',i);
			}
		});
		$(this).find('.blankd').click(function() {
			if($(this).attr('title')=='点击加入黑名单') {
				site.init('confirm','您确定要将这个博主加入黑名单吗？',function() {_ck(copy_this,'bm_add_black',i);});
			
			}else if($(this).attr('title')=='移出黑名单') {
				_ck(copy_this,'bm_del_black',i);
			}
		});
		$(this).find('.add').click(function() {
		if($CONFIG['activity_status']=='1') {
			_ak($(this),i);
		}else {
			var balanceType=$CONFIG['activity_typea']!='1'?actionData[i].repost_status_price:actionData[i].send_status_price;
			site.init('confirm','微博主追加后无法删除，并冻结'+balanceType+'元，请您确认执行。',function() {_ak($(this),i);
				$('#view_selected_account2').html('查看活动详情').click(function() {
					window.location.href = 'ads.php?action=bm_activity_detail&activity_id='+$CONFIG.activity_id;
				});
			});
		}
				
		});
	});
	$('#allCheckbox').click(function() {
		if($(this).attr('checked')) {
			$('#accountLi').find('li').each(function(i) {
				$(this).find('input').attr('checked',true);
			});
		}else {
			$('#accountLi').find('li').each(function(i) {
				$(this).find('input').attr('checked',false);
			});
		}
	});
	if(tfengyun.$('allcheck')) {
		$('#allcheck').click(function() {
			$(this).attr('checked')?_anime(true):_anime(false);
		});
		function _anime(tf) {
			$('#accountLi').find('tr').each(function(i) {
				$(this).find('input').attr('checked',tf);
			});
		}
	}
	function _ak(obj,num) {
		$.ajax({
			url: 'ads.php?action=bm_add_activity_account&activity_id='+$CONFIG.activity_id+'&id='+$CONFIG['id']+'&ids='+actionData[num].businessman_id,
			type: 'GET',
			timeout: 30000,
			dataType: "txt",
			success: function(txt){
				if(txt.indexOf("<error>login</error>")!=-1) {
						window.loaction='/stitac/index.html';
						return;
					}
				var findresult = txt.indexOf("<error>");
				if(findresult == -1) {
					
						$('#activityFinish').show();
						$('#activityFinish').css({
							top:get_scrollTop_of_body()+200+'px',
							left:document.body.clientWidth/2-130+'px'
						});
						
						$(window).scroll( function() { 
							$('#activityFinish').css('top',get_scrollTop_of_body()+200+'px');
						} );
                        
                        var count=GetItemData(txt,'account_count');
                        $('#sweets').text(count+'个');
                        $('#selectnotice li span[name="account_count"]').html(count);
                        $('#selectnotice li span[name="balance"]').html(GetItemData(txt,'balance'));
                        $('#selectnotice li span[name="money_blocked"]').html(GetItemData(txt,'money_blocked'));
                        
//						$('#sweets').text(txt+'个');
						getActionList(action);
				}else {
					site.init('alert',GetItemData(txt, 'error'));
				}
			},
			error: function() {
				site.init('加载失败');
			}
		});	
	}
	function _ck(obj,type,num) {
		if(typeof action!='undefined') {
			var url = 'ads.php?action='+type+'&account_id='+actionData[num].businessman_id;
		}else {
			var url = 'ads.php?action='+type+'&account_id='+obj.find('.collection').parent().attr('account_id');
		}
		getData({
			url:url,
			type:'GET',
			successFn:function(txt) {
				if(txt=='OK') {
					switch(type) {
						case 'bm_add_favourite':
							pubTip('收藏操作成功');
							obj.find('.collection').parent().html('已收藏');
							$CONFIG['pageName']=='detail'?obj.find('.collection').parent().html('<img alt="已收藏" src="image/x_cheng.png">'):obj.find('.collection').parent().html('已收藏');
						break;
						case 'bm_del_favourite':
							pubTip('移除收藏操作成功');
							obj.remove();
							if(action) getActionList(action);
						break;
						case 'bm_add_black':
							pubTip('加入黑名单操作成功');
							obj.remove();
							if(action) getActionList(action);
						break;
						case 'bm_del_black':
							pubTip('移除黑名单操作成功');
							obj.remove();
							if(action) getActionList(action);
						break;
					}
				}else if(txt.indexOf('error')!=-1) {
					GetItemData(txt , 'error')=='login'?window.location='/':site.init('alert',GetItemData(txt , 'error'));
				}
			},errorFn:function(jqXHR, textStatus, errorThrown) {
				site.init('加载失败');
			}
			});	
	}
}

function startActivity(activity_id)
{
	if(document.getElementById('total_status_count')) {
		site.init('confirm','当前活动共选择了'+$('#total_status_count').text()+'个博主，需要冻结'+$('#total_price').text()+'元，如果确定创建，那么活动在开始前只能修改活动内容与要求，不能再添加和删除微博主。',function() {
			_ac(activity_id);
		});
	}else {
		_ac(activity_id);
	}
	function _ac(activity_id) {
		$('#start_activity').hide();
		$('#loading').show();
		var requrl = "activity.php?type=operate&action=start_activity&activity_id=" + activity_id;
		$.ajax({
			url: requrl,
			type: 'GET',
			timeout: 30000,
			dataType: "txt",
			success: function(txt){
				if(txt.indexOf("<error>login</error>")!=-1) {
						window.loaction='/stitac/index.html';
						return;
					}
				$('#start_activity').show();
				$('#loading').hide();
					
				if(txt=='OK') {
					window.location.href = "ads.php?action=bm_activity_detail&activity_id=" + activity_id;
				}else if(txt.indexOf('<error>')!=-1){
					site.init(txt);
				}
			},
			error: function() {
				$('#start_activity').show();
				$('#loading').hide();
				site.init('加载失败');
			}
		});	
	}
	
}


function setWeets(tf) {
	var strArr=[],sArr=[],rArr=[];
		$('#accountLi').find('li').each(function(i) {
			if($(this).find('input').attr('checked')) {
				strArr.push(actionData[i].businessman_id);
				sArr.push(actionData[i].send_status_price);
				rArr.push(actionData[i].repost_status_price);
			}
		});
		if(strArr.length<1&&!tf) {
				site.init('alert','你还没选择要添加的微博主');
				return;
			}else if(strArr.length<1&&tf){
				window.location.href = 'ads.php?action=bm_activity_detail&activity_id='+$CONFIG.activity_id;
				return;
			}
		if($CONFIG['activity_status']=='1') {
			
			_ak();
		}else {
			
			var balanceType=0;
			if($CONFIG['activity_typea']=='1') {
				for(var loop=0,l=strArr.length;loop<l;loop++) {
					balanceType+=parseFloat(sArr[loop]);
				}
			}else {
				for(var loop=0,l=strArr.length;loop<l;loop++) {
					balanceType+=parseFloat(rArr[loop]);
				}
			}
			site.init('confirm','微博主一旦追加无法删除，并冻结'+balanceType+'元',function() {_ak(true);});
		}
		

	function _ak(open) {
		$('#accountLi').find('li').each(function(i) {
			if($(this).find('input').attr('checked')) {
				$(this).remove();
			}
		});
		
		
		var sweets=strArr.join(',');
		var requrl = 'ads.php?action=bm_add_activity_account&activity_id='+$CONFIG.activity_id+'&id='+$CONFIG['id']+'&ids='+sweets;
		$.ajax({  
			url: requrl,
			type: 'GET',
			timeout: 30000,
			dataType: "txt",
			success: function(txt){
				if(txt.indexOf("<error>login</error>")!=-1) {
					window.loaction='/stitac/index.html';
					return;
				}
				var findresult = txt.indexOf("<error>");
				if(findresult == -1) {
					if(tf) {
                        if($CONFIG['activity_status']=='1'){
                            window.location.href = 'ads.php?action=bm_activity_accounts&activity_id='+$CONFIG.activity_id;
                        }else{
                            window.location.href = 'ads.php?action=bm_activity_detail&activity_id='+$CONFIG.activity_id;
                        }
							
					}else {
//					if(open) {
//						$('#view_selected_account2').html('查看活动详情').click(function() {
//							window.location.href = 'ads.php?action=bm_activity_detail&activity_id='+$CONFIG.activity_id;
//						});
//					}
					$('#activityFinish').show();
					$('#activityFinish').css({
						top:get_scrollTop_of_body()+200+'px',
						left:document.body.clientWidth/2-130+'px'
					});
					
					$(window).scroll( function() { 
						$('#activityFinish').css('top',get_scrollTop_of_body()+200+'px');
					} );
					$('#sweets').text(txt+'个');
					getActionList(pubAction);
					}
				} else {
					site.init("添加微博主失败");
					getActionList(pubAction);
				}
			},
			error: function() {
				site.init('加载失败');
				getActionList(pubAction);
			}
		});	
		}
	
}


function addActAccount(go_next) {
    var selIds=[],sArr=[],rArr=[],next='';
    if(go_next){
        if($CONFIG['activity_status']=='1'){
	        next='ads.php?action=bm_activity_accounts&activity_id='+$CONFIG.activity_id;
	    }else{
	        next='ads.php?action=bm_activity_detail&activity_id='+$CONFIG.activity_id;
	    }
    }
    
    $('#accountLi').find('li').each(function(i) {
        if($(this).find('input').attr('checked')) {
            selIds.push(actionData[i].businessman_id);
            sArr.push(actionData[i].send_status_price);
            rArr.push(actionData[i].repost_status_price);
        }
    });
    if(selIds.length<1) {
        if(next){
            return redirect_to(next);
        }else{
            return site.init('alert','你还没选择要添加的微博主');
        }
    }
    if($CONFIG['activity_status']=='2') {
        var balanceType=0;
        if($CONFIG['activity_typea']=='1') {
            for(var loop=0,l=selIds.length;loop<l;loop++) {
                balanceType+=parseFloat(sArr[loop]);
            }
        }else {
            for(var loop=0,l=selIds.length;loop<l;loop++) {
                balanceType+=parseFloat(rArr[loop]);
            }
        }
        site.init('confirm','微博主一旦追加将无法删除，并将冻结'+balanceType+'元',function(){
            do_addActAccount(selIds.join(','),next);
        });
    }else {
        do_addActAccount(selIds.join(','),next);
    }
}
function do_addActAccount(ids,next) {
	var requrl = 'ads.php?action=bm_add_activity_account&activity_id='+$CONFIG.activity_id+'&id='+$CONFIG['id']+'&ids='+ids;
	$.ajax({  
	    url: requrl,
	    type: 'GET',
	    timeout: 30000,
	    dataType: "txt",
	    success: function(txt){
	        if(isNeedLogin(txt)) {
	            return redirect_to_login();
	        }
	        if(txt.indexOf("<error>") == -1) {
	            //remove selected accounts
	            $('#accountLi').find('li').each(function(i) {
		            if($(this).find('input').attr('checked')) {
		                $(this).remove();
		            }
		        });
	            if(next) {
	                return redirect_to(next);
	            }else {
	                $('#activityFinish').show();
	                $('#activityFinish').css({
	                    top:get_scrollTop_of_body()+200+'px',
	                    left:document.body.clientWidth/2-130+'px'
	                });
	                
	                $(window).scroll( function() { 
	                    $('#activityFinish').css('top',get_scrollTop_of_body()+200+'px');
	                });
	                try{
	                    var count=GetItemData(txt,'account_count');
	                    $('#sweets').text(count+'个');
                        $('#selectnotice li span[name="account_count"]').html(count);
                        $('#selectnotice li span[name="balance"]').html(GetItemData(txt,'balance'));
                        $('#selectnotice li span[name="money_blocked"]').html(GetItemData(txt,'money_blocked'));
	                }catch(err){
	                }
	                
	                getActionList(pubAction);
	            }
	        } else {
	            site.init(getResponseError(txt));
	            getActionList(pubAction);
	        }
	    },
	    error: function() {
	        site.init('请求失败');
	        getActionList(pubAction);
	    }
	}); 
}
function isNeedLogin(res){
    return res.indexOf("<error>login</error>")!=-1;
}
function redirect_to(url){
    window.location.href=url;
}
function redirect_to_login(){
    window.location.href='/stitac/index.html';
}
function getResponseError(res){
    var start=res.indexOf('<error>')+'<error>'.length;
    return res.slice(start,res.indexOf('</error>'));
}
function delete_activity(obj,id) {
	site.init('confirm','您真的要删除这次活动吗？',function() {
		var requrl = "activity.php?type=operate&action=delete_activity&activity_id="+id;
		$.ajax({
			url: requrl,
			type: 'GET',
			timeout: 30000,
			dataType: "txt",
			success: function(txt){
				$(obj).parent().parent().remove();
			},
			error: function() {
				site.init('加载失败');
			}
		});	
	});
	
}

function setActivity() {
	try{
	$('#setData').click(function() {
		
		if(!imgOk) {
			site.init('正在上传图片请稍等...');
			return;
		}
		var type = $('#weiboType').find('em').text()=='直发'?'1':'2';
		var platform = 1;
		if ($('#platform_qq').attr('checked')) { platform = 2;}
		var title = encodeURIComponent($('#title').attr('value'));
		var text = encodeURIComponent($('#text').val());
		

		var textStr = $('#text').val();
		var l=0;
		for(var i=0;i<textStr.length;i++){
			if(textStr.charCodeAt(i)>255) l+=2;
			else l++;
		}
		if(l>280) {
			site.init('活动内容超过140字，不能提交，请修改');
			return;
		}
		
		
		
		var demand = encodeURIComponent($('#demand').attr('value'));
		
		
		var demandStr = $('#demand').val();
		var parent = $('#demand').parent().parent();
		var u = $('#repost_url').val();
		if(demandStr!=''&&typeof demandStr!='undefined' ) {
			var ld=0;
			for(var i=0;i<demandStr.length;i++){
				if(demandStr.charCodeAt(i)>255) ld+=2;
				else ld++;
			}
			if(ld>280) {
				site.init('活动要求超过140字，不能提交，请修改');
				parent.find('p').show();
				parent.find('img').hide();
				return;
			}else {
				parent.find('img').show();
				parent.find('p').hide();
			}
			
		}else {
			parent.find('p').hide();
			parent.find('img').hide();
		}
		
		var url = $('#repost_url').attr('value');
		
		
		var starttime = $('#starttime').attr('value')+' '+$('#hover').find('em').text()+':'+$('#min').find('em').text();

		var st = starttime.split(/(?: |-|:)/);
		st[1]--;
		eval('var stC = new Date('+st.join(',')+');');

		
		
		
		var eTime =  $('#endtime').attr('value')+' '+$('#ehover').find('em').text()+':'+$('#emin').find('em').text();
		
		
		var et = eTime.split(/(?: |-|:)/);
		et[1]--;
		eval('var etC = new Date('+et.join(',')+');');


		
		
		var strT = $('#title').val();
		var lt=0;
		for(var i=0;i<strT.length;i++){
			if(strT.charCodeAt(i)>255) lt+=2;
			else lt++;
		}
		if(title==''||typeof title=='undefined'||lt>40) {
			F.tf = true;
			F.init(F.obj);
			return;
		}
		if(text==''||typeof text=='undefined') {
			F.tf = true;
			F.init(F.obj);
			return;
		}
		if($CONFIG.status!='2') {
			if((stC.getTime()-new Date().getTime())<1000*60*30) {
				$('#starttime').parent().parent().find('p').show();
				$('#starttime').parent().parent().find('b').hide();
				$('#starttime').parent().parent().find('img').hide();
				site.init('开始时间必须大于当前时间30分钟');
				return;
			}
			if((stC.getTime()-new Date().getTime())>1000*60*60*24*2) {
				$('#starttime').parent().parent().find('p').show();
				$('#starttime').parent().parent().find('b').hide();
				$('#starttime').parent().parent().find('img').hide();
				site.init('开始时间必须是当前时间2天之内');
				return;	
			}
			$('#starttime').parent().parent().find('p').hide();
			$('#starttime').parent().parent().find('b').hide();
			$('#starttime').parent().parent().find('img').show();
			

			if((etC.getTime()-stC.getTime())<1000*60*60) {
				$('#endtime').parent().parent().find('p').show();
				$('#endtime').parent().parent().find('b').hide();
				$('#endtime').parent().parent().find('img').hide();
				site.init('结束时间必须大于开始时间1小时');
				return;
			}
			if((etC.getTime()-new Date().getTime())>1000*60*60*24*2) {
				$('#endtime').parent().parent().find('p').show();
				$('#endtime').parent().parent().find('b').hide();
				$('#endtime').parent().parent().find('img').hide();
				site.init('结束时间必须是当前时间2天之内');
				return;	
			}
			$('#endtime').parent().parent().find('p').hide();
			$('#endtime').parent().parent().find('b').hide();
			$('#endtime').parent().parent().find('img').show();
			
		}else {
			$('#starttime').parent().parent().find('p').hide();
			$('#starttime').parent().parent().find('b').show();
			$('#starttime').parent().parent().find('img').hide();
			$('#endtime').parent().parent().find('p').hide();
			$('#endtime').parent().parent().find('b').show();
			$('#endtime').parent().parent().find('img').hide();
			if(old_T == $('#text').val()&&old_D == demandStr&&old_createAImg == createAImg&&old_u==u) {
				site.init('您没有进行修改,不能重复提交已有内容');
				return;
			}
		}
		

		if(type=='2'&&!/http:\/\/[\w-]*(\.[\w-]*)+/ig .test(url)) {
			site.init('转发链接格式不正确');
			return;
		}

		

		if(type=='2'&&url=='') {
			site.init('请输入转发链接');
			return;
		}
	
		var action = "create_activity";
		if ($CONFIG['activity_id'] > 0) { action = "edit_activity"; }
		if($CONFIG.activity_type=='2'&&url=='') {
			$('#postUrl').find('p').show();
			$('#postUrl').find('b').hide();
			$('#postUrl').find('img').hide();
			return;
		}
		$('#postUrl').find('p').hide();
		$('#postUrl').find('b').hide();
		$('#postUrl').find('img').show();
		
		
		var text_str = $('#text').val();
		var reg_str = /(http:\/\/|https:\/\/){1}([\-_a-z0-9]+\.)+([a-z0-9]+){1}(:\d+)?(\/?[a-z0-9_,\-\.\%#\?\=&\/]*)?/gi;
		var match_array = text_str.match(reg_str);
		if(match_array && match_array.length > 0) {
			var href_str = [],relink=false;
			for(var i=0,j=match_array.length;i<j;i++) {
				var urldo = match_array[i];
				var test_reg = /(http:\/\/|https:\/\/|ftp:\/\/)/gi;
				
				var dis_url = urldo;
				if(!test_reg.test(urldo)){
					dis_url = "http://"+urldo;
				}
				
				for(var o=0,l=href_str.length;o<l;o++) {
					if('<a href="'+dis_url+'" target="_blank" class="bluelink">'+urldo+'</a>' == href_str[o]) {
						
						
						relink = true;
					}
				}
				if(relink) continue;
				
				href_str.push('<a href="'+dis_url+'" target="_blank" class="bluelink">'+urldo+'</a>');
			}
			if(relink) {site.init('alert','这个活动的内容中不能有2个重复的链接');return;}
			site.init('confirm','这个活动的内容包含链接 <br />'+href_str.join(",<br />")+' 请先确认链接是否正确。<br />注：链接中不能包含汉字',function() {
			
			if($CONFIG.status=='2') {
				_changeAc();
				_right();
				return;
			}
			_ac();
			_right();
			});
		}else {
		
			if($CONFIG.status=='2') {
				_changeAc();
				_right();
				return;
			}

			_ac();
			_right();
		}
		
		function _right() {
			$('#addSweet').find('p').each(function() {
				if($(this).parent().parent().css('display')!='none') $(this).hide();
			});
			$('#addSweet').find('img').each(function() {
				if($(this).parent().parent().css('display')!='none') $(this).show();
			});
			$('#addSweet').find('b').each(function() {
				if($(this).parent().parent().css('display')!='none') $(this).hide();
			});

		}
		function _changeAc() {
			loadDiv(true,'正在提交...');
			var data
			$.ajax({
				type: "POST",
				dataType: "txt",
				url: "activity.php",
				data: { action: "edit_act_text",text:text,demand:demand,id:$CONFIG.activity_id,picture:createAImg,repost_url:u},
				success: function(data) {
					if(data.indexOf("<error>login</error>")!=-1) {
						window.loaction='/stitac/index.html';
						return;
					}
					if(data.indexOf('error')!=-1) {
						site.init(GetItemData(data,'error'));
					}else {
						window.location='ads.php?action=bm_activity_detail&activity_id='+$CONFIG.activity_id;
					}
					loadDiv(false);
				},
				error: function() {
					loadDiv(false);
					site.init('加载失败');
				}
			});

		}
		function _ac() {
			loadDiv(true,'正在创建...');
			
			
			///////////////////////////
			//alert('text:'+text+'--------repost_url:'+url);
			$.ajax({
				type: "POST",
				dataType: "txt",
				url: "activity.php",
				data: { type: "operate",action:action,activity_type:type,platform:platform,title:title,starttime:(stC.getTime()/1000),closetime:(etC.getTime()/1000),text:text,demand:demand,activity_id:$CONFIG.activity_id,repost_url:url,picture:createAImg},
				success: function(txt) {
					if(txt.indexOf("<error>login</error>")!=-1) {
						window.loaction='/stitac/index.html';
						return;
					}
					if(txt.indexOf('timeout')!=-1) {
						site.init(GetItemData(txt,'timeout'));
					}else if(txt.indexOf('error')!=-1){
						site.init(GetItemData(txt,'error'));
					}else {
						window.location='ads.php?action=bm_preview_activity&activity_id='+txt;
					}
					loadDiv(false);
				},
				error: function() {
					loadDiv(false);
					site.init('加载失败');
				}
			});
		}
	});
	
	}catch(err) {}
}

function dataType() {
	var saveSta='',time='';
	var loc = window.location.toString();
	var V = loc.substr(loc.search('#')+1);
	if(loc.search('#')!=-1) {

		switch(V) {
			case 'star':
				V=1;
			break;
			case 'collecting':
				V=2;
			break;
			case 'history':
				V=4;
			break;
			case 'black':
				V=3;
			break;
		}
	}else {
		V=0;
	}
	$('#dataType').find('span').each(function(i) {
		if(V==i) {
			$(this).parent().parent().children().children().addClass('style2').removeClass('style1');
			$(this).addClass('style1').removeClass('style2'); 
			
			pageNum = 1;
			getActionList($(this).attr('type'));
		}
		if($(this).hasClass('style1')) {
			saveSta = $(this);
		}
		$(this).hover(function() {
			$(this).parent().parent().children().children().removeClass('style1').addClass('style2');
			$(this).removeClass('style2').addClass('style1');
			clearTimeout(time);
		},function() {
			$(this).parent().parent().children().children().removeClass('style1').addClass('style2');
			time = setTimeout(function() {
				saveSta.removeClass('style2').addClass('style1');
			},300);
		}).click(function() {
			pageNum = 1;
			saveSta = $(this);
			if($(this).attr('type')=='view') {
				$('#weetFilter').show();
				$('#dxtbg').show();
				$('#centerCount').show();
				$('#keywordTitle').text('精准搜索');
			}else if($(this).attr('type')=='star') {
				$('#weetFilter').hide();
				$('#dxtbg').hide();
				$('#centerCount').show();
				$('#keywordTitle').text('搜索');
			}else {
				$('#weetFilter').hide();
				$('#dxtbg').hide();
				$('#centerCount').hide();
			}
			getActionList($(this).attr('type'));
		});
	});
}



function delWeets(obj,aId,wId) {
	site.init('confirm','您确定要删除这个微博主吗？',function() {
		var requrl = 'activity.php?type=operate&action=delete_account&activity_id='+aId+'&id=&account_id='+wId;
		$.ajax({
			url: requrl,
			type: 'GET',
			timeout: 30000,
			dataType: "txt",
			success: function(txt){
				if(txt.indexOf("<error>")!=-1) {
						GetItemData(txt,'error')=='login'?window.loaction='/stitac/index.html':site.init('alert',GetItemData(txt,'error'));
						return;
				}
				if(txt=='OK') {
					$(obj).parent().parent().remove();
					
					if($('#cStepList').find('tr').length<1) {
						$('#cStepList').html('<tr><td height="40" align="center">本次活动还没有选择微博主！</td></tr>');
					}
					location.reload();
				}
			},
			error: function() {
				site.init('加载失败');
			}
		});		
	});
	
}

function inquiryL() {
	var obj = $('#inquiryL').find('.inquiryInfo');
	var check = $('#inquiryL').find('.inquirySelect');
	$('#inquiryL').find('.activityDes').each(function(i) {
		$(this).hover(function() {
			$(obj[i]).show();
		},function() {
			$(obj[i]).hide();
		});
	});
	$('#inquiryL').find('.jActivity').each(function(i) {
		$(this).click(function() {
			$(check[i]).show();
		});
		$(check[i]).find('.set').click(function() {
			var jId = $(check[i]).attr('aId');
			$(check[i]).find('input').each(function(i) {
				if($(this).attr('checked')) {
					switch(i) {
						case 0:
							_refuse('channel.php?type=operate&action=refuse_task&id='+jId+'&account_id='+$CONFIG.id+'&activity_id='+$CONFIG.activityId+'&refuse_reason=&refuse_text');
						break;
						case 1:
							_refuse('channel.php?type=operate&action=refuse_task&id='+jId+'&account_id='+$CONFIG.id+'&activity_id='+$CONFIG.activityId+'&refuse_reason=&refuse_text');
						break;
						case 2:
							_refuse('channel.php?type=operate&action=refuse_task&id='+jId+'&account_id='+$CONFIG.id+'&activity_id='+$CONFIG.activityId+'&refuse_reason=&refuse_text');
						break;
						case 3:
							_refuse('channel.php?type=operate&action=refuse_task&id='+jId+'&account_id='+$CONFIG.id+'&activity_id='+$CONFIG.activityId+'&refuse_reason=&refuse_text');
						break;
					}
				}
			});
			$(check[i]).hide();
		});
		$(check[i]).find('.jd').click(function() {
			_refuse('channel.php?type=operate&action=refuse_task&id='+$(check[i]).attr('wId')+'&account_id='+$CONFIG.id+'&activity_id='+$CONFIG.activityId+'&refuse_reason=&refuse_text');
			$(check[i]).hide();
		});
	});
	function _refuse(url) {
		loadDiv(true,'正在提交...');
		$.ajax({
			url: url,
			type: 'GET',
			timeout: 30000,
			dataType: "txt",
			success: function(txt){
				if(txt.indexOf("<error>login</error>")!=-1) {
						window.loaction='/stitac/index.html';
						return;
					}
				if(txt=='OK') {
					loadDiv(false);
					site.init('拒单成功');
				}
			},
			error: function() {
				loadDiv(false);
				site.init('加载失败');
			}
		});	
	}
}

function FilterMachine(options) {
	this.o={
		obj:'', //id
		child_node:'',
		val:'',
		inp:false,
		key:false
	};
	for(var i in options) {
		this.o[i] = options[i];
	}
	if(!this.o.key) {
		this._fil();
		if(this.o.inp) this._inp();
	}else {
		this._key();
	}
}
FilterMachine.prototype={
	_fil:function() {
		var copy_this = this;
		$('#'+this.o.obj+' '+this.o.child_node).click(function(){
			$(this).parent().children().removeClass('h');
			$(this).addClass('h');
			copy_this._arr($(this).attr('val'));
		});
	},
	_arr:function(val) {
		if(val.indexOf('-')!=-1) {
			var val = val.split('-');
			actionArr[this.o.val[0]] = val[0];
			actionArr[this.o.val[1]] = val[1];

		}else {
			actionArr[this.o.val] = val;
		}
		$('#dataType').find('span').each(function() {
			if($(this).hasClass('style1'))  {
				pageNum = 1;
				getActionList($(this).attr('type'));
			}
		});
	},
	_inp:function() {
		
		var arr = ['',''],copy_this=this;
		$('#'+this.o.obj).find('input').each(function(i) {
			$(this).focus(function() {
				$(this).parent().next('.ok').show();
			}).blur(function() {
				arr[i] = $(this).attr('value');
				if(arr[0]==''&&arr[1]=='') $(this).parent().next('.ok').hide();
			});
			
		});
		
		$('#'+this.o.obj).find('.fil').click(function() {
			$(this).parent().parent().children().removeClass('h');
			actionArr[copy_this.o.val[0]] = arr[0];
			actionArr[copy_this.o.val[1]] = arr[1];
			$('#dataType').find('span').each(function() {
				if($(this).hasClass('style1'))  {
					pageNum = 1;
					getActionList($(this).attr('type'));
				}
			});
		});
	},
	_key:function() {
		var copy_this = this;
		$('#'+this.o.obj+' img').click(function() {
			actionArr[copy_this.o.val] = encodeURIComponent($('#'+copy_this.o.obj+' input').attr('value'));
			$('#dataType').find('span').each(function() {
				if($(this).hasClass('style1'))  {
					pageNum = 1;
					getActionList($(this).attr('type'));
				}
			});
		});
		$('#'+copy_this.o.obj+' input').keydown(function() {
			if(event.keyCode==13) {
				actionArr[copy_this.o.val] = encodeURIComponent($('#'+copy_this.o.obj+' input').attr('value'));
				$('#dataType').find('span').each(function() {
					if($(this).hasClass('style1'))  {
						pageNum = 1;
						getActionList($(this).attr('type'));
					}
				});
			}
		});
		$('#'+this.o.obj+' '+ this.o.child_node).click(function() {
			actionArr[copy_this.o.val] = encodeURIComponent($(this).text());
			$('#'+copy_this.o.obj+' input').attr('value',$(this).text());
			$('#dataType').find('span').each(function() {
				if($(this).hasClass('style1'))  {
					pageNum = 1;
					getActionList($(this).attr('type'));
				}
			});
		});
	}
};


function pubTip(c) {
	
	if(document.getElementById('fra')&&$CONFIG.pageName!='accountList') {
		site.init('alert','您操作的动过太快'); 
		return;
	}else if(document.getElementById('fra')&&$CONFIG.pageName=='accountList'){
		$('#fra').remove();
	}
	var w = document.documentElement.clientWidth/2;
	var h = isSafari?document.body.scrollTop:document.documentElement.scrollTop;
	$(document.createElement("div"))
	.attr('id','fra')
	  .css({
	   position : "absolute",
	   "z-index" : 5,
	   left : (w-150),
	   top : (h+100),
	   zoom : 1,
	   width : 300,
	   'background':'#ffffff',
	   border:'3px solid #cccccc',
	   'text-align':'center',
	   'line-height':'28px',
	  'font-size':'12px',
	   color:'#666',
	   padding:'3px 5px',
	   display:'none',
	   "overflow":"hidden"
	  }).appendTo($(document.body));
	  $('#fra').html(c).fadeIn(300);
	  setTimeout(function() {$('#fra').fadeOut(300);},1500);
	  setTimeout(function() {$('#fra').remove();},1800);
	  
}

function paging(pageNum,total_pages,url) {
	if(total_pages<2) return;
	var  paging=SmnPagination.load_paging_data(pageNum,20,total_pages);
	$('#page').show();
	//首页和上一页
	var html='<li num="'+paging.first_link+'" >首页</li>'+
	'<li num="'+paging.prev_link+'" >上一页</li>';
	
	//中间的页码
	for(var i=0;i<paging.numbers.length;i++){
		
		if(paging.numbers[i].is_current){
			//当前页
		html+='<li num="'+paging.numbers[i].number+'" class="h">'+paging.numbers[i].number+'</li>';
		}else{
			//非当前页
		html+='<li num="'+paging.numbers[i].number+'" >'+paging.numbers[i].number+'</li>';
		}
	}
	
	//下一页和末页
	html+='<li num="'+paging.next_link+'" >下一页</li>'+
		'<li num="'+paging.last_link+'">末页</li>';
	$('#page').html(html);
	
	//注册点击具体页事件
	$('#page li').click(function(){
		pageNum=parseInt($(this).attr('num'));
		window.location=url+pageNum+'&count='+20;
	});

}


var loadBase=0;
function loadDiv(tf,val) {
	if(isie6) return;
	if(tf) {
		loadBase++;
		if(document.getElementById('loading')) {
			return;
		}
		var getWidth = document.body.clientWidth;
		var divWidth = 200;
		var leftVal = parseInt(getWidth/2) - parseInt(divWidth/2);
		var objDiv = document.createElement("div");
		with(objDiv.style) {
			width = divWidth + 'px';
			borderWidth = '1px';
			borderColor = '#febf6e';
			borderStyle = 'solid';
			backgroundColor = '#fff7b5';
			height = '26px';
			 position = 'fixed';
			top = '0px';
			zIndex = '99999';
			left = leftVal + 'px';
			fontSize = '12px';
			lineHeight = '26px';
			textAlign = 'center';
		}
		objDiv.setAttribute("id","loading");
		objDiv.innerHTML = val;
		document.body.appendChild(objDiv);
	}else {
		loadBase--;
		try{if(document.getElementById('loading')&&loadBase==0) document.body.removeChild(document.getElementById('loading'));}catch(err) {}
	}
	

}























function change_url() {
	$('#inquiryL2').find('.changeUrl').each(function(i) {
		$(this).click(function() {
			if(document.getElementById('changeOk')) {
				site.init('alert','您有一个连接需要修改,请修改后再继续');
				return;
			}
			var oldUrl = $(this).prev().text(),copy_this=$(this);
			$(this).hide().prev().html('<input type="text" value="" id="textUrl" style="width:230px;" />');
			$(this).parent().append('<img src="image/changeCe.png" id="changeCe" style="float:right;margin-right:5px;" /> <img src="image/changeOk.png" id="changeOk" style="float:right;margin-right:5px;" />');
			$('#textUrl').focus();
			$('#changeOk').click(function() {
				var url = $('#textUrl').val();
				if(url=='' || !/(http:\/\/weibo.com\/){1}/.test(url)) {
					site.init('alert','地址输入不正确');
				}else {
					
					_change(copy_this,url,true);
				}
			});
			$('#changeCe').click(function() {
				_change(copy_this,oldUrl,false);
			});
		});
		
	});
}
function _change(obj,url,run) {
	if(run) {
		
		$.ajax({
			url: 'channel.php?type=operate&action=finish_task&order_id=' + obj.attr('orderId') + "&task_url="+url,
			type: 'GET',
			timeout: 30000,
			dataType: "txt",
			success: function(txt){
				if(txt.indexOf("<error>login</error>")!=-1) {
						window.loaction='/stitac/index.html';
						return;
					}
				if (txt == "OK") {
					obj.show().prev().html('<a href="'+url+'" class="bluelink" target="_blank">'+url+'</a>');
					$('#changeOk').remove();
					$('#changeCe').remove();
					pubTip('修改操作成功');
				}else if(txt.indexOf('<error>')!=-1){
					alert(GetItemData(txt,'error'));
				}
			},
			error: function() {
				site.init('修改失败');
			}
		});	
		
	}else {
		$('#changeOk').remove();
		$('#changeCe').remove();
		obj.show().prev().html('<a href="'+url+'" class="bluelink" target="_blank">'+url+'</a>');
	}
}



function Feedback(type) {
	var objDiv = document.createElement("div");
	if(isie6) {
		with(objDiv.style) {
			position = 'absolute';
			top = '150px';
			zIndex = '5';
			right = '0';
			fontSize = '12px';
			lineHeight = '16px';
		}
		
		objDiv.setAttribute("id","feedback");
		document.body.appendChild(objDiv);
		objDiv.style.top = get_scrollTop_of_body() + 150 + 'px';
		$(window).scroll(function() {
			$('#feedback').css('display','none');
			setTimeout(function() {
					$('#feedback').css('display','');
					$('#feedback').css('top',get_scrollTop_of_body() + 150 + 'px');
			},500);
		});
	}else {
		with(objDiv.style) {
			position = 'fixed';
			top = '150px';
			zIndex = '5';
			right = '0';
			fontSize = '12px';
			lineHeight = '16px';
		}
		
		objDiv.setAttribute("id","feedback");
		document.body.appendChild(objDiv);
		objDiv.style.top = get_scrollTop_of_body() + 150 + 'px';

	}
	
	

	if(type=='businessman') {
	objDiv.innerHTML = '<div id="feelTitle"><b>联<br />系<br />我<br />们<br /><span id="gt">&lt;&lt;</span></b></div>' +
										'<div id="feelCou" style="display:none;">' +
											'<div class="feednc">' +
											'<b>销售经理：</b><br />QQ：<a target=blank href=tencent://message/?uin=800003403&Site=微易互通销售经理&Menu=yes><img border="0" SRC=http://wpa.qq.com/pa?p=1:800003403:7 alt="点击这里给我发消息"></a><br />电话：13810432482' +
											'</div>' +
											'<div class="feednc">' +
											'<b>客服经理：</b><br />QQ：<a target=blank href=tencent://message/?uin=800003403&Site=微易互通客服经理&Menu=yes><img border="0" SRC=http://wpa.qq.com/pa?p=1:800003403:7 alt="点击这里给我发消息"></a><br />电话：010-52495104' +
											'</div>' +
										'</div>';
	}else {
		objDiv.innerHTML = '<div id="feelTitle"><b>联<br />系<br />我<br />们<br /><span id="gt">&lt;&lt;</span></b></div>' +
										'<div id="feelCou" style="display:none;">' +
											'<div class="feednc">' +
											'<b>媒介经理：</b><br />QQ：<a target=blank href=tencent://message/?uin=800009441&Site=微易互通媒介经理&Menu=yes><img border="0" SRC=http://wpa.qq.com/pa?p=1:800009441:7 alt="点击这里给我发消息"></a><br />电话：18810701272' +
											'</div>' +
											'<div class="feednc">' +
											'<b>客服经理：</b><br />QQ：<a target=blank href=tencent://message/?uin=800009441&Site=微易互通媒介经理&Menu=yes><img border="0" SRC=http://wpa.qq.com/pa?p=1:800009441:7 alt="点击这里给我发消息"></a><br />电话：010-82601106' +
											'</div>' +
										'</div>';
	}
	$('#feelTitle').click(function() {
		if($('#feelCou').css('display')=='none') {
			$('#feelCou').show();
			$('#gt').html('&gt;&gt;');
		}else {
			$('#feelCou').hide();
			$('#gt').html('&lt;&lt;');
		}
	});
} 

function _clearCookie(type) {
	CookieHelper.setCookie(type,'',3600 ,'/','weiyihutong.com');
}



function get_scrollTop_of_body(){ 
	var scrollTop; 
	if(typeof window.pageYOffset != 'undefined'){ 
		scrollTop = window.pageYOffset; 
	} else if(typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat'){ 
		scrollTop = document.documentElement.scrollTop; 
	} else if(typeof document.body != 'undefined'){ 
		scrollTop = document.body.scrollTop;  
	}else if (typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') { 
		scrollTop = document.documentElement.scrollTop; 
	} 
	 return scrollTop; 
	 
}


function tipPub(options) {
	var o = {
		obj:'',
		id:'',
		pos:{top:'0',left:'0',point:'bottom'},
		count:'出新功能了,快去看看吧'
	};
	for(var i in options) {
		o[i] = options[i];
	}
	var bubble = document.createElement('div');
	document.getElementById(o.obj).appendChild(bubble);
	document.getElementById(o.obj).style.position="relative";

	$(bubble).attr('id',o.id);
	bubble.style.cssText='top:'+o.pos.top+';left:'+o.pos.left+';width:160px;position:absolute;z-index:2;background:url(image/tipBg.png)';
	
	var point = o.pos.point=='bottom'?'<div style="width:18px;height:10px;position:absolute;z-index:3;background:url(image/tipsj.png)  no-repeat left -10px;bottom:-8px; left:20px;"></div>':'<div style="width:18px;height:10px;position:absolute;z-index:3;overflow:hidden;zoom:1;background:url(image/tipsj.png);top:-8px;left:20px;"></div>';
	
	bubble.innerHTML = '<div style="width:160px; height:3px; overflow:hidden; background:url(image/tipTBBg.png);clear:both;"></div><p style="width:136px; line-height:18px; color:#515151; padding:5px 0 5px 7px;">'+o.count+'</p><span style="cursor:pointer;" id="closePic"><img src="image/closePic.png" /></span><div style="width:160px; height:3px; overflow:hidden; background:url(image/tipTBBg.png) no-repeat left -3px;clear:both;"></div>'+point;
	
	document.getElementById('closePic').onclick=function() {
		document.getElementById(o.obj).removeChild(document.getElementById(o.id));
	}
}
function pic_png() {
	if(isie6) {
		DD_belatedPNG.fix('#num'); 
		DD_belatedPNG.fix('.scrollB'); 
		DD_belatedPNG.fix('#login');
	}	
}


function _clearCookie(type) {
	CookieHelper.setCookie(type,'',3600 ,'/','weiyihutong.com');
}

function menuFn(obj,childTf) {
	var obj = typeof obj=='string' ? $('#'+obj):obj;
	obj.find('li').each(function() {
		$(this).hover(function() {
			childTf?$(this).addClass('show'):$(this).find('span').addClass('show');
			$(this).find('.naviLi').slideDown(80);
		},function() {
			var str = childTf?$(this).find('p').html():$(this).find('span').html();
			if(str.search(/<a/gi) != -1) {
				childTf?$(this).removeClass('show'):$(this).find('span').removeClass('show');
			}
			$(this).find('.naviLi').slideUp(80);
		});
	});
}

function focusAnime() {
	var width = $('#scroll').find('img').length*951+'px';
	var base = 0;
	$('#scroll').width(width);
	var oldLeft = $(".scrollB").css('left');
	var objArr = [];
	var autoPlay = setInterval(function() {
		if(base<$('#scroll').find('img').length-1) 
			base++;
		else 
			base = 0;
		_anime(base);
	},5000);
	$('#num').find('li').each(function(i) {
		objArr.push($(this));
		$(this).click(function() {
			clearInterval(autoPlay);
			base = i;
			_anime(i);
		});
	});
	
	
	
	$('#scroll').hover(function() {
		clearInterval(autoPlay);
	},function() {
		autoPlay = setInterval(function() {
			if(base<$('#scroll').find('img').length-1) 
				base++;
			else 
				base = 0;
			_anime(base);
		},5000);
	});
	
	function _anime(num) {
		for(var i=0,l=objArr.length;i<l;i++) {
			i!=num?objArr[i].css('color','#000'):objArr[i].css('color','#fff');
		}
		var newLeft = parseInt(oldLeft)+num*91;
		var newScrollLeft = 951*num;
		$(".scrollB").animate({left: newLeft}, 300);
		$("#scroll").animate({'margin-left': -newScrollLeft}, 300);
	}
}

function buttonStutas(options) {
	var o = {
		obj:'',
		hover:'',
		out:''
	};
	for(var i in options) {
		o[i] = options[i];
	}
	var obj = typeof o.obj=='string'?$('#'+o.obj):o.obj;

	var hoverImgType = o.hover.search(/./ig) !=-1?true:false;
	var outImgType = o.out.search(/./ig) !=-1?true:false;
	if(hoverImgType!=outImgType) return;
	if(o.hover=='') {
		obj.hover(function() {
			obj.removeClass('hide').addClass('show');
		},function() {
			obj.removeClass('show').addClass('hide');
		});
	}else {
		obj.hover(function() {
			hoverImgType?obj.css('background',o.hover):obj.css('background-position',o.hover);
		},function() {
			outImgType?obj.css('background',o.out):obj.css('background-position',o.out);
		});
	}
	
}

function getData(options) {
	var o = {
		url:'',
		timeout: 60000,
		dataType:'txt',
		type:'POST',
		data:{},
		successFn: function() {},
		errorFn: function() {}
	};
	for(var i in options) {
		o[i] = options[i];
	}
	$.ajax({
		url: o.url,
		type: o.type,
		data:o.data,
		timeout: o.timeout,
		dataType: o.dataType,
		success: function(txt){
			o.successFn(txt);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			o.errorFn(jqXHR, textStatus, errorThrown);
		}
	});	
}

function addfavorite() {
   if (document.all) {
      window.external.addFavorite(window.location,'微易互通');
   } else if (window.sidebar) {
      window.sidebar.addPanel('微易互通', window.location, "");
   }
} 


function scrollT(id,clid) {
	if($('#'+id+'>'+clid).length<2) return;
	var time = 5000,speed = 20;
	var timeout = setInterval(function() {
		_initFn();
	},time);
	$('#'+id).hover(function() {
		clearInterval(timeout);
	},function() {
		timeout = setInterval(function() {
			_initFn();
		},time);
	});
	function _initFn() {
		var init = 0;
		var anime = setInterval(function() {
			_anime(init);
			init+=3;
			if(init==24) {
				clearInterval(anime);
				var first = $('#'+id + '>'+clid).first().html();
				$('#'+id + '>'+clid).first().remove();
				$('#'+id).append('<'+clid+'>'+first+'</'+clid+'>');
				$('#'+id).scrollTop(0);
			}
		},speed);
	}
	function _anime(val) {
		$('#'+id).scrollTop(val);
	}
}

function changeCode(id) {
	var timeout = (new Date()).getTime();
	if(document.getElementById(id)) document.getElementById(id).src="/lib/verificationcode.php?"+timeout;
}



var formClass = {
	inputArr:[],
	pass:'',
	init: function(id, setId) {
		var obj = document.getElementById(id);
		this.inputArr = obj.getElementsByTagName('input');
		var num = '';
		for(var i=0;i<this.inputArr.length;i++) {
			this.inputArr[i].tf = false;
			num = this.blur(this.inputArr[i],i);
			this.inputArr[i].onblur=num;
		}

		document.getElementById(setId).onclick = function() {
			for(var o=0;o<formClass.inputArr.length;o++) {
					formClass.inputArr[o].onblur();
				}
			var i = 0;
			try{
			while(formClass.inputArr[i].tf) {
				i++;
			}
			}catch(err) {}
			
			//alert(formClass.inputArr.length+'----'+i);
			if(formClass.inputArr.length==i) {
				register();
			}
		}
	},
	blur: function(obj,i) {
		return function() {
			obj.typeN = obj.getAttribute('typeN');
			obj.re=formClass.re;
			if(obj.re()) {
				if(obj.typeN=='yzm') {
					formClass.HTMLElement(obj).innerHTML='';
				}else if(obj.typeN!='phone') {
					formClass.HTMLElement(obj).innerHTML='<img src="images/ok.png" />';
				}else {
					if($CONFIG.mobilephone&&$CONFIG.mobilephone==obj.value) {
						formClass.HTMLElement(obj).innerHTML='<img src="images/ok.png" />';
						if(document.getElementById('sjyzm')) {
							document.getElementById('sjyzm').style.display='none';
						}
					}else if(obj.getAttribute('yz')=="false"){
						formClass.HTMLElement(obj).innerHTML='<img src="images/ok.png" />';  //临时
					}
				}
				if(obj.typeN == 'password') formClass.pass=i;
			}else {
				formClass.HTMLElement(obj).innerHTML=obj.re(true);
			}
		}
	},
	phone: function(obj) {
		$('#hq').click(function() {
			$('#hq').hide();
			$('#hqLoad').show();
			$('#djs').show();
			$.ajax({
				url: '/user.php?action=get_phone_verify_code&phone='+obj.value,
				type: 'GET',
				timeout: 30000,
				dataType: "txt",
				success: function(txt){
					obj.setAttribute('yz','true');
					var findresult = txt.indexOf("<error>");
					if(findresult == -1) {
						$('#djs').show();
						var num = 3;
						$('#djs').html('验证码已发送至您的手机请耐心等待，该验证码将在'+num+'分钟后过期');
						var djs = setInterval(function() {
							if(num==0) {
								$('#hq').show();
								$('#djs').hide().html('');
								obj.setAttribute('yz','false');
								clearInterval(djs);
							}else {
								$('#djs').html('验证码已发送至您的手机，该验证码将在'+num+'分钟后过期，请您及时验证');
							}
							num--;
						},60000);
						$('#hqLoad').hide();
					}else {
						$('#hq').show();
						$('#hqLoad').hide();
						$('#djs').hide().html('');
						obj.setAttribute('yz','false');
						alert(GetItemData(txt,'error'));
					}
				},
				error: function() {
					$('#hq').show();
					$('#hqLoad').hide();
					$('#djs').hide().html('');
					obj.setAttribute('yz','false');
					alert('加载失败');
				}
			});	
		});
	},
	HTMLElement: function(obj) {
		var x=obj.parentNode.nextSibling;
		while (x.nodeType!=1){
			x=x.nextSibling;
		}
		return x;
	},
	re: function(errorTxt) {
		switch(this.typeN) {
			case 'user':
				if(errorTxt) return '用户名只能使用 英文字母a-z 数字0-9 或_ 长度不得大于11';
				if(this.getAttribute('right')==this.value) {
					this.tf = true;
					return this.tf;
				}
				var str = this.value;
				str = str.replace(/^\s+|\s+$/ig,'');
				this.value=str;
				if(/^[a-zA-Z0-9_]+$/.test(str)&&str.length<12) {
					if(typeX) {
						var copy_this = this;
						$.ajax({
							url: '../user.php?type=check_loginid&action='+typeX+'&id='+str,
							type: 'GET',
							timeout: 60000,
							dataType: "txt",
							success: function(txt){
								if(txt=='OK') {
									$('#loginidxs').html('<img src="images/ok.png" />');
									copy_this.setAttribute('right',copy_this.value);
									copy_this.tf = true;
								}else {
									$('#loginidxs').html('用户已经存在');
									copy_this.tf = false;
								}
							},
							error: function(jqXHR, textStatus, errorThrown) {
								switch(textStatus) {
									case 'timeout':
										alert('信息提交失败，请再试一次！');
									break;
									case 'error':
										alert('信息提交出错，请再试一次！');
									break;
									case 'abort':
										alert('信息连接断开，请再试一次！');
									break;
									case 'parsererror':
										alert('信息格式错误！');
									break;
								}
								switch(errorThrown) {
									case 'Not Found':
										alert('未找到，请再试一次！');
									break;
									case 'Internal Server Error':
										alert('服务器繁忙，请稍后再试！');
									break;
								}
								$('#loginidxs').html('提交失败请重试');
							}
						});	
					}else {
						this.setAttribute('right',this.value);
						this.tf = true;
						return this.tf;
					}
				}else {
					this.tf = false;
					return this.tf;
				}
			break;
			case 'realname':
				if(/^[a-zA-Z]+$/.test(str)) {
					
				}
			break;
			case 'password':
				if(errorTxt) return '密码最少8位 其中不能包含汉字、空格符、\以及全角符号';
				var str = this.value;
				
				var l = 0;
				while(l<str.length) {
					if(/[\s\\]/.test(str.substr(l,1))) {
						this.tf = false;
						return this.tf;
					}
					if(str.charCodeAt(l)>255) {
						this.tf = false;
						return this.tf;
					}
					l++;
				}
				str = str.replace(/^\s+|\s+$/ig,'');
				this.value=str;
				if(str.length<8) {
					this.tf = false;
					return this.tf;
				}
				this.tf = true;
				return this.tf;
			break;
			case 'repassword':
				if(errorTxt) return '与密码不匹配';
				if(formClass.pass!='' && formClass.inputArr[formClass.pass].value==this.value&&this.value!='') {
					this.tf = true;
					return this.tf;
				}else {
					this.tf = false;
					return this.tf;
				}
			break;
			case 'phone':
				if(errorTxt) return '您输入的手机号不正确';
				var str = this.value;
				str = str.replace(/^\s+|\s+$/ig,'');
				this.value=str;
				if(/^(\+86)?1[358]{1}[0-9]{9}$/.test(str)) {
					this.tf = true;
					return this.tf;
				}else { 
					this.tf = false;
					return this.tf;
				}
			break;
			case 'yzm':
				if(errorTxt) return '您没有输入验证码';
				if(this.parentNode.parentNode.style.display=='none') {
					this.tf = true;
					return this.tf;
				}else if(this.value==''){
					this.tf = false;
					return this.tf;
				}else {
					this.tf = true;
					return this.tf;
				}
				
			break;
			case 'null':
				this.tf = true;
				return this.tf;
			break;
			case 'web':
				if(errorTxt) return '您输入的web地址不正确';
				var str = this.value;
				str = str.replace(/^\s+|\s+$/ig,'');
				this.value=str;
				if( /(http:\/\/|https:\/\/)?([\-_a-z0-9]+\.)+([a-z0-9]+){1}(:\d+)?(\/?[a-z0-9_,\-\.\%#\?\=&\/]*)?/gi.test(str)) {
					this.tf = true;
					return this.tf;
				}else { 
					this.tf = false;
					return this.tf;
				}
			break;
			case 'email':
				
				if(errorTxt) return '您输入的邮箱地址不正确';
				if(this.getAttribute('right')==this.value) {
					this.tf = true;
					return this.tf;
				}
				var str = this.value;
				str = str.replace(/^\s+|\s+$/ig,'');
				this.value=str;
				if(/^[a-zA-Z0-9_-]+(\.\w+)*@(\w|\-)+((\.\w+)+)$/.test(str)) {
					if($CONFIG.pageName=='recharge'||$CONFIG.pageName=='ModifyUserinfo') {
						this.tf = true;
						return this.tf;
					}
					if(typeX) {
						var copy_this = this;
						$.ajax({
							url: '../user.php?action=is_mail_taken&mail='+str+'&role='+typeX,
							type: 'GET',
							timeout: 60000,
							dataType: "txt",
							success: function(txt){
									if(txt=='OK') {
										$('#emailidxs').html('<img src="images/ok.png" />');
										copy_this.setAttribute('right',copy_this.value);
										copy_this.tf = true;
									}else {
										$('#emailidxs').html('此邮箱已占用');
										copy_this.tf = false;
									}
							},
							error: function(jqXHR, textStatus, errorThrown) {
								switch(textStatus) {
									case 'timeout':
										alert('信息提交失败，请再试一次！');
									break;
									case 'error':
										alert('信息提交出错，请再试一次！');
									break;
									case 'abort':
										alert('信息连接断开，请再试一次！');
									break;
									case 'parsererror':
										alert('信息格式错误！');
									break;
								}
								switch(errorThrown) {
									case 'Not Found':
										$('#errorInfo').text('未找到，请再试一次！');
									break;
									case 'Internal Server Error':
										$('#errorInfo').text('服务器繁忙，请稍后再试！');
									break;
								}
								$('#emailidxs').html('提交失败请重试');
							}
						});	
					}else {
						this.setAttribute('right',this.value);
						this.tf = true;
						return this.tf;
					}
				}else {
					this.tf = false;
					return this.tf;
				}
				
				
				
				
			break;
			case 'zfb':	
				if(errorTxt) return '您输入的支付宝账号不正确';
				var str = this.value;
				str = str.replace(/^\s+|\s+$/ig,'');
				this.value=str;
				if(/^[a-zA-Z0-9_-]+(\.\w+)*@(\w)+((\.\w+)+)$/.test(str)) {
					this.tf = true;
					return this.tf;
					
				}else if(/^1[358]{1}[0-9]{9}$/.test(str)) {
					this.tf = true;
					return this.tf;
				}else {
					this.tf = false;
					return this.tf;
				}
			break;
			case 'qq':
				if(errorTxt) return '您输入的QQ号码不正确';
				var str = this.value;
				str = str.replace(/^\s+|\s+$/ig,'');
				this.value=str;
				if(str.length<5) {
					this.tf = false;
					return this.tf;
				}
				if(/^[0-9]+$/.test(str)) {
					this.tf = true;
					return this.tf;
				}else { 
					this.tf = false;
					return this.tf;
				}
			break;
			default:
				if(errorTxt) return '内容不能为空';
				var str = this.value;
				str = str.replace(/^\s+|\s+$/ig,'');
				this.value=str;
				if(str=='' || str == undefined) {
					this.tf = false;
					return this.tf;
				
				}else { 
					this.tf = true;
					return this.tf;
				}
			break;
		}
	}
};


function topHeader() {
	var objDiv = document.createElement("div");
	document.body.appendChild(objDiv);
	
	if(isie6) {
		objDiv.innerHTML = '<div id="top"></div>';
		tfengyun.$('top').style.cssText = 'width:46px; height:18px; position:absolute; cursor:pointer; display:none; background:url(http://image.tfengyun.com/image/top.gif); right:-50px;';
		$(window).scroll(function() {
			$('#top').css('display','none');
			setTimeout(function() {
				if(get_scrollTop_of_body() !==0) {
					$('#top').css('display','');
					$('#top').css('top',get_scrollTop_of_body() + 440 + 'px');
				}
			},500);
		});
		if(get_scrollTop_of_body() !==0 ) {
			tfengyun.$('top').style.display = '';
			tfengyun.$('top').style.top = get_scrollTop_of_body() + 440 + 'px';
		}
	}else {
		objDiv.setAttribute("id","top");
		objDiv.style.cssText = 'width:46px; height:18px; position:fixed; cursor:pointer; display:none; background:url(http://image.tfengyun.com/image/top.gif); bottom:50px;';
		var webWidth = $(document.body).width();
		if((webWidth - 970) > 50) {
			//objDiv.style.left = (webWidth - 970)/2 - 51;
			$(objDiv).css('right',(webWidth - 970)/2 - 51);
		}else {
			tfengyun.$('top').style.display = 'none';
			return;
		}
		$(window).scroll(function() {
			setTimeout(function() {
				get_scrollTop_of_body() !==0 ? $('#top').css('display','') : $('#top').css('display','none');
			},500);
		});
		if(get_scrollTop_of_body() !==0 ) {
			tfengyun.$('top').style.display = '';
		}
	}
	
	tfengyun.$('top').onclick = function() {
		$(window).scrollTop(0);
	}
}
