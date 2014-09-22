<?php

class ApiController extends \Framework\AbstractController {

	public function getpostsupdateAction() {
		$isAjax = $this->request->isAjax();
		$isJson = stripos($this->request->getHeader('CONTENT_TYPE'), 'json') !== FALSE;
		$requestData = array();
		if($isJson && $isAjax) {
			$requestData = $this->request->getJsonRawBody();
		}
		if (count($requestData)
				&& isset($requestData->lastUpdated)
				&& is_numeric($requestData->lastUpdated) ) {
			$postsTable = new Posts();
			if (intval($requestData->lastUpdated) == 0) {
				return json_encode(array('data' => $this->_prepareAjaxData($postsTable->getAllPosts()->toArray())));
			}
			else if ($result = $postsTable->getPostsAfterPost(intval($requestData->lastUpdated))) {
				return json_encode(array('data' => $this->_prepareAjaxData($result->toArray())));
			}
		}
		$this->response->setStatusCode(404, 'Not Found');
	}

	public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher) {
		$this->view->disable();
		$this->response->setContentType('application/json', 'UTF-8');
		if ($dispatcher->getReturnedValue()) {
			$this->response->setContent(json_encode($dispatcher->getReturnedValue()));
		}
		$this->response->send();
	}

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
