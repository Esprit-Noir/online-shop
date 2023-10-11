@extends('admin.dashboard.layouts.base')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Category</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <p>@include('admin.dashboard.layouts.partials.message')</p>
                        <a href="{{route('admin.categories')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <form action="" method="post" id="categoryForm" name="categoryForm">
                    @csrf
                <div class="card">

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    <p class="text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                    <p class="text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Create</button>
                    <a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
                    <form/>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('script')
    <script>
        $('#categoryForm').submit(function (event){
            event.preventDefault();
            var element = $(this);
            $.ajax({
                url: '{{route('admin.store-categories')}}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response){
                    if(response['status'] == true){
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feetback').html("");
                        $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feetback').html("");
                    }else {
                        var errors = response['errors'];
                        if(errors['name']){
                            $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feetback').html(errors['name']);
                        }else {
                            $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feetback').html("");

                        }
                        if(errors['slug']){
                            $('#slug').addClass('is-invalid').siblings('p').addClass('invalid-feetback').html(errors['slug']);
                        }else {
                            $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feetback').html("");
                        }
                    }
                },
                error: function (jqXHR, exception){
                    console.log('Something went wrong!')
                }
            })
        });
        $("#name").change(function (){
            element = $(this);
            $.ajax({
                url: '{{route("getSlug")}}',
                type: 'get',
                data: {title: element.val()},
                dataType: 'json',
                success: function(response){
                    if (response['status'] == true){
                        $("#slug").val(response["slug"]);
                    }
                }
            });
        });
    </script>
@endsection
