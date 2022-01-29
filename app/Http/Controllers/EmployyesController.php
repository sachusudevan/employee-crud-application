<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use \App\Http\Traits\Helpers\ApiResponseTrait;

class EmployyesController extends Controller
{
    
    use ApiResponseTrait;
    
    
    public function loadEmployeeslist(Request $request)
    {
        $input = $request->all();
        $employees_data = Employee::loadEmployeeslist($input);
        $list = array();
        foreach ( $employees_data as $data )
        {
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
    
    
    
    
    
    public function destroyEmployee(Employee $employee,Request $request)
    {
        DB::beginTransaction();
        $response = array();
        try {
            $data = $employee->find($request->uid);
            if(isset($data->id))
            {
                Storage::delete($data->photo);
                $data->delete();
                $response['success'] = true;
            }else{
                $response['success'] = false;
            }
            DB::commit();
        } catch (Exception $ex) {
            $response['success'] = false;
            $response['message'] = 'Something Went wrong';
            DB::rollBack();
        }
        return $this->apiResponse($response,200);
    }
    
    
    
}
