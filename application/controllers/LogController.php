<?php

class LogController extends Zend_Controller_Action
{

	/**
	 * Returns the list of the logs
	 */
	public function getListAction() {
		$data = array ();
		/** @var $configuration Zend_Config */
		$configuration = Zend_Registry::get("configuration");
		// Send Json response
		$jsonHelper = $this->getHelper('Json');
		$jsonHelper->sendJson($data);
		$jsonHelper->getResponse()->sendResponse();
	}

}
