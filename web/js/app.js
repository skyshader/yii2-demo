$(document).ready(function() {
	$('#message-box').on('keyup', function(e) {
		if(e.which == 13 || e.keyCode == 13) {
	        sendMessage(this);
	    }
	});

	if($('.user-list-item.active').find('.badge').length > 0) {
		var currentBadge = $('.user-list-item.active').find('.badge');
		if(!currentBadge.hasClass('hide')) {
			setTimeout(function() {
				clearNotification(currentBadge)
			}, 3000);
		}
	}
});

function sendMessage(element) {
	var message = $(element).val();
	var for_user = $(element).data('for');
	if($.trim(message) == '') return false;

	var template = $('.dummy-message');
	template.find('.message').text(message);
	$('.messages-list').prepend(template.html());

	$(element).val('').blur();

	var data = {
		message: message,
		for_user: for_user
	};

	$.ajax({
		type: 'POST',
		data: data,
		url: '/user/message',
		dataType: 'json',
		success: function(response) {
			console.log(response);
		}
	});
}


function clearNotification(element) {
	var for_user = $('#message-box').data('for');

	var data = {
		for_user: for_user
	};

	$.ajax({
		type: 'POST',
		data: data,
		url: '/user/read',
		success: function(response) {
			element.text('0').addClass('hide');
		}
	});
}