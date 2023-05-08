@extends('admin.layouts.main',[
								'page_header'		=> 'المنتجات',
								'page_description'	=> 'عرض ',
								'link' => url('admin/product')
								])
@section('content')
    <div class="ibox ibox-primary">
        <div class="ibox-title">
            <div class="pull-left">
                <a href="{{url('admin/product/create')}}" class="btn btn-primary">
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
                            'placeholder' => 'اسم المنتج'
                        ])!!}
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
                    <th class="text-center">اسم المنتج </th>
                    <th class="text-center"> السعر  </th>
                    <th class="text-center"> السعر الاختياري </th>
                    <th class="text-center">  الصوره   </th>
                    <th class="text-center">  اسم الشركه  </th>
                    <th class="text-center">  اسم القسم  </th>
                    <th class="text-center"> تعديل</th>
                    <th class="text-center">حذف</th>
                    </thead>
                    <tbody>

                    @foreach($records as $record)
                        <tr id="removable{{$record->id}}">
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td class="text-center">{{optional($record)->title}}</td>
                            <td class="text-center">{{optional($record)->price}}</td>
                            <td class="text-center">{{optional($record)->optional_price}}</td>
                            @if($record->attachmentRelation)
                                <td class="text-center">
                                    <img src="{{asset($record->attachmentRelation->path)}}" style="width:60px;height:60px;border-raduis:100px;">
                                </td>
                            @else
                                <td class="text-center">
                                    لا يوجد صوره
                                </td>
                            @endif
                            <td class="text-center">{{ $record->category->company->name   }} </td>
                            <td class="text-center">{{$record->category->title  }} </td>
                            <td class="text-center">
                                    <a href="{{ route('product.edit',$record->id) }}" class="btn btn-xs btn-success"><i
                                            class="fa fa-edit"></i></a>
                            </td>
                            <td class="text-center">
                                <form action="{{route('product.destroy' , $record->id)}}" method="post">
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
