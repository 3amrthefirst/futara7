@extends('admin.layouts.main',[
								'page_header'		=> 'اقسام الشركات',
								'page_description'	=> 'عرض ',
								'link' => url('admin/companies')
								])
@section('content')
    <div class="ibox ibox-primary">

        <div class="ibox-title">
            {!! Form::open([
                'method' => 'GET',
            ]) !!}
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::text('title',request()->input('group'),[
                        'class' => 'form-control',
                            'placeholder' => 'اسم القسم'
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
                    <th class="text-center">اسم القسم </th>
                    <th class="text-center"> منتجات القسم </th>
                    <th class="text-center"> تعديل</th>
                    <th class="text-center">حذف</th>
                    </thead>
                    <tbody>

                    @foreach($records as $record)
                        <tr id="removable{{$record->id}}">
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td class="text-center">{{optional($record)->title}}</td>
                            <td class="text-center">
                                <a href="{{ route('category.products',$record->id) }}" class="btn btn-xs btn-success">  <i
                                        class="fa fa-eye"></i></a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('category.edit',$record->id) }}" class="btn btn-xs btn-success"><i
                                        class="fa fa-edit"></i></a>
                            </td>
                            <td class="text-center">
                                <form action="{{route('category.destroy' , $record->id)}}" method="post">
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
