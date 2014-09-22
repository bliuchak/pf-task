<?php

class ApiController extends \Framework\AbstractController {

	public function getpostsupdateAction() {
		$isAjax = $this->request->isAjax();
		$isJson = stripos($this->request->getHeader('CONTENT_TYPE'), 'json') !== FALSE;
		$requestData = array();
		if($isJson && $isAjax) {
			$requestData = $this->request->getJsonRawBody(); // returns parsed json object
		}
		// if request data is not null and contains numeric lastUpdated data - get posts
		if (count($requestData)
				&& isset($requestData->lastUpdated)
				&& is_numeric($requestData->lastUpdated) ) {
			$postsTable = new Posts();
			// if we load page without any post then all posts should be retrieved from db
			if (intval($requestData->lastUpdated) == 0) {
				return json_encode(array('data' => $this->_prepareAjaxData($postsTable->getAllPosts()->toArray())));
			}
			// load posts after the latest published post (load posts with id greater than requested)
			else if ($result = $postsTable->getPostsAfterPost(intval($requestData->lastUpdated))) {
				return json_encode(array('data' => $this->_prepareAjaxData($result->toArray())));
			}
		}
		// if some errors have occurred - redirect to 404 page not found
		$this->response->setStatusCode(404, 'Not Found');
	}

	// helper method which prepares json response
	public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher) {
		$this->view->disable();
		$this->response->setContentType('application/json', 'UTF-8');
		if ($dispatcher->getReturnedValue()) {
			$this->response->setContent(json_encode($dispatcher->getReturnedValue()));
		}
		$this->response->send();
	}

	// helper method which escapes ajax response data
	protected function _prepareAjaxData($data) {
		$result = array();
		$escaper = new Phalcon\Escaper();
		foreach ($data as $item) {
			$item['created'] = date('M j, Y @H:i', $item['created']);
			$result[] = array_map(array($escaper, 'escapeHtml'), $item);
		}
		return $result;
	}

}
