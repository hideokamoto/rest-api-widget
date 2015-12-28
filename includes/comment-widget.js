(function($) {
	$('#json-comment').on('submit', function(event) {
		event.preventDefault();
		$.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data: $(this).serializeArray(),
				dataType: 'json'
		}).done(function(json){
			alert('投稿に成功したのでリロードします');
			location.reload();
		}).fail(function(json){
			$('.ajax').append("読み込みませんでした。");
		});
	});
})(jQuery);
