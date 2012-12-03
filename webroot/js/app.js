$('document').ready(function(){
	$('#comment').click(function(e){
		e.preventDefault();
		var author = $('#author').val();
		var body = $('#body').val();
		var post_id = $('#post_id').val();
		$.ajax({
			type: 'POST',
			url: "?c=comments&a=add_comment",
			data: {post_id:post_id,author:author,body:body},
			success: function(data){
				$('#comments').html(data);
			},
			error: function(data){alert(data);}
		});
	});
});