<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeDesignation;


class EmployeeDesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public $designations = array('Accounts Manager','Recruitment Manager','Technology Manager','Store Manager','Regional Managers','Functional Managers');


    public function run()
    {
        foreach($this->designations as $value)
        {
            EmployeeDesignation::insert(['designation'=> $value]);
        }
    }
}
