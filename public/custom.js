var current_latitude = 52.52,
	current_longitude = 13.405;

function initMap() {
	var e = new google.maps.Map(document.getElementById("map"), {
		mapTypeControl: !1,
		zoomControl: !0,
		center: {
			lat: current_latitude,
			lng: current_longitude
		},
		zoom: 1,
		styles: [{
			elementType: "geometry",
			stylers: [{
				color: "#f5f5f5"
			}]
		}, {
			elementType: "labels.icon",
			stylers: [{
				visibility: "off"
			}]
		}, {
			elementType: "labels.text.fill",
			stylers: [{
				color: "#616161"
			}]
		}, {
			elementType: "labels.text.stroke",
			stylers: [{
				color: "#f5f5f5"
			}]
		}, {
			featureType: "administrative.land_parcel",
			elementType: "labels.text.fill",
			stylers: [{
				color: "#bdbdbd"
			}]
		}, {
			featureType: "landscape.man_made",
			elementType: "geometry",
			stylers: [{
				color: "#e4e8e9"
			}]
		}, {
			featureType: "poi",
			elementType: "geometry",
			stylers: [{
				color: "#eeeeee"
			}]
		}, {
			featureType: "poi",
			elementType: "labels.text.fill",
			stylers: [{
				color: "#757575"
			}]
		}, {
			featureType: "poi.park",
			elementType: "geometry",
			stylers: [{
				color: "#e5e5e5"
			}]
		}, {
			featureType: "poi.park",
			elementType: "geometry.fill",
			stylers: [{
				color: "#7de843"
			}]
		}, {
			featureType: "poi.park",
			elementType: "labels.text.fill",
			stylers: [{
				color: "#9e9e9e"
			}]
		}, {
			featureType: "road",
			elementType: "geometry",
			stylers: [{
				color: "#ffffff"
			}]
		}, {
			featureType: "road.arterial",
			elementType: "labels.text.fill",
			stylers: [{
				color: "#757575"
			}]
		}, {
			featureType: "road.highway",
			elementType: "geometry",
			stylers: [{
				color: "#dadada"
			}]
		}, {
			featureType: "road.highway",
			elementType: "labels.text.fill",
			stylers: [{
				color: "#616161"
			}]
		}, {
			featureType: "road.local",
			elementType: "labels.text.fill",
			stylers: [{
				color: "#9e9e9e"
			}]
		}, {
			featureType: "transit.line",
			elementType: "geometry",
			stylers: [{
				color: "#e5e5e5"
			}]
		}, {
			featureType: "transit.station",
			elementType: "geometry",
			stylers: [{
				color: "#eeeeee"
			}]
		}, {
			featureType: "water",
			elementType: "geometry",
			stylers: [{
				color: "#c9c9c9"
			}]
		}, {
			featureType: "water",
			elementType: "geometry.fill",
			stylers: [{
				color: "#9bd0e8"
			}]
		}, {
			featureType: "water",
			elementType: "labels.text.fill",
			stylers: [{
				color: "#9e9e9e"
			}]
		}]
	});
	new AutocompleteDirectionsHandler(e);
	var t, a = document.getElementById("origin_latitude").value,
		n = document.getElementById("origin_longitude").value,
		i = document.getElementById("destination_latitude").value,
		o = document.getElementById("destination_longitude").value;
	a.length && n.length && i.length && o.length && (t = new google.maps.Polyline({
		strokeColor: "#111",
		strokeOpacity: .8,
		strokeWeight: 4
	}), directionsService = new google.maps.DirectionsService, directionsDisplay = new google.maps.DirectionsRenderer({
		map: e,
		suppressMarkers: !1,
		polylineOptions: t
	}))
}

function AutocompleteDirectionsHandler(e) {
	this.map = e, this.originPlaceId = null, this.destinationPlaceId = null, this.travelMode = "DRIVING";
	var t = document.getElementById("origin-input"),
		a = document.getElementById("destination-input"),
		n = (document.getElementById("mode-selector"), document.getElementById("origin_latitude")),
		i = document.getElementById("origin_longitude"),
		o = document.getElementById("destination_latitude"),
		l = document.getElementById("destination_longitude"),
		r = new google.maps.Polyline({
			strokeColor: "#111",
			strokeOpacity: .8,
			strokeWeight: 4
		});
	this.directionsService = new google.maps.DirectionsService, this.directionsDisplay = new google.maps.DirectionsRenderer({
		suppressMarkers: !1,
		polylineOptions: r
	}), this.directionsDisplay.setMap(e);
	var s = new google.maps.places.Autocomplete(t),
		c = new google.maps.places.Autocomplete(a);
	s.addListener("place_changed", function (e) {
		var t = s.getPlace();
		if (t.hasOwnProperty("place_id")) {
			if (!t.geometry) return;
			n.value = t.geometry.location.lat(), i.value = t.geometry.location.lng()
		} else service.textSearch({
			query: t.name
		}, function (e, t) {
			t == google.maps.places.PlacesServiceStatus.OK && (n.value = e[0].geometry.location.lat(), i.value = e[0].geometry.location.lng())
		})
	}), c.addListener("place_changed", function (e) {
		var t = c.getPlace();
		if (t.hasOwnProperty("place_id")) {
			if (!t.geometry) return;
			o.value = t.geometry.location.lat(), l.value = t.geometry.location.lng()
		} else service.textSearch({
			query: t.name
		}, function (e, t) {
			t == google.maps.places.PlacesServiceStatus.OK && (o.value = e[0].geometry.location.lat(), l.value = e[0].geometry.location.lng())
		})
	}), this.setupPlaceChangedListener(s, "ORIG"), this.setupPlaceChangedListener(c, "DEST")
}

function calculatePrice() {
	var e = parseFloat($("#original_price").val()),
		t = $("body .kindersitz").val(),
		a = $("body .babyschale").val();
	return 1 < t && (e += 5 * t - 5), 1 < a && (e += 10 * a - 10), $("body .namensschield_active").is(":checked") && (e += 15), $("body .main_price span").html(e), $("#total").val(e), e
}
AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function (t, a) {
	var n = this;
	t.bindTo("bounds", this.map), t.addListener("place_changed", function () {
		var e = t.getPlace();
		e.place_id && ("ORIG" === a ? n.originPlaceId = e.place_id : n.destinationPlaceId = e.place_id, n.route())
	})
}, AutocompleteDirectionsHandler.prototype.route = function () {
	var a;
	this.originPlaceId && this.destinationPlaceId && (a = this).directionsService.route({
		origin: {
			placeId: this.originPlaceId
		},
		destination: {
			placeId: this.destinationPlaceId
		},
		travelMode: this.travelMode
	}, function (e, t) {
		"OK" === t && a.directionsDisplay.setDirections(e)
	})
}, $("body #origin-input").change(function () {
	$("#location_form #origin_input").val($(this).val())
}), $("body #destination-input").change(function () {
	$("#location_form #destination_input").val($(this).val())
}), $("body .to_field ").change(function () {
	$("body #chosen_to").val($(this).val())
}), $("body .from_field  ").change(function () {
	$("body #chosen_from").val($(this).val())
}), $("body .kindersitz").change(function () {
	$("body #kindersitz").val($(this).val()), calculatePrice()
}), $("body .babyschale").change(function () {
	$("body #babyschale").val($(this).val()), calculatePrice()
}), $("body .namensschield_active").click(function () {
	$(this).is(":checked") ? $("body #namensschield_active").val("1") : $("body #namensschield_active").val("0"), calculatePrice()
}), $("body .namensschield_desc").change(function () {
	$("body #namensschield_desc").val($(this).val()), calculatePrice()
}), $("body .bemerkungen").change(function () {
	$("body #bemerkungen").val($(this).val()), calculatePrice()
}), $("body .from_field").change(function () {
	$("body #from_field").val($(this).val())
}), $("body .to_field").change(function () {
	$("body #to_field").val($(this).val())
}), $("body .to_field").bind("keyup change paste", function (e) {
	var t = $("#location_form"),
		a = (t.find("#origin_input"), t.find("#destination_input"), t.find("#origin_latitude").val(), t.find("#origin_longitude").val(), t.find("#destination_latitude").val(), t.find("#destination_longitude").val(), t.find("#from_field").val(), t.find("#to_field").val(), t.serializeArray());
	$.ajax({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
		},
		type: "POST",
		url: "/web/order/getPrices",
		data: a,
		success: function (e) {
			$("body .btncar a").show(), $.each(e, function (e, t) {
				"distance" == e ? $("#location_form #distance").val(t) : ($("span." + e).html(t), $('[data-car="' + e + '"]').attr("data-price", t))
			})
		}
	})
}), $("body .from_field").bind("keyup change paste", function (e) {
	var t = $("#location_form"),
		a = (t.find("#origin_input"), t.find("#destination_input"), t.find("#origin_latitude").val(), t.find("#origin_longitude").val(), t.find("#destination_latitude").val(), t.find("#destination_longitude").val(), t.find("#from_field").val(), t.find("#to_field").val(), t.serializeArray());
	$.ajax({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
		},
		type: "POST",
		url: "/web/order/getPrices",
		data: a,
		success: function (e) {
			$("body .btncar a").show(), $.each(e, function (e, t) {
				"distance" == e ? $("#location_form #distance").val(t) : ($("span." + e).html(t), $('[data-car="' + e + '"]').attr("data-price", t))
			})
		}
	})
}), $(".btncar a").click(function () {
	var e = $("#origin-input").val();
	$("#s_address").val(e);
	var t = $("#destination-input").val();
	$("#d_address").val(t);
	var a = $(this).attr("data-price");
	$("#nextStep").show(), $("body .hidenme").hide(), $("#chosen_car").val($(this).attr("data-car")), $("#original_price").val(a), $(".main_price span").html(a), $("#location_form #total").val(a)
}), 


$("#go_pay").click(function () {

	$(this).find("button").prop("disabled", !0), $(this).find(".loading").show();
	var e = $("body .kindersitz").val();
	$("#kindersitz").val(e);
	var t = $("body .babyschale").val();
	$("#babyschale").val(t);
	
	/*
	$("body .namensschield_active").val() ? $("#namensschield_active").val("true") : $("#namensschield_active").val("false");
	*/
	var a = $("body .namensschield_desc").val();
	$("#namensschield_desc").val(a);


	  if($('.namensschield_active').is(":checked")){
	        $('#namensschield_active').val('true');
	  }else {
	      $('#namensschield_active').val('false');
	  }


	var n = $(".Registrieren .vorname").val(),
		i = $(".Registrieren .nachname").val(),
		o = $(".Registrieren .eingeben").val(),
		l = $(".Registrieren .emailadress").val();
	$("#location_form #vorname").val(n), $("#location_form #nachname").val(i), $("#location_form #Handynummer").val(o), $("#location_form #emailadress").val(l);
	var r = $("#location_form").serializeArray();
	$.ajax({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
		},
		type: "POST",
		url: "/save/scheduled/order",
		data: r,
		success: function (e) {
			return "found" == e ? $(".errors").html("E-Mail existiert bereits") : ($(".errors").html(""), $(".conb2").show(), $(".conb1").hide()), !1
		}
	})
}), $("body #finish_form").click(function (e) {
	e.preventDefault();
	var t = $('body input[name="payementMethod"]:checked').val();
	"stripe" == t ? $("#payment-form").show() : ($("#method").val(t), $("#payment-form").hide(), $("#location_form").submit())
}), $(function () {
	var i = $(".require-validation");

	function o(e, t) {
		if (console.log(t), !t.error) {
			$("body .alert").removeClass("show");
			var a = t.id,
				n = calculatePrice();
			return i.append("<input type='hidden' name='stripeToken' value='" + a + "'/>"), i.append("<input type='hidden' name='price' value='" + n + "'/>"), console.log(i), console.log(i.serializeArray()), void i.get(0).submit()
		}
		$(".error").removeClass("hide").find(".alert").addClass("show").text(t.error.message)
	}
	$("form.require-validation").bind("submit", function (n) {
		var e = $(".require-validation"),
			t = ["input[type=email]", "input[type=password]", "input[type=text]", "input[type=file]", "textarea"].join(", "),
			a = e.find(".required").find(t),
			i = e.find("div.error");
		i.addClass("hide"), $(".has-error").removeClass("has-error"), a.each(function (e, t) {
			var a = $(t);
			"" === a.val() && (a.parent().addClass("has-error"), i.removeClass("hide"), n.preventDefault())
		}), e.data("cc-on-file") || (n.preventDefault(), console.log("working", e.data("stripe-publishable-key")), Stripe.setPublishableKey(e.data("stripe-publishable-key")), Stripe.createToken({
			number: $("#card-number").val(),
			cvc: $(".card-cvc").val(),
			exp_month: $(".card-expiry-month").val(),
			exp_year: $(".card-expiry-year").val()
		}, o))
	})
}), $(".cc-num").keyup(function () {
	this.value.length == this.maxLength && ($(this).next(".cc-num").length ? $(this).next(".cc-num").focus() : $(this).blur())
}), $(".cc-num").on("focusin", function () {
	$(".cc-num").attr("type", "password"), $(this).attr("type", "text"), $(".card-number").addClass("focused")
}), $(".cc-num").on("focusout", function () {
	$(".card-number").removeClass("focused")
}), $(".dropdown").click(function () {
	$(this).next("ul").stop().slideToggle(), $(this).toggleClass("selected")
}), $(".card-number").on("keydown", ".cc-num", function (e) {
	-1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || /65|67|86|88/.test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && e.keyCode <= 40 || (e.shiftKey || e.keyCode < 48 || 57 < e.keyCode) && (e.keyCode < 96 || 105 < e.keyCode) && e.preventDefault()
});