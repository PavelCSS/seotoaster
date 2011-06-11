<?php
/**
 * ToasterUploader
 *
 * @author Pavel Kovalyov <pavlo.kovalyov@gmail.com>
 */
class Zend_View_Helper_ToasterUploader extends Zend_View_Helper_Abstract {

	private $_libraryPath = 'system/js/external/plupload/';

	private $_uploadForm = null;
	
	private $_uploadActionUrl = array(
		'controller' => 'backend_upload',
		'action'     => 'upload'
	);
	
	private $_fileTypes = array(
		'image' => array('title'=>'Image files', 'extensions' => 'jpg,gif,png'),
		'zip'	=> array('title' => 'Zip files', 'extensions' => 'zip'),
		'video' => array('title' => 'Video files', 'extensions' => 'mp4, avi, mov, flv'),
	);
	
	public function toasterUploader($options = null){
		if (isset($options['caller']) && !empty($options['caller'])) {
			$this->_uploadActionUrl['caller'] = $options['caller'];
			$this->view->caller = $options['caller'];
		}
		//assign all necessary JS and CSSs
		$this->view->jQuery()->addJavascriptFile($this->view->websiteUrl.$this->_libraryPath.'plupload.js');
		$this->view->jQuery()->addJavascriptFile($this->view->websiteUrl.$this->_libraryPath.'plupload.html5.js');
		$this->view->jQuery()->addJavascriptFile($this->view->websiteUrl.$this->_libraryPath.'plupload.html4.js');
		$this->view->jQuery()->addJavascriptFile($this->view->websiteUrl.$this->_libraryPath.'plupload.flash.js');
		
		//assign all view variables
		$this->view->config = Zend_Registry::get('misc'); 
		$this->view->actionUrl = $this->view->websiteUrl.$this->view->url($this->_uploadActionUrl);
		$this->view->formId = isset($options['id']) && !empty ($options['id']) ? $options['id'] : 'toaster-uploader';
		$this->view->buttonCaption = isset($options['caption']) && !empty ($options['caption']) ? $options['caption'] : 'Upload files';
		
		$this->view->fileTypes = $this->_fileTypes;
		$this->view->filters = isset($options['filters']) && !empty ($options['filters']) ? $options['filters'] : null;
		
		$this->view->caller = $this->_uploadActionUrl['caller'] ? $this->_uploadActionUrl['caller'] : false;
		
		return $this->view->render('admin'.DIRECTORY_SEPARATOR.'uploadForm.phtml');
	}

}