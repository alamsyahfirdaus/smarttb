function sisawaktu(t) {
	var time = new Date(t);
	var n = new Date();
	var x = setInterval(function() {
		var now = new Date().getTime();
		var dis = time.getTime() - now;
		var h = Math.floor((dis % (1000 * 60 * 60 * 60)) / (1000 * 60 * 60));
		var m = Math.floor((dis % (1000 * 60 * 60)) / (1000 * 60));
		var s = Math.floor((dis % (1000 * 60)) / (1000));
		h = ("0" + h).slice(-2);
		m = ("0" + m).slice(-2);
		s = ("0" + s).slice(-2);
		var cd = h + ":" + m + ":" + s;
		$('.sisawaktu').html(cd);
	}, 100);
	setTimeout(function() {
		waktuHabis();
	}, (time.getTime() - n.getTime()));
}

function countdown(t) {
	var time = new Date(t);
	var n = new Date();
	var x = setInterval(function() {
		var now = new Date().getTime();
		var dis = time.getTime() - now;
		var d = Math.floor(dis / (1000 * 60 * 60 * 24));
		var h = Math.floor((dis % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var m = Math.floor((dis % (1000 * 60 * 60)) / (1000 * 60));
		var s = Math.floor((dis % (1000 * 60)) / (1000));
		d = ("0" + d).slice(-2);
		h = ("0" + h).slice(-2);
		m = ("0" + m).slice(-2);
		s = ("0" + s).slice(-2);
		var cd = d + " Hari, " + h + " Jam, " + m + " Menit, " + s + " Detik ";
		$('.countdown').html(cd);

		setTimeout(function() {
			location.reload()
		}, dis);
	}, 1000);
}

$(document).ready(function() {
	setInterval(function() {
		var date = new Date();
		var h = date.getHours(),
			m = date.getMinutes(),
			s = date.getSeconds();
		h = ("0" + h).slice(-2);
		m = ("0" + m).slice(-2);
		s = ("0" + s).slice(-2);

		var time = h + ":" + m + ":" + s;
		$('.live-clock').html(time);
	}, 1000);
});