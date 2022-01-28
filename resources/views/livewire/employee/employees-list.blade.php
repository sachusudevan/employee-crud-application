<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Employees</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Employees</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Employees List</h3>
                            <div class="card-tools">
                                <a class="btn btn-primary" href="{{route('employees.add')}}" title="Create New Employee"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="employees-datatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Designation</th>
                                        <th>Created On</th>
                                        <th>Updated On</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Designation</th>
                                        <th>Created On</th>
                                        <th>Updated On</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



@section('script')
<script>
    $(document).ready(function () {
        
        @foreach($errors->all() as $error)
            Toasts("{{ $error }}", '', 'error');
        @endforeach
        
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
        
        var oTable = $('#employees-datatable').DataTable({
            "oLanguage": {
                "sSearch": "Search all columns:"
            },
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{route('get-employees-list-for-datatable')}}",
                "method" : "POST",
                "data": function (d) {

                }
            },
//            , "orderable": false
            "columns": [
                {"data": null},
                {"data": "photo"},
                {"data": "name"},
                {"data": "email"},                
                {"data": "designation"},
                {"data": "created_at"},
                {"data": "updated_at"},
                {"data": "id"}
            ],
            'columnDefs': [
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                },
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 1,
                    'render': function (data, type, full, meta) {
                        var editHTML = '';
                        
                        if(data != '')
                        {
                            editHTML = '<img src="'+data+'" style="border-radius: 50%;" width="50" height="50">';
                        }else{
                            editHTML = '<img src="{{asset('dist/img/avatar5.png')}}" style="border-radius: 50%;" width="50" height="50">';
                        }

                        return editHTML;
                    }
                },
                {
                    "searchable": true,
                    "orderable": true,
                    "targets": 2,
                    'render': function (data, type, full, meta) {
                        return '<a href="'+full.edit_url+'" > '+data+'</a>';
                    }
                },
                {
                    "searchable": false,
                    "orderable": false,
                    "targets": 7,
                    'render': function (data, type, full, meta) {
                        return '<button class="btn btn-danger btn-xs delete_record" data-id="'+data+'"  title="Delete"><i class="fa fa-trash"></i></button>';
                    }
                },
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var index = iDisplayIndex + 1;
                $('td:eq(0)', nRow).html(index);
                return nRow;
            },
            'iDisplayLength': 25,
            "sPaginationType": "full_numbers",
            "dom": 'T<"clear">lfrtip',
            "order": [[0, 'desc']]
        });

    });
</script>
@endsection