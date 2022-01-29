<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$layoutAction ?? ''}} Employee</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('employees.list')}}">Employees</a></li>
                        <li class="breadcrumb-item active">{{$layoutAction ?? ''}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{$title ?? ''}}</h3>
                </div>
                <!-- /.card-header -->
                <form class="form-horizontal" wire:submit.prevent="save">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employee-name">Employee Name <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" name="name"  id="employee-name" placeholder="Enter Name">
                                    @error('name')
                                        <span id="exampleInputEmail1-error" class="error invalid-feedback">{{$message}}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email-address">Email address <span style="color: red;">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" name="email" id="email-address" placeholder="Enter email">
                                    @error('email')
                                    <span id="exampleInputEmail1-error" class="error invalid-feedback">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employee-photo">Photo </label> 
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" wire:model="photo" name="photo" id="employee-photo" accept="image/*">
                                    @error('photo')
                                        <span id="exampleInputEmail1-error" class="error invalid-feedback">{{$message}}</span>
                                    @enderror
                                    

                                </div>
                            </div>                        


                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label>Designation <span style="color: red;">*</span></label>
                                    <select class="form-control select2bs4 @error('designation') is-invalid @enderror" wire:change="changeDesignationEvent($event.target.value)" id="cust-designation" name="designation" style="width: 100%;" placeholder="Select Designation">
                                        <option value="">-- Select Designation --</option>
                                        @foreach($designations as $value)
                                            <option value="{{$value->id}}" @if($designation == $value->id) selected @endif >{{$value->designation}}</option>
                                        @endforeach
                                    </select>
                                    @error('designation')
                                        <span id="exampleInputEmail1-error" class="error invalid-feedback">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            
                            
                            <div class="col-md-6 employee-photo-view">
                                @if ($photo)
                                    <div class="mt-1">
                                        <img src="{{ $photo->temporaryUrl() }}" width="50"  height="50">
                                    </div>
                                @endif
                                @if (!$photo && isset($employee->photo))
                                    <div class="mt-1">  
                                        <img src="{{ Storage::url($employee->photo) }}" width="50"  height="50">
                                    </div>
                                @endif
                                
                            </div>


                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info ">
                            <div wire:loading wire:target="save">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </div>
                            Save
                        </button>
                        <a  href="{{route('employees.list')}}" class="btn btn-default float-right">Cancel</a>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


@section('script')
<script>
    $(document).ready(function() {
        $('#cust-designation').on('change', function (e) {
            @this.set('designation', e.target.value);
        });

    });
    
    
</script>
@endsection


