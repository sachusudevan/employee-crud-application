<?php

namespace App\Http\Livewire\Employee;

use Livewire\Component;
use App\Models\EmployeeDesignation;
use App\Models\Employee;
use \Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupEmail;

class AddOrEditEmployee extends Component
{
    use WithFileUploads;
    
    
    #initialize variables
    public $pk;
    public $title,$layoutAction; 
    public $name,$email,$photo,$designation; // define field names
    public $employee = [];
    public $edit = false;




    #initialize validation rules
    public $rules = [
        'name' => 'required|string',
        'email' => 'required|unique:employees,email', 
        'photo' => 'nullable|mimes:jpg,jpeg,png|max:5120', 
        'designation' => 'required',
    ];

    
    
    #Often you need to access route parameters inside your controller methods. 
    #Because we are no longer using controllers, Livewire attempts to mimic this behavior through its mount method. 
    public function mount($id = Null)
    {
        $this->layoutAction = empty($id) ? 'Add' : 'Edit';
        $this->title = 'Enter Employee details';
        if(!empty($id))
        {
            $this->rules['email'] = 'required|unique:employees,email,'.$id.'';
            $this->pk = $id;
            $this->edit();
        }
        
    }
   
    
    #store employee details in corresponding variables for edit case
    private function edit()
    {
        $this->edit  = true;
        $this->employee = Employee::findOrFail($this->pk);
        $this->name = $this->employee->name;
        $this->email = $this->employee->email;
        $this->designation = $this->employee->designation;
    }
    
    
    #store methord is used for insert or update record in our database
    public function save()
    {
        $edit = $this->employee ? true : false; #initialize the view is edit or add
        $employee = $this->validate();
        if ($this->photo) {
            $employee['photo'] = $this->photo->store('photos', 'public');  #if photo is select then upload image in public storage and update the url in photo key.  
        }
        if ($edit) {
            $this->handleEventUpload($employee);
            session()->flash('message', 'Record successfully updated.');
        }else{
            $password = AppHelper::generateRandomString();
            $employee['password'] = Hash::make($password);
            $this->sendEmail($employee,$password);
            Employee::create($employee);
            session()->flash('message', 'Record successfully created.');
        }
        
        return redirect()->route('employees.list');
    }
    
    
    private function handleEventUpload($employee)
    {
        if ($employee['photo']) {
            Storage::delete($this->employee->photo);  #delete old image
        }
        Employee::find($this->pk)
            ->update($employee);
    }
    
   

    public function render()
    {
        return view('livewire.employee.add-or-edit-employee',[
            'designations' => EmployeeDesignation::all(),
        ]);
    }
    
    
    public function changeDesignationEvent($value)
    {
        $this->designation = $value;
    }
    
    
    
    private function sendEmail($employeedetails, $password) {
        $details = [
            'name' => $employeedetails['name'],
            'email' => $employeedetails['email'],
            'password' => $password
        ];

        Mail::to($employeedetails['email'])->send(new SignupEmail($details));
    }

}
