<?php

class AdminController extends \Framework\AbstractController {

	public function indexAction() {
		if (!$this->view->form) $this->view->setVar('form', new \AdminForm\AdminForm());
	}

	public function submitAction() {
		// prepare form
		if ($this->getDI()->getRequest()->isPost()) {
			$this->view->form = new \AdminForm\AdminForm();
			$newPost = new Posts();
			if ($this->view->form->isValid($this->getDI()->getRequest()->getPost(), $newPost)) {
				// create new feedback
				$newPost->create();
				return $this->dispatcher->forward(array('controller' => 'index','action' => 'index'));
			} else {
				// output error message
				$this->view->setVar('errors', $this->view->form->getMessages());
			}
		}
	}

}
