(function($) {
	//post comment
	if( $('#rest-api-widgets-comment')[0] ){
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
	}

	//comment List
	if( $('#rest-api-widgets-commentlist')[0] ){
		$.ajax({
				type: 'GET',
				url: $('#rest-api-widgets-commentlist').data('commentlist-url'),
				dataType: 'json'
		}).done(function(json){
			var html = '<ul>';
			for (var i = 0; i < json.length; i++) {
				html += '<li>';
				if ( json[i].author_name != '' ) {
					var author_name = json[i].author_name
				} else {
					var author_name = $('#rest-api-widgets-commentlist').data('unknown-author');
				}
				author_name = '<b>' + author_name + '</b>';
				if ( json[i].author_url ) {
					html += '<a href="' + json[i].link + '">' + author_name + '</a>';
				} else {
					html += author_name;
				}
				html += json[i].content.rendered;
				html += '</li>';
			}
			html += '</ul>';
			$('#rest-api-widgets-commentlist').append(html);
		}).fail(function(json){
			console.log(json);
			$('#rest-api-widgets-commentlist').append($('#rest-api-widgets-commentlist').data('fail-text'));
		});
	}

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
				html += '<a href="' + json[i].link + '">';
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
