<?php

class Application_Model_Mappers_TemplateMapper extends Application_Model_Mappers_Abstract {

	protected $_dbTable = 'Application_Model_DbTable_Template';
	
	protected $_defaultTemplates = array(
		'index', 'default', 'category', 'news'
	);

	public function find($id) {
		$id = trim($id);
		if (empty ($id)){
			throw new Exceptions_SeotoasterException('Template name cannot be empty');
		}
		$result = $this->getDbTable()->find($id);
		if(0 == count($result)) {
			return null;
		}
		$row = $result->current();
		return new Application_Model_Models_Template($row->toArray());
	}

    public function fetchAll($where = '') {
		$entries = array();
		$resultSet = $this->getDbTable()->fetchAll($where);
		if(null === $resultSet) {
			return null;
		}
		foreach ($resultSet as $row) {
			$entries[] = new Application_Model_Models_Template($row->toArray());
		}
		return $entries;
	}

	public function save($template) {
		if(!$template instanceof Application_Model_Models_Template) {
			throw new Exceptions_SeotoasterException('Given parameter should be and Application_Model_Models_Template instance');
		}
		$data = array(
			'name'          => $template->getName(),
			'content'       => $template->getContent(),
			'preview_image' => $template->getPreviewImage()
		);
		if(null === $this->find($template->getName())) {
			return $this->getDbTable()->insert($data);
		}
		else {
			return $this->getDbTable()->update($data, array('name = ?' => $template->getName()));
		}
	}

	/**
	 *
	 * @param type $name
	 * @return Application_Model_Models_Template 
	 * @deprecated
	 */
	public function findByName($name){
		if (empty($name)){
			throw new Exceptions_SeotoasterException('Template name cannot be empty');
		}

		$row = $this->getDbTable()->fetchRow( $this->getDbTable()->getAdapter()->quoteInto('name = ?', $name) );
		if (count($row) == 0){
			return null;
		}		
		return new Application_Model_Models_Template($row->toArray());
	}

	public function delete(Application_Model_Models_Template $template) {
		return $this->getDbTable()->delete( array('name = ?' => $template->getName()) );
	}
	
	public function clearTemplates(){
		return $this->getDbTable()->delete( array('name NOT IN (?)' => $this->_defaultTemplates));
	}
}
	
