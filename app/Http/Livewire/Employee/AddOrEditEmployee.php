<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;
use App\Models\EmployeeDesignation;
use App\Models\Employee;
use \Livewire\WithFileUploads;

class AddOrEditEmployee extends Component
{
    use WithFileUploads;
    
    public $title,$layoutAction; 
    public $name,$email,$photo,$designation; // define field names
    public $employee = [];
    public $edit = false;




    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|unique:employees,email', 
        'photo' => 'nullable|mimes:jpg,jpeg,png|max:5120', 
        'designation' => 'required',
    ];

    
    public function mount($id = Null)
    {
        $this->layoutAction = empty($id) ? 'Add' : 'Edit';
        $this->title = 'Enter Employee details';
        if(!empty($id))
        {
            $this->edit  = true;
            self::edit($id);
        }
        
    }
    
    
    public function edit($id)
    {
        $this->employee = Employee::findOrFail($id);
        $this->name = $this->employee->name;
        $this->email = $this->employee->email;
        $this->photo = $this->employee->photo;
        $this->designation = $this->employee->designation;
    }
    
    public function save()
    {
        $employee = $this->validate();
        $employee['photo'] = !empty($this->photo) ? $this->photo->store('photos', 'public') : Null;
        Employee::create($employee);
        session()->flash('message', 'Record successfully created.');
        return redirect()->route('employees.list');
    }
    
    
    
    public function update()
    {
        
        
        info('update');
    }

    public function render()
    {
        return view('livewire.employee.add-or-edit-employee',[
            'designations' => EmployeeDesignation::all(),
        ]);
    }
}
