$(document).ready(() => {
	"use strict";

	let csrfName = "csrf_tki_pos";
	let csrfHash = $(`[name=${csrfName}]`).attr("content");
	let csrf = {};

	csrf[csrfName] = csrfHash;

	$.ajaxSetup({
		"data": csrf
	});
});
