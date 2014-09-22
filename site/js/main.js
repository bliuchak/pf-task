/* nice place to js */

var period = 20000 // 20 seconds

// set periodic job on page load
$(document).ready(function() {
	setTimeout(function() {checkForNewPosts()}, period);
});

function checkForNewPosts() {
	var timestamp = 0;
	// get timestamp from the latest element on the page if it exists
	if ($('.item').length > 0) {
		timestamp = $('.item').last().attr('data-id');
	}

	// prepare ajax request
	$.ajax({
		url: "/api/getpostsupdate",
		data: "{\"lastUpdated\": "+timestamp+"}",
		contentType:"application/json; charset=utf-8",
		dataType:"json",
		type: "POST"
	})
	// on success append all retrieved items
	.done(function(data, textStatus, jqXHR) {
		var resultSet = jQuery.parseJSON(data);
		for (var index in resultSet.data) {
			addItem(resultSet.data[index]);
		}
		setTimeout(function() {checkForNewPosts()}, period);
	})
	// when request failed - show alert
	.fail(function(data, textStatus, jqXHR) {
		alert("Error has occurred. Please, reload the page!");
	});
}

// append retrieved data to the last rendered post
function addItem(data) {
	$(".content").append("<div class=\"item\" id=\"item_" + data.id + "\" data-id=\"" + data.id + "\"><p>" + data.title + " <small>(Created on " + data.created + ")</small></p><span>" + data.text + "</span></div>");
}
