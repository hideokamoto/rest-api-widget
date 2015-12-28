(function($) {
	//post comment
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

	//post List
	if( $('#rest-api-widgets-postlist')[0] ){
		$.ajax({
				type: 'GET',
				url: $('#rest-api-widgets-postlist').data('postlist-url'),
				dataType: 'json'
		}).done(function(json){
			var html = '<ul>';
			for (var i = 0; i < json.length; i++) {
				html += '<li>';
				html += '<a href="' + json[i].link + '">'
				html += '<b>' + json[i].title.rendered + '</b>';
				html += '</a>';
				html += json[i].excerpt.rendered;
				html += '</li>';
			}
			html += '</ul>';
			$('#rest-api-widgets-postlist').append(html);
		}).fail(function(json){
			$('#rest-api-widgets-postlist').append($('#rest-api-widgets-postlist').data('fail-text'));
		});
	}

})(jQuery);
