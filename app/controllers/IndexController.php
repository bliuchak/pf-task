<?php

class IndexController extends \Framework\AbstractController {

	public function indexAction() {
		$this->view->setVar('jsEnabled', true);
		$postsTable = new Posts();
		$this->view->setVar('posts', $postsTable->getAllPosts());
	}

}