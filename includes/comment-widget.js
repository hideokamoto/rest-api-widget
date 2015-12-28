(function($) {
	$('#rest-api-widgets-comment').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data: $(this).serializeArray(),
				dataType: 'json'
		}).done(function(json){
			alert($(':hidden[name="success_text"]').val());
			location.reload();
		}).fail(function(json){
			alert($(':hidden[name="fail_text"]').val());
		});
	});
})(jQuery);
