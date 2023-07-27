<?php

namespace App\Modules\FrontModule\SystemModule\Model;

use Nette;
use Nette\Utils\DateTime;
use Nette\Utils\Json;

class ModelSystemEmployee
{
    use Nette\SmartObject;

    public $xmlPath;
    public $structurePath;
    
    /**
     * ModelSystemEmployee constructor.
     */
    public function __construct()
    {
        $this->xmlPath = "/srv/app/Files/employees.xml";
        $this->structurePath = "/srv/app/Files/employeeStructure.json";
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////FUNCTION////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function get($id = null)
    {
        $xml = $this->loadXML();

        return $this->find($id, $xml);
    }

    public function getStructure()
    {
        $jsonFilePath = $this->structurePath;
        $jsonData = Json::decode(file_get_contents($jsonFilePath));

        return $jsonData;
    }

    public function insert($data)
    {
        $xml = $this->loadXML();
        $lastEmployee = $xml->employee[count($xml->employee) - 1];
        $lastId = $lastEmployee != false ? (int)$lastEmployee['id'] : 0;
        $newId = $lastId + 1;
        $newEmployee = $xml->addChild('employee');
        $newEmployee->addAttribute('id', $newId);
        $newEmployee->addChild('id', $newId);

        foreach ($data as $key => $value)
            $newEmployee->addChild($key, $value);

        $now = new DateTime();
        $newEmployee->addChild('created_at', $now->format('Y-m-d H:i:s'));
        $newEmployee->addChild('updated_at', $now->format('Y-m-d H:i:s'));
        $response = $xml->asXML($this->xmlPath);

        return array('response' => $response, 'path' => $_SERVER['REQUEST_URI'], 'data' => true);
    }

    public function update($data)
    {
        $xml = $this->loadXML();
        $employee = $this->find($data->id, $xml);
        $employee->first_name = $data->first_name;

        foreach ($data as $key => $value)
            $employee->$key = $data->$key;

        $now = new DateTime();
        $employee->updated_at = $now->format('Y-m-d H:i:s');
        $response = $xml->asXML($this->xmlPath);

        return array('response' => $response, 'path' => $_SERVER['REQUEST_URI'], 'data' => true);
    }

    public function delete($id)
    {
        $xml = $this->loadXML();
        $employee = $this->find($id, $xml);
        $dom = dom_import_simplexml($employee);
        $dom->parentNode->removeChild($dom);
        $response = $xml->asXML($this->xmlPath);

        return array('response' => $response, 'path' => $_SERVER['REQUEST_URI'], 'data' => true);
    }

    private function loadXML()
    {
        $xmlFilePath = $this->xmlPath;
        $xmlString = simplexml_load_file($xmlFilePath);

        return $xmlString;
    }

    private function find($id, $xml)
    {
        $targetEmployee = null;
        if (is_null($id))
            return $xml;

        foreach ($xml as $employee) {
            if ((int)$employee['id'] == $id) {
                $targetEmployee = $employee;
                break;
            }
        }

        return $targetEmployee;
    }
}