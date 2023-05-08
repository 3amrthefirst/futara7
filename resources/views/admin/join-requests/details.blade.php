@extends('admin.layouts.main',[
								'page_header'		=> ' المشتركين في الباقه',
								'page_description'	=> 'عرض ',
								'link' => url('admin/subscription-details')
								])
@section('content')
    <div class="ibox-content">
            <div class="table-responsive">
                <table class="data-table table table-bordered">
                    <thead>
                    <th class="text-center"> م</th>
                    <th class="text-center">  اسم الشركه </th>
                    <th class="text-center"> الرقم  </th>
                    <th class="text-center"> تاريخ انتهاء الاشتراك</th>
                    </thead>
                    <tbody>

                    @foreach($records->company as $record)
                        <tr id="removable{{$record->id}}">
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td class="text-center">{{optional($record)->name}}</td>
                            <td class="text-center">{{optional($record)->phone}}</td>
                            <td class="text-center">{{optional($record)->subscription_end_date}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            </div>

@endsection
