@extends('admin.layouts.main',[
								'page_header'		=> 'رسائل التواصل',
								'page_description'	=> 'عرض ',
								'link' => url('admin/contacts')
								])
@section('content')
    <div class="ibox-content">
        @include('flash::message')
        @if(count($records))
            <div class="table-responsive">
                <table class="data-table table table-bordered">
                    <thead>
                    <th class="text-center"> م</th>
                    <th class="text-center"> رقم الهاتف </th>

                  <th class="text-center">تعديل</th>
{{--                   <th class="text-center">حذف</th>--}}
                    </thead>
                    <tbody>

                    @foreach($records as $record)
                        <tr id="removable{{$record->id}}">
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td class="text-center">{{optional($record)->phone}}</td>
                            <td class="text-center">
                                <a href="{{ route('contacts.edit',$record->id) }}" class="btn btn-xs btn-success"><i
                                        class="fa fa-edit"></i></a>
                            </td>
{{--                            <td class="text-center">--}}
{{--                                <form action="{{route('contacts.destroy' , $record->id)}}" method="post">--}}
{{--                                    @csrf--}}
{{--                                    @method('delete')--}}
{{--                                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>--}}
{{--                                </form>--}}
{{--                            </td>--}}
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
