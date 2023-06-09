@extends('admin.layouts.main',[
								'page_header'		=> 'العملاء',
								'page_description'	=> 'عرض ',
								'link' => url('admin/companies')
								])
@section('content')
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <div class="pull-left">
                <a href="{{url('admin/companies/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> إضافة جديد
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="ibox-title">
            {!! Form::open([
                'method' => 'GET',
            ]) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::text('name',request()->input('group'),[
                        'class' => 'form-control',
                            'placeholder' => 'اسم العملاء'
                        ])!!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::text('phone',request()->input('phone'),[
                            'class' => 'form-control',
                            'placeholder' => 'رقم الهاتف'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::text('email',request()->input('email'),[
                            'class' => 'form-control',
                            'placeholder' => 'الايميل'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="ibox-content">
        @include('flash::message')
        @if(count($records))
            <div class="table-responsive">
                <table class="data-table table table-bordered">
                    <thead>
                    <th class="text-center"> م</th>
                    <th class="text-center">اسم العميل </th>
                    <th class="text-center"> رقم الهاتف </th>
                    <th class="text-center"> البريد الالكتروني</th>
                    <th class="text-center">  تاريخ انتهاء الاشتراك </th>
                    <th class="text-center"> نوع الباقه  </th>
                    <th class="text-center"> العنوان   </th>
                    <th class="text-center"> السجل الضريبي   </th>
                    <th class="text-center">  نسبه الضريبه  </th>

                    <th class="text-center">  العملاء  </th>
                    <th class="text-center">  الاقسام  </th>
                    <th class="text-center"> تعديل</th>
                    <th class="text-center">حذف</th>
                    </thead>
                    <tbody>

                    @foreach($records as $record)
                        <tr id="removable{{$record->id}}">
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td class="text-center">{{optional($record)->name}}</td>
                            <td class="text-center">{{optional($record)->phone}}</td>
                            <td class="text-center">{{optional($record)->email}}</td>
                            <td class="text-center">{{optional($record)->subscription_end_date}}</td>
                            @if($record->subscribe)
                            <td class="text-center">{{optional($record)->subscribe->name }} </td>
                            @else
                                <td class="text-center">test</td>
                            @endif
                            <td class="text-center"> {{$record->address}} </td>
                            <td class="text-center"> {{$record->tax_number}} </td>
                            <td class="text-center"> {{$record->tax_rate}} </td>
                                <td class="text-center">
                                <a href="{{ route('company.clients',$record->id) }}" class="btn btn-xs btn-success"> العملاء <i
                                        class="fa fa-user"></i></a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('company.categories',$record->id) }}" class="btn btn-xs btn-success"> الاقسام <i
                                        class="fa fa-recycle"></i></a>
                            </td>
                            <td class="text-center">
                                    <a href="{{ route('companies.edit',$record->id) }}" class="btn btn-xs btn-success"><i
                                            class="fa fa-edit"></i></a>
                            </td>
                            <td class="text-center">
                                <form action="{{route('companies.destroy' , $record->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>


                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $records->appends(request()->all())->render() !!}
            </div>


        @else
            <div>
                <h3 class="text-info" style="text-align: center"> لا توجد بيانات للعرض </h3>
            </div>
        @endif
    </div>

@endsection
