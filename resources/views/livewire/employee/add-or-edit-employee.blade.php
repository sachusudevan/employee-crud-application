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
                                    <label for="employee-name">Employee Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" name="name"  id="employee-name" placeholder="Enter Name">
                                    @error('name')
                                    <span id="exampleInputEmail1-error" class="error invalid-feedback">{{$message}}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email-address">Email address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" name="email" id="email-address" placeholder="Enter email">
                                    @error('email')
                                    <span id="exampleInputEmail1-error" class="error invalid-feedback">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employee-photo">Photo</label> 
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" wire:model="photo" name="photo" id="employee-photo">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    @error('photo')
                                    <span id="exampleInputEmail1-error" class="error invalid-feedback">{{$message}}</span>
                                    @enderror

                                </div>
                            </div>                        
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label>Designation</label>
                                    <select class="form-control select2bs4 @error('designation') is-invalid @enderror" wire:model="designation" name="designation" style="width: 100%;" placeholder="Select Designation">
                                        <option value="" >---SELECT DESIGNATION---</option>
                                        @foreach($designations as $value)
                                            <option value="{{$value->id}}" >{{$value->designation}}</option>
                                        @endforeach
                                    </select>
                                    @error('designation')
                                        <span id="exampleInputEmail1-error" class="error invalid-feedback">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            
                            <div class="col-md-6">
                                @if ($photo)
                                Photo Preview:
                                <div class="mt-1">
                                    <img width="100" height="100" src="{{ $photo->temporaryUrl() }}">
                                </div>

                                @endif
                            </div>


                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="button" class="btn btn-success swalDefaultSuccess">
                            Launch Success Toast
                        </button>
                        <button type="submit" class="btn btn-info ">Save</button>
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

        @foreach($errors->all() as $error)
            Toasts("{{ $error }}", '', 'error');
        @endforeach

    });
</script>
@endsection


