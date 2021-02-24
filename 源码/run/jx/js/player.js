var cookie = {
	set: function(name, value) {
		var Days = 30;
		var exp = new Date();
		exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
		document.cookie = name + '=' + escape(value) + ';expires=' + exp.toGMTString();
	},
	get: function(name) {
		var arr, reg = new RegExp('(^| )' + name + '=([^;]*)(;|$)');
		if (arr = document.cookie.match(reg)) {
			return unescape(arr[2]);
		} else {
			return null;
		}
	},
	del: function(name) {
		var exp = new Date();
		exp.setTime(exp.getTime() - 1);
		var cval = getCookie(name);
		if (cval != null) {
			document.cookie = name + '=' + cval + ';expires=' + exp.toGMTString();
		}
	}
};
var cookieTime = cookie.get('time_' + huiid);
//console.log(cookieTime);
if (!cookieTime || cookieTime == undefined) {
	cookieTime = 0;
}
var isiPad = navigator.userAgent.match(/iPhone|Linux|Android|iPad|iPod|ios|iOS|Windows Phone|Phone|WebOS/i) != null;
if (isiPad) {
	var videoObject = {
		container: '.huiv',
		variable: 'player',
		loaded: 'loadHandler',
		poster: 'loadingwap.gif',
		video: huiid
	};
} else {
	var videoObject = {
		container: '.huiv',
		variable: 'player',
		loaded: 'loadHandler',
		autoplay: true,
		video: huiid

	};
}
if (cookieTime > 0) {
	videoObject['seek'] = cookieTime;
}
var player = new ckplayer(videoObject);

function loadHandler() {
	player.addListener('time', timeHandler);
}

function timeHandler(t) {
	cookie.set('time_' + huiid, t);
}

if ((navigator.userAgent.indexOf('MSIE') >= 0) || (navigator.userAgent.indexOf('Trident') >= 0)) {
	alert("兼容模式 易产生播放问题，请将浏览器设置为 极速模式！");
}