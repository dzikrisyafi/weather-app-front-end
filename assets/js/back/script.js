$(document).ready(function () {
	"use strict";

	const sidebar = $(".nav");
	const sidebarToggle = $(".sidebar-toggle");
	const navLink = $(".nav-link");
	const overlay = $(".sidebar__overlay");

	sidebarToggle.click(() => {
		sidebar.toggleClass("nav__open");
	});

	overlay.click((e) => {
		sidebar.toggleClass("nav__open");
	});

	if ($(window).width() > 768) {
		sidebar.removeClass("nav__open");
	}

	navLink.each(function () {
		$(this).click(function () {
			let navItem = $(this).parent();
			navItem.toggleClass("show-sub-menu");
		});
	});
});
