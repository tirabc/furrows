$('document').ready(function(){
	$('#comment').bind('click',function(e){add_comment(e)});
	$('.moderate').bind('click',function(e){moderate_comment(e)});
});


function add_comment(e){
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
};

function moderate_comment(e){
	e.preventDefault();
	var id = $(e.currentTarget).attr('data-id');
	var elt = $(e.currentTarget).parent();
	$.ajax({
		type: 'POST',
		url: "?c=comments&a=delete_comment",
		data: {id:id},
		success: function(data){
			elt.remove();
		},
		error: function(data){alert(data);}
	});
};