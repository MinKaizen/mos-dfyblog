/*!
 * jQuery Stick to Me plugin
 *
 * @author: Guilherme Assemany
 * @version: 1.0
 * @requires jQuery 1.6.1 or later
 *
 */

!function(e){e.stickToMe=function(o){var t=e.extend({},{layer:"",fadespeed:400,trigger:["top"],maxtime:0,mintime:0,delay:0,interval:0,maxamount:0,cookie:!0,bgclickclose:!0,escclose:!0,onleave:function(e){},disableleftscroll:!0},o);e(t.layer).hide();var n,i=(new Date).getTime(),a=e(window).height(),s=e(window).width(),c=!1,d=0,m=0,l=!0,r=0;if(/Chrome/.test(navigator.userAgent)){var u=!0;e(document).width()>s&&1==t.disableleftscroll&&(l=!1)}var p=parseFloat(e(t.layer).css("height")),f=parseFloat(e(t.layer).css("width")),g={backgroundcss:{"z-index":"1000",display:"none"},boxcss:{"z-index":"1000",position:"fixed",left:"50%",top:"50%",height:p+"px",width:f+"px","margin-left":-f/2+"px","margin-top":-p/2+"px"}};function b(){c=!1,e(document).bind("mousemove.bindoffset",function(o){c&&(e(document).bind("mouseleave",function(e){setTimeout(function(){v(e)},t.delay)}),e(document).unbind("mousemove.bindoffset")),c=!0})}function v(o){var c=document.documentElement?document.documentElement.scrollTop:document.body.scrollTop,p=document.documentElement?document.documentElement.scrollLeft:document.body.scrollLeft;if(c=e(document).scrollTop()>c?e(document).scrollTop():c,p=e(document).scrollLeft()>p?e(document).scrollLeft():p,-1==Math.round(o.pageX)||-1==Math.round(o.pageY)||-3==o.pageX||-3==o.pageY)var f=-r+c,g=n-p;else f=-o.pageY+c,g=o.pageX-p;var v,y=a/s*g-a;if(v=f>=-a/s*g?f>=y?"top":"right":f>=y?"left":"bottom",!(/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)&&f<0&&f>-a&&g>0&&g<s)){if(-1!=e.inArray(v,t.trigger)||-1!=e.inArray("all",t.trigger)){var h=(new Date).getTime();if(h-i>=t.mintime&&(h-i<=t.maxtime||0==t.maxtime)&&(d<t.maxamount||0==t.maxamount)&&(h-m>=t.interval||0==t.interval)&&l){var w=function(e){for(var o=e+"=",t=document.cookie.split(";"),n=0;n<t.length;n++){for(var i=t[n];" "==i.charAt(0);)i=i.substring(1);if(-1!=i.indexOf(o))return i.substring(o.length,i.length)}return 0}("ck_stick_visit");(0==t.cookie||1==t.cookie&&(w<t.maxamount||0==t.maxamount))&&(t.onleave.call(this,v),""!=t.layer&&function(o,t){if(1!=e.data(document.body,"stick_var"))if(e.data(document.body,"stick_var",1),(o=e(o)).removeClass("wps-hidden"),o.find("p:empty").remove(),"bar"===t){var n=o.height();e("body").hasClass("admin-bar")&&(n-=32),o.addClass("in"),e("body").addClass("wps-splash wps-shown-eb").animate({"margin-top":n+"px"},500)}else{var i=o.data();o.show(),window.setTimeout(function(){e.magnificPopup.open({closeBtnInside:!0,showCloseBtn:"yes"===i.close,enableEscapeKey:"yes"===i.esc,callbacks:{beforeOpen:function(){e("body").addClass("wps-splash wps-mfg-open")},open:function(){e(".mfp-bg").css("opacity",i.opacity/100),e(".mfp-bg").css("background",i.overlay_bg),e("body").on("mousedown.wps",function(o){"yes"===i.onclick&&e.magnificPopup.close()})},close:function(){e(".mfp-bg").attr("style",""),e("body").removeClass("wps-splash wps-mfg-open"),e("body").unbind("mousedown.wps"),e.removeData(document.body,"stick_var")}},items:{src:o},type:"inline"},0)},1e3*parseInt(i.delay)+10)}}(t.layer,t.type),d++,1==t.cookie&&(w++,document.cookie="ck_stick_visit="+w+"; path=/"),m=(new Date).getTime())}}u&&(e(document).unbind("mouseleave"),b())}}e.extend(!0,t,g),e(document).bind("mousemove",function(e){n=e.pageX,r=e.pageY}),e(document).bind("mouseleave",function(e){setTimeout(function(){v(e)},t.delay)}),u&&(e(document).unbind("mouseleave"),b()),e(window).resize(function(o){a=e(window).height(),s=e(window).width()})}}(jQuery);

jQuery(document).ready(function($){
	if($('body').find('.wps-exit_popup').length > 0) {
		$.stickToMe({
			layer: '.wps-exit_popup',
			type: 'popup'
		});
	}
	if($('body').find('.wps-exit_bar').length > 0) {
		$.stickToMe({
			layer: '.wps-exit_bar',
			type: 'bar'
		});
		
		$('#wps-exit-bar').on('click', '.wps-close', function(e) {
			e.preventDefault();
			$.removeData( document.body, "stick_var" );
			$('body').removeClass('wps-splash wps-shown-eb').css('margin-top', '0');
			$(this).parents('.wps-exit_bar').removeClass('in');
			return false;
		});
	}
});