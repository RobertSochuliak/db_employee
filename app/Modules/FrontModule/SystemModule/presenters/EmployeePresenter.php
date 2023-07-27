<?php

namespace App\Modules\FrontModule\SystemModule\presenters;

use App\Modules\FrontModule\SystemModule\Model\ModelSystemEmployee;
use App\Presenters\BasePresenter;

class EmployeePresenter extends BasePresenter
{
    private $modelEmployee;

    public function __construct()
    {
        $this->modelEmployee = New ModelSystemEmployee();
    }

    public function startup()
    {
        parent::startup();
        $this->setLayout('layout.front');
    }

    public function renderOverview()
    {
        $this->template->employeesData = $this->modelEmployee->get();
        $this->template->employeesStructure = $this->modelEmployee->getStructure();
    }

    public function renderEdit($projectId)
    {
        $this->template->employeeData = $this->modelEmployee->get($projectId);
        $this->template->employeesStructure = $this->modelEmployee->getStructure();
    }

    public function renderAdd($projectId)
    {
        $this->template->employeesStructure = $this->modelEmployee->getStructure();
    }

    public function handleAddEmployee()
    {
        $data = json_decode($_POST['dataRequest']);
        $response = $this->modelEmployee->insert($data);
        $this->returnAjaxResponse($response);
    }

    public function handleUpdateEmployee()
    {
        $data = json_decode($_POST['dataRequest']);
        $response = $this->modelEmployee->update($data);
        $this->returnAjaxResponse($response);
    }

    public function handleDeleteEmployee($id)
    {
        $response = $this->modelEmployee->delete($id);
        $this->returnAjaxResponse($response);
    }

}