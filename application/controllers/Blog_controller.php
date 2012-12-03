<?php

class Blog_controller extends Controller
{
	protected $models = array( 'Post' , 'Comment' );
	
	public function view_posts()
	{
		// get all posts from database
		$post_model = new Post();
		$posts = $post_model->find_all();

		// create the content
		$view = new View( 'application/views' , 'posts.html' );
		$view->set_block( 'posts' , $posts );
		$view->parse();
		$content = $view->get_text();
		
		// create the webpage
		$view = new View( 'application/views' , 'template.html' );
		$view->set_var( 'content' , $content );
		$view->parse();
		$view->render();
	}
	
	public function view_post($id)
	{
		// get all posts from database
		$post_model = new Post();
		$post = $post_model->find_by_id( $id );
		
		// create the view
		$view = new View('application/views','post.html');
		$view->set_var('title',$post->title);
		$view->set_var('body',$post->body);
		$view->parse();
		$content = $view->get_text();
		
		// create the webpage
		$view = new View( 'application/views' , 'template.html' );
		$view->set_var( 'content' , $content );
		$view->parse();
		$view->render();
	}
	
	public function add_post()
	{

		if( !empty($_REQUEST['title']) && !empty($_REQUEST['body']) )
		{
			// add the new post
			$post_model = new Post();
			$post_model->__set( 'title' , $_REQUEST['title'] );
			$post_model->__set( 'body' , $_REQUEST['body'] );
			$post_model->add();
		}
		
		// create the view
		$view = new View('application/views','add_post.html');
		$view->parse();
		$content = $view->get_text();
		
		// create the webpage
		$view = new View( 'application/views' , 'template.html' );
		$view->set_var( 'content' , $content );
		$view->parse();
		$view->render();
	}
	
	public function delete_post($id)
	{
		// delete the post
		$post_model = new Post();
		$post_model->delete($id);
		
		// get all posts
		$posts = $post_model->find_all();
		
		// create the view
		$view = new View('application/views','manage_posts.html');
		$view->set_block( 'posts' , $posts );
		$view->parse();
		$content = $view->get_text();
		
		// create the webpage
		$view = new View( 'application/views' , 'template.html' );
		$view->set_var( 'content' , $content );
		$view->parse();
		$view->render();
	}
	
	public function edit_post($id,$title=null,$body=null)
	{
		if ( ! empty( $title ) && ! empty ( $body ) )
		{
			$post_model = new Post();
			$post_model->__set( 'id' , $id );
			$post_model->__set( 'title' , $title );
			$post_model->__set( 'body' , $body );
			$post_model->edit( $id );
			
			header('Location: ?');
		}
	
		// get post details
		$post_model = new Post();
		$current_post = $post_model->find_by_id($id);
		
		// create the view
		$view = new View('application/views','edit_post.html');
		$view->set_var( 'id' , $current_post->__get('id') );
		$view->set_var( 'title' , $current_post->__get('title') );
		$view->set_var( 'body' , $current_post->__get('body') );
		$view->parse();
		$content = $view->get_text();
		
		// create the webpage
		$view = new View( 'application/views' , 'template.html' );
		$view->set_var( 'content' , $content );
		$view->parse();
		$view->render();
	}
	
	public function manage_posts()
	{
		// add the new post
		$post_model = new Post();
		$posts = $post_model->find_all();
		
		// create the view
		$view = new View('application/views','manage_posts.html');
		$view->set_block( 'posts' , $posts );
		$view->parse();
		$content = $view->get_text();
		
		// create the webpage
		$view = new View( 'application/views' , 'template.html' );
		$view->set_var( 'content' , $content );
		$view->parse();
		$view->render();
	}
	
}

?>
