$(document).ready(function() {
	$(".sidebar-menu").on("click", "a#menu-mhs", function(e) {
		var str = $(this).attr("href");
		var n = str.search("dashboard");
		loading("inner_utama");
		if (n > 0) {
		} else {
			e.preventDefault();
			e.stopImmediatePropagation();
			preloader = new $.materialPreloader({
				position: "top",
				height: "5px",
				col_1: "#159756",
				col_2: "#da4733",
				col_3: "#3b78e7",
				col_4: "#fdba2c",
				fadeIn: 200,
				fadeOut: 200
			});

			$.ajax({
				type: "get",
				url: $(this).attr("href"),
				beforeSend: function() {
					preloader.on();
				},
				success: function(data) {
					preloader.off();
					$("#utama").html(data);
				}
			});
		}
	});

	$(".sidebar-menu").on("click", "a#menu-akhir", function(e) {
		var str = $(this).attr("href");
		var n = str.search("dashboard");
		loading("utama");
		if (n > 0) {
		} else {
			e.preventDefault();
			e.stopImmediatePropagation();
			preloader = new $.materialPreloader({
				position: "top",
				height: "5px",
				col_1: "#159756",
				col_2: "#da4733",
				col_3: "#3b78e7",
				col_4: "#fdba2c",
				fadeIn: 200,
				fadeOut: 200
			});

			// var untuk nyimpen this element, biar bisa dibaca di ajax
			var menu_akhir = $(this);

			$.ajax({
				type: "get",
				url: $(this).attr("href"),
				beforeSend: function() {
					preloader.on();

					// remove class active di semua <li>
					$(".sidebar-menu li").removeClass("active");
				},
				success: function(data) {
					$("#utama").html(data);
					window.history.pushState(
						"object or string",
						"Title",
						menu_akhir.data("path")
					);
					// console.log(menu_akhir.data('path'));
				},
				complete: function() {
					preloader.off();

					// add class active di current li
					menu_akhir.parent().addClass("active");
					menu_akhir
						.parent()
						.parent()
						.parent()
						.addClass("active");
				}
			});
		}
	});
});

$(function() {
	// $(document).ajaxSend(function(event, request, settings) {});

	$(document).ajaxError(function(event, request, settings) {
		// notification(
		// 	"Terjadi kesalahan! Harap segera hubungi admin!",
		// 	"danger"
		// );
	});

	// $(document).ajaxComplete(function(event, request, settings) {});

	window.addEventListener(
		"popstate",
		function(event) {
			// The popstate event is fired each time when the current history entry changes.
			// var r = confirm("You pressed a Back button! Are you sure?!");
			// if (r == true) {
			// 	// Call Back button programmatically as per user confirmation.
			// 	history.back();
			// 	// Uncomment below line to redirect to the previous page instead.
			// 	// window.location = document.referrer // Note: IE11 is not supporting this.
			// } else {
			// 	// Stay on the current page.
			// 	history.pushState(null, null, window.location.pathname);
			// }
			// history.pushState(null, null, window.location.pathname);

			// console.log(event.target.location.href);
			var href = event.target.location.href;
			location.reload();
		},
		false
	);

	function getAllUrlParams(url) {
		// get query string from url (optional) or window
		var queryString = url
			? url.split("?")[1]
			: window.location.search.slice(1);

		// we'll store the parameters here
		var obj = {};

		// if query string exists
		if (queryString) {
			// stuff after # is not part of query string, so get rid of it
			queryString = queryString.split("#")[0];

			// split our query string into its component parts
			var arr = queryString.split("&");

			for (var i = 0; i < arr.length; i++) {
				// separate the keys and the values
				var a = arr[i].split("=");

				// in case params look like: list[]=thing1&list[]=thing2
				var paramNum = undefined;
				var paramName = a[0].replace(/\[\d*\]/, function(v) {
					paramNum = v.slice(1, -1);
					return "";
				});

				// set parameter value (use 'true' if empty)
				var paramValue = typeof a[1] === "undefined" ? true : a[1];

				// (optional) keep case consistent
				paramName = paramName.toLowerCase();
				paramValue = paramValue.toLowerCase();

				// if parameter name already exists
				if (obj[paramName]) {
					// convert value to array (if still string)
					if (typeof obj[paramName] === "string") {
						obj[paramName] = [obj[paramName]];
					}
					// if no array index number specified...
					if (typeof paramNum === "undefined") {
						// put the value on the end of the array
						obj[paramName].push(paramValue);
					}
					// if array index number specified...
					else {
						// put the value at that index number
						obj[paramName][paramNum] = paramValue;
					}
				}
				// if param name doesn't exist yet, set it
				else {
					obj[paramName] = paramValue;
				}
			}
		}

		return obj;
	}

	/**
	 * Overwrites obj1's values with obj2's and adds obj2's if non existent in obj1
	 * @param obj1
	 * @param obj2
	 * @returns obj3 a new object based on obj1 and obj2
	 */
	function merge_obj(obj1, obj2) {
		var obj3 = {};
		for (var attrname in obj1) {
			obj3[attrname] = obj1[attrname];
		}
		for (var attrname in obj2) {
			obj3[attrname] = obj2[attrname];
		}
		return obj3;
	}

	$(document).on("click", "a.add-history", function() {
		// console.log(window.location.pathname);
		window.history.pushState(
			"object or string",
			"Title",
			$(this).attr("href")
		);
	});

	$(document).on("click", ".pagination > li > a", function() {
		var searchParams = getAllUrlParams($(this).attr("href"));
		var currParams = getAllUrlParams(window.location.href);
		var currUrl = window.location.href.split("?")[0];

		var nextParams = merge_obj(currParams, searchParams);

		var nextUrl = currUrl;
		var count = 0;
		for (var key in nextParams) {
			if (count == 0) {
				nextUrl += "?" + key + "=" + nextParams[key];
			} else {
				nextUrl += "&" + key + "=" + nextParams[key];
			}
			count++;
		}

		preloader = new $.materialPreloader({
			position: "top",
			height: "5px",
			col_1: "#159756",
			col_2: "#da4733",
			col_3: "#3b78e7",
			col_4: "#fdba2c",
			fadeIn: 200,
			fadeOut: 200
		});

		$.ajax({
			type: "GET",
			url: $(this).attr("href"),
			beforeSend: function() {
				preloader.on();
			},
			success: function(data) {
				$("#utama").html(data);
				$("select").select2({
					width: 500
				});
				$(".ttp").tooltip();
				window.history.pushState("object or string", "Title", nextUrl);
			},
			complete: function() {
				preloader.off();
			}
		});
		return false;
	});

	$("select").select2({
		width: 500
	});

	$("textarea")
		.each(function() {
			this.setAttribute(
				"style",
				"height:" + this.scrollHeight + "px;overflow-y:hidden;"
			);
		})
		.on("input", function() {
			this.style.height = "auto";
			this.style.height = this.scrollHeight + "px";
		});

	$(document).on("click", "#checkall", function() {
		$("input:checkbox")
			.not(this)
			.prop("checked", this.checked);
	});

	$(document).on("click", "a.del", function() {
		var index = $("a.del").index(this);
		index = index + 1;
		$("input:checkbox")
			.eq(index)
			.prop("checked", "checked");
		$(this)
			.closest("form")
			.submit();
		return false;
	});

	$(document).on("click", "#nav-toggle", function() {
		$(".dropdown").data("closable", true);
		if ($("#nav_sidebar").hasClass("sidebar-mini")) {
			//set big
			$("#nav_sidebar").removeClass("sidebar-mini");
			$("#nav_sidebar").addClass("sidebar");
			$("#utama").removeClass("col-md-12");
			$("#utama").addClass("col-md-10");
			$("#utama").css("padding-left", "20px");
			$(".header-main").hide();
		} else {
			///set mini
			$("#nav_sidebar").removeClass("sidebar");
			$("#nav_sidebar").addClass("sidebar-mini");
			$("#utama").removeClass("col-md-10");
			$("#utama").addClass("col-md-12");
			$("#utama").css("padding-left", "67px");
			$(".header-main").show();
		}
	});

	$(".dropdown").on({
		"shown.bs.dropdown": function() {
			$(this).data("closable", false);
		},
		click: function() {
			$(this).data("closable", true);
		},
		"hide.bs.dropdown": function() {
			return $(this).data("closable");
		}
	});

	$("#nav-toggle").trigger("click");
	$(".ttp").tooltip();
});

function url(name) {
	name = name.toLowerCase(); // lowercase
	name = name.replace(/^\s+|\s+$/g, ""); // remove leading and trailing whitespaces
	name = name.replace(/\s+/g, "-"); // convert (continuous) whitespaces to one -
	name = name.replace(/[^a-z-]/g, ""); // remove everything that is not [a-z] or -
	return name;
}

function autoComplete(element, url, ph, dataPost) {
	$(element).select2({
		placeholder: ph,
		minimumInputLength: 1,
		allowClear: true,
		width: "100%",
		ajax: {
			url: url,
			dataType: "json",
			type: "POST",
			data: function(term, page) {
				dt = { q: term };
				return $.extend(dt, dataPost);
			},
			results: function(data, page) {
				return { results: data };
			}
		}
	});
}
