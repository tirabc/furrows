<?php

class Comments_controller extends Controller
{
	protected $models = array( 'Comment' );
	
	public function add_comment($post_id,$author,$body)
	{
		// Store the comment
		$comment = new Comment();
		$comment->__set( 'author' , $author );
		$comment->__set( 'body' , $body );
		$comment->__set( 'post_id' , $post_id );
		$comment->add();
		
		// get all comments
		$comments = $comment->find_all_by('post_id',$post_id);
	
		// return the HTML portion
		$view = new Html( 'application/views/comments' , 'comments_ajax.html' );
		$view->set_block( 'comments' , $comments );
		$view->parse();
		$view->render();
		
		/**** DO THIS FOR JSON RESPONSE ***/
		// create the message
		/*$message = array(
			'message' => 'comment added',
			'comments' => $comments
		);
	
		// Return the view
		$view = new Json();
		$view->__set( 'status' , 200 );
		$view->__set( 'body' , $message );
		$view->render();*/
		/*** END ***/
	}
	
	public function view_comments_by_post_id($post_id)
	{
		// get all comments for the post_id
		$comment = new Comment();
		$comments = $comment->find_all_by('post_id',$post_id);
		
		// create the content view
		$view = new Html( 'application/views/comments' , 'manage_comments.html' );
		$view->set_block( 'comments' , $comments );
		$view->parse();
		$content = $view->get_body();
		
		// create the view
		$view = new Html( 'application/views' , 'template.html' );
		$view->set_var( 'content' , $content );
		$view->parse();
		$view->render();
		
	}
	
	public function delete_comment($id)
	{
		$comment = new Comment();
		$comment->delete($id);
		
	}
	
}

?>