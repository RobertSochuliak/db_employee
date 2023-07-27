<?php

namespace App\Presenters;

use Nette;

/**
 * Base presenter for all application Presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public static $configData;

    /**
     * Layout settings for the entire application
     */
    public function beforeRender()
    {
        $this->template->configData = self::getConfigData();
        $this->template->layoutPath = '../../../SystemModule/templates/@layout.front.latte';//$this->getContext()->parameters['frontLayout'];
        $this->template->breadcrumb = $this->getBreadcrumb($this->getName(),$this->getParameter('action'));
    }

    /**
     * Ajax response
     */
    public function returnAjaxResponse($response)
    {
        echo json_encode($response);
        die();
    }

    /**
     * Get config data
     */
    public static function getConfigData($accessibility = null, $type = null, $value = null) {
        try {
            $contentFile = file_get_contents(dirname(dirname(dirname(__FILE__))) . "/config.json");
            $data = json_decode($contentFile,true);
            if ($type == null && $value == null) {
                self::$configData = $data;
                unset(self::$configData['private']);
                
                return self::$configData['public'];
            } elseif ($value == null){
                return $data[$accessibility][$type];
            } else {
                return $data[$accessibility][$type][$value];
            }
        } catch (Exception $err) {
            return array('response' => false, 'path' => $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * Generate breadcrumb
     */
    function getBreadcrumb($presenter, $action){
        $breadcrumb['homePath'] =  ':Front:System:System:default';
        $breadcrumb['homeName'] = 'Dashboard';
        $breadcrumb['actualName'] = $action;

        switch ($presenter) {
            case "Front:System:Employee":
                $breadcrumb['baseName'] = 'Employee';
                $breadcrumb['basePath'] = ':'.$presenter.':overview';
                break;
            default:
                $breadcrumb['basePath'] = ':'.$presenter.':overview';
        }

        return $breadcrumb;
    }
}

