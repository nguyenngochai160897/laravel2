@extends("admin.layouts.default")

@section("title", "post")

@section("content")
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Quản lý bài viết
        </h1>
        <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tìm kiếm</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('post') }}" method="get">
                        <div class="form-inline">
                            <div class="form-group form-inline">
                                <label>Danh mục</label>
                                <select class="form-control" name="category_id">
                                    <option value="">---- Chon danh muc ----</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group form-inline">
                                <label>Trang thai</label>
                                <select class="form-control" name="state">
                                    <option value="">---- Chon trang thai ----</option>
                                    <option value="1">Hien thi</option>
                                    <option value="0">An</option>
                                </select>
                            </div>
                            <div class="form-group form-inline">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Search</button>
                                <button class="btn btn-default" type="submit">Reset</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border clearfix">
                        <h3 class="box-title pull-left">Danh sách bài viết</h3>
                        <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('create-post') }}">
                                <i class="fa fa-plus"></i> Add
                            </a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Tiêu đề</th>
                                    <th>Danh mục</th>
                                    <th>Hình ảnh</th>
                                    <th style="width: 400px">Mô tả ngắn</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đăng</th>
                                    <th>Chức năng</th>
                                </tr>
                                @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post['id'] }}</td>
                                    <td>
                                        <a href="#"> {{ $post['title'] }}</a>
                                    </td>
                                    <td>{{ $post['category']['name'] }}</td>
                                    <td>
                                        <img style="max-width: 150px" src="{{ $post['image'] }}">
                                    </td>
                                    <td>
                                        {{ $post['snapshort'] }}
                                    </td>
                                    <td>
                                        @if($post['state'] == 1)
                                            <button type="button" class="btn btn-info"> Hiển thị </button>
                                        @else
                                            <button type="button" class="btn btn-warning">Ẩn</button>
                                        @endif
                                       
                                    </td>
                                    <td>{{ date("d/m/Y H:i", strtotime($post['created_at'])) }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" href="{{ route('edit-post', ['id' => $post['id']]) }}"><i class="fa fa-edit"></i> Edit</a> | 
                                        <form action="{{  route('delete-post', ['id' => $post['id']]) }}" method="post"> @csrf <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button></form>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
