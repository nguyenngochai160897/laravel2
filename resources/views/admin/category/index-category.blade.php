@extends("admin.layouts.default")

@section("title", "category")

@section("content")
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Quản lý danh mục
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border clearfix">
                        <h3 class="box-title pull-left">Danh sách danh mục</h3>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="add-category">
                                <i class="fa fa-plus"></i> Add
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Tên danh mục</th>
                                    <th>Tổng số bài viết</th>
                                    <th>Chức năng</th>
                                </tr>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category['id'] }}</td>
                                    <td>{{ $category['name'] }}</td>
                                    <td>{{ count($category['posts']) }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="{{ route('edit-category', ['id'=> $category['id']]) }}"><i class="fa fa-edit"></i> Edit</a> | <a class="btn btn-danger btn-sm" href="{{  route('delete-category', ['id' => $category['id']]) }}"><i class="fa fa-trash"></i> Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            <li><a href="#">«</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">»</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection