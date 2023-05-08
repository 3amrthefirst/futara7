
@extends('admin.layouts.main',[
                                'page_header'       => 'الشركات',
                                'page_description'  => ' تعديل   ',
                                'link' => url('admin/companies')
                                ])
@section('content')
        <!-- general form elements -->
<div class="ibox">
    <!-- form start -->
    {!! Form::model($model,[
                            'url'=>url('admin/companies/'.$model->id),
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'PUT',
                            'files' => true
                            ])!!}

    <div class="ibox-body">
        <div class="clearfix"></div>
        <br>
        <div class="ibox-content">
            @include('admin.company.form')
        </div>

        <div class="ibox-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>

    </div>
    {!! Form::close()!!}

</div><!-- /.box -->

@endsection
