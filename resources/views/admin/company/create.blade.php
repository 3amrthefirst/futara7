@extends('admin.layouts.main',[
                                'page_header'       => 'الشركات',
                                'page_description'  => ' اضافة شركه ',
                                'link' => url('admin/subscricompaniesption')
                                ])
@section('content')


    <!-- general form elements -->
    <div class="ibox">
        <!-- form start -->
        {!! Form::model($model,[
                                'action'=>'Admin\CompanyController@store',
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'POST',
                                'files' => true
                                ])!!}

        <div class="ibox-content">
            @include('admin.company.form')
        </div>
            <div class="ibox-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>
        {!! Form::close()!!}
    </div>

@endsection
