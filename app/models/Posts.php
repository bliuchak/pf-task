<?php

class Posts extends \Framework\AbstractModel {

	public function initialize() {
		$this->created = time();
	}

	// retrive the latest post by id
	// if the requested post is not found - return null
	public function getPostsAfterPost($id) {
		$post = $this->findFirst(
			array(
				'conditions' => 'id = ?1', 
				'bind' => array(1 => $id)
		));
		if ($post) {
			return $this->find(
				array(
					'conditions' => 'created > ?1 AND id > ?2', 
					'order' => 'created', 
					'bind' => array(1 => $post->created, 2 => $post->id)
			));
		}
		else {
			return null;
		}
	}

	public function getAllPosts() {
		return $this->find(array('order' => 'created'));
	}

}
