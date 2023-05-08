@extends('admin.layouts.main',[
                                'page_header'       => 'المنتجات',
                                'page_description'  => ' اضافة منتج ',
                                'link' => url('admin/product')
                                ])
@section('content')


    <!-- general form elements -->
    <div class="ibox">
        <!-- form start -->
        {!! Form::model($model,[
                                'action'=>'Admin\ProductController@store',
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'POST',
                                'files' => true
                                ])!!}

        <div class="ibox-content">
            @include('admin.products.form')
        </div>
            <div class="ibox-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>
        {!! Form::close()!!}
    </div>

@endsection
