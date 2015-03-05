<?php
/**
 * Description of Website
 *
 * @author iamne
 */
class Widgets_Website_Website extends Widgets_Abstract {

	const OPT_URL = 'url';
	const OPT_LANG = 'localization';

	protected function  _load() {
		$content = '';
		$type    = $this->_options[0];
		switch ($type) {
			case self::OPT_URL:
				$content = $this->_toasterOptions['websiteUrl'];
			break;
			case self::OPT_LANG:
                $configHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('config');
                if(empty($configHelper->getConfig('localization'))){
                    break;
                }
                $localization = explode(',', $configHelper->getConfig('localization'));

                if($localization){
                    $localizationContent = '<a href="' .  $this->_toasterOptions['websiteUrl'] . $this->_toasterOptions['url'] . '" title="' . $configHelper->getConfig('language') . '">'
                                                . '<img class="lang-link" src="' . $this->_toasterOptions['websiteUrl'] . 'system/images/flags/' . $configHelper->getConfig('language') . '.png" alt="' . $configHelper->getConfig('language') . '" border="0">'
                                            . '</a> ';
                    foreach ($localization as $lang) {
                        $localizationContent .= '<a href="' .  $this->_toasterOptions['websiteUrl'] . $lang . '/' . $this->_toasterOptions['url'] . '">'
                                                    . '<img class="lang-link" src="' . $this->_toasterOptions['websiteUrl'] . 'system/images/flags/' . $lang . '.png" alt="' . $lang . '" border="0">'
                                                . '</a> ';
                    }

                    $content = $localizationContent;
                }
			break;
		}
		return $content;
	}

	public static function getAllowedOptions() {
		$translator = Zend_Registry::get('Zend_Translate');
		return array(
			array(
				'alias'   => $translator->translate('Website url'),
				'option' => 'website:url'
			)
		);
	}

}

