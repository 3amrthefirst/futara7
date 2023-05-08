
@extends('admin.layouts.main',[
                                'page_header'       => 'المنتجات',
                                'page_description'  => ' تعديل   ',
                                'link' => url('admin/product')
                                ])
@section('content')
        <!-- general form elements -->
<div class="ibox">
    <!-- form start -->
    {!! Form::model($model,[
                            'url'=>url('admin/product/'.$model->id),
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'PUT',
                            'files' => true
                            ])!!}

    <div class="ibox-body">
        <div class="clearfix"></div>
        <br>
        <div class="ibox-content">
            @include('admin.products.form-edit')
        </div>

        <div class="ibox-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>

    </div>
    {!! Form::close()!!}

</div><!-- /.box -->

@endsection
