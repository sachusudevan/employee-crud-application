<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;
use App\Models\EmployeeDesignation;
use App\Models\Employee;
use \Livewire\WithFileUploads;
use App\Helpers\FlashSessionHelper;

class AddOrEditEmployee extends Component
{
    use WithFileUploads;
    
    public $title,$layoutAction; 
    public $name,$email,$photo,$designation; // define field names
   


    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|unique:employees,email', 
        'photo' => 'mimes:jpg,jpeg,png|max:5120', 
        'designation' => 'required',
    ];

    public function mount($id = Null)
    {
        $this->layoutAction = empty($id) ? 'Add' : 'Edit';
        $this->title = 'Enter Employee details';
    }
    
    public function save()
    {
        $this->validate();
        Employee::create([
            'name' => $this->name,
            'email' => $this->email,
            'photo' => $this->photo,
            'designation' => $this->designation,
        ]);
        FlashSessionHelper::createflashmsg('Success','Record successfully created.');
        return redirect()->route('employees.list');
    }
    
    

    public function render()
    {
        
        return view('livewire.employee.add-or-edit-employee',[
            'designations' => EmployeeDesignation::all(),
        ]);
    }
}
