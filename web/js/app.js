$(document).ready(function() {
	$('#message-box').on('keyup', function(e) {
		if(e.which == 13 || e.keyCode == 13) {
	        sendMessage(this);
	    }
	});
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
		success: function(response) {
			console.log(response);
		}
	});
}