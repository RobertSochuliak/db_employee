<?php

namespace App\Modules\FrontModule\SystemModule\presenters;

use App\Presenters\BasePresenter;
use App\Modules\FrontModule\SystemModule\Model\ModelSystemEmployee;

class SystemPresenter extends BasePresenter
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
    
    public function renderDefault()
    {
        $ageGroups = [
            'under 18' => 0,
            '19-25' => 0,
            '26-35' => 0,
            '36-45' => 0,
            '46-55' => 0,
            '56-65' => 0,
            '66 and over' => 0,
        ];

        $employees = $this->modelEmployee->get();
        foreach ($employees as $employee) {
            if ($employee->age <= 18) {
                $ageGroups['under 18'] ++;
            } elseif ($employee->age >= 19 && $employee->age <= 25) {
                $ageGroups['19-25'] ++;
            } elseif ($employee->age >= 26 && $employee->age <= 35) {
                $ageGroups['26-35'] ++;
            } elseif ($employee->age >= 36 && $employee->age <= 45) {
                $ageGroups['36-45'] ++;
            } elseif ($employee->age >= 46 && $employee->age <= 55) {
                $ageGroups['46-55'] ++;
            } elseif ($employee->age >= 56 && $employee->age <= 65) {
                $ageGroups['56-65'] ++;
            } elseif ($employee->age >= 66) {
                $ageGroups['66 and over'] ++;
            }
        }
        $this->template->chartData = (object)['labels' => array_keys($ageGroups), 'values' => array_values($ageGroups)];
    }
}