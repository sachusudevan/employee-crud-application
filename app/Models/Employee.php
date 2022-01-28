<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $table = 'employees';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',        
        'photo',
        'designation',
    ];
    
    
    
    public function loadEmployeeslist($input=[]){
        $input['filter_type'] = 2;
        $input['single_field'] = 0;
        return self::generateQuery($input)->get();
    }
    
    public function generateQuery($input)
    {
        $searchValue = ( isset($input['search']['value']) ? $input['search']['value'] : '' );
        $OrderColumnNumber = ( isset($input['order'][0]['column']) ? $input['order'][0]['column'] : 2 );
        $OrderColumnDir = ( isset($input['order'][0]['dir'])? $input['order'][0]['dir']:'asc');
        $start = ( isset($input['start'])? $input['start']:0 );
        $length = (isset($input['length'])?$input['length']:1000 );

        $OrderColumnName = self::orderColumnName($OrderColumnNumber);

        $recordsFilteredQry = self::generateQueryFilter($input,$OrderColumnName,$OrderColumnDir,$start,$length,$searchValue);
        return $recordsFilteredQry;
        
    }
    
    
    public static function orderColumnName($OrderColumnNumber) {
        
        switch ( $OrderColumnNumber )
        {
            case 0:
                $OrderColumnName = 'employees.id';
                break;
            case 2:
                $OrderColumnName = 'employees.name';
                break;
            case 3:
                $OrderColumnName = 'employees.email';
                break;
            case 4:
                $OrderColumnName = 'employees.designation';
                break;
            default:
                $OrderColumnName = 'employees.id';
                break;
        }
        return $OrderColumnName;
    }
    
    
    
    public static function generateQueryFilter($input,$OrderColumnName,$OrderColumnDir,$start,$length,$searchValue) {
        
        if ( isset($input['single_field']) && $input['single_field'] == 1 )
        {
            $recordsFilteredQry = Employee::select('employees.id');
        }else{
            $recordsFilteredQry = Employee::select('employees.id', 'employees.name', 'employees.email', 'employee_designations.designation', 'employees.photo','employees.created_at','employees.updated_at')
                                            ->join('employee_designations','employee_designations.id','=','employees.designation');
        }
        if ( !empty($searchValue) )
        {
            $recordsFilteredQry->where('employees.name', 'like', '%' . $searchValue . '%')
                                ->orWhere('employees.email', 'like', '%' . $searchValue . '%')
                                ->orWhere('employees.designation', 'like', '%' . $searchValue . '%');
        }
        if ( isset($input['filter_type']) && $input['filter_type'] == 2 )//all records
        {
            $recordsFilteredQry->orderBy($OrderColumnName, $OrderColumnDir)->skip($start)->take($length);
        }
        return $recordsFilteredQry;
        
    }
    
    
    
    public function recordsTotal($input)
    {
        $input['filter_type'] = 0;
        $input['single_field'] = 1;
        return self::generateQuery($input)->count();
    }

    public function recordsFilteredCount($input)
    {
        $input['filter_type'] = 1;
        $input['single_field'] = 1;
        return self::generateQuery($input)->count();
    }
    
    
    
}
