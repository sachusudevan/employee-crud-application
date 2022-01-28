<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class EmployyesController extends Controller
{
    public function loadEmployeeslist(Request $request)
    {
        $input = $request->all();
        $employees_data = Employee::loadEmployeeslist($input);
        $list = array();
        foreach ( $employees_data as $data )
        {
            $id = encrypt($data->id);
            $list[] = self::formatEmployeeslistForDatatable($data);
        }
        $result = array(
            'draw' => $input['draw'],
            'recordsTotal' => Employee::recordsTotal($input),
            'recordsFiltered' => Employee::recordsFilteredCount($input),
            'data' => $list
        );

        return $result;
    }
    
    
    public function formatEmployeeslistForDatatable($employee)
    {
        $data = array();
        $data['id'] = $employee->id;
        $data['name'] = $employee->name;
        $data['photo'] = !empty($employee->photo) ? Storage::url($employee->photo) : '';
        $data['email'] = !empty($employee->email) ? $employee->email : '';
        $data['designation'] = !empty($employee->designation) ? $employee->designation : '';
        $data['created_at'] = !empty($employee->updated_at) ? Carbon::parse($employee->created_at)->format('Y-M-d H:i:s'): '';
        $data['updated_at'] = !empty($employee->updated_at) ? Carbon::parse($employee->updated_at)->format('Y-M-d H:i:s'): '';
        $data['edit_url'] = URL::route('employees.edit', [ 'id' => $employee->id ]);
        
        return $data;
    }
}
