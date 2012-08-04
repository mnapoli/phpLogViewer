<?php

class LogController extends Zend_Controller_Action
{

	/**
	 * Returns the list of the logs
	 */
	public function getTailAction() {
		$logId = $this->_getParam("log");
		$logFiles = Zend_Registry::get('logs');
		$data = $this->getLastLines($logFiles[$logId], 100);
		// Send Json response
		$jsonHelper = $this->getHelper('Json');
		$jsonHelper->sendJson($data);
		$jsonHelper->getResponse()->sendResponse();
	}

	private function getLastLines($filename, $maxNbLines) {
		$lines = array();

		// Start from the end of the file
		$file = fopen($filename, 'r');
		$cursor = -1;

		$nbLines = 1;
		$char = '';
		if ($file) {
			while ($char !== false && $nbLines <= $maxNbLines) {
				$line = '';
				$char = '';
				// Read the file backward until a newline or the start of the file
				while ($char !== false && $char !== "\n" && $char !== "\r") {
					$line = $char . $line;
					fseek($file, $cursor--, SEEK_END);
					$char = fgetc($file);
				}
				$lines[] = $line;
				$nbLines++;
			}
		} else {
			throw new Exception("Impossible to open the file: $filename");
		}
		return implode(PHP_EOL, array_reverse($lines));
	}

}
