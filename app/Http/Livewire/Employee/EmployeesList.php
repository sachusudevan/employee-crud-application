<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;

class EmployeesList extends Component
{
    public function deleteRecord($id)
    {
        info($id);
    }


    public function render()
    {
        return view('livewire.employee.employees-list');
    }
}
