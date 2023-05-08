@extends('admin.layouts.main',[
                                    'page_header'       => 'الصفحة الرئيسية',
                                    'page_description'  => 'إحصائيات عامة',
                                    'link' => url('admin')
                                ])
@section('content')


@push('styles')
    {{-- ChartStyle --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
@endpush

@push('scripts')
    {!! $line1->script() !!}
    {!! $line2->script() !!}
    {{-- {!! $pie->script() !!} --}}
@endpush
<div class="col-lg-3 col-md-10 col-sm-10 col-xs-10">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>العملاء</h5>
        </div>
        <div class="ibox-content">
            <h1 class="no-margins">{{ $company->count() }}</h1>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-10 col-sm-10 col-xs-10">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>عملاء العملاء</h5>
        </div>
        <div class="ibox-content">
            <h1 class="no-margins">{{ $client->count() }}</h1>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-10 col-sm-10 col-xs-10">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>اقسام الشركات</h5>
        </div>
        <div class="ibox-content">
            <h1 class="no-margins">{{ $category->count() }}</h1>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-10 col-sm-10 col-xs-10">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>منتجات الشركات</h5>
        </div>
        <div class="ibox-content">
            <h1 class="no-margins">{{ $product->count() }}</h1>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-10 col-sm-10 col-xs-10">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>عدد الفواتير</h5>
        </div>
        <div class="ibox-content">
            <h1 class="no-margins">0</h1>
        </div>
    </div>
</div>
<div class="ibox ">
    <div class="row">
        <div class="col-md-6">
            <div class="ibox-title">
                <h5>الفواتير شهريا</h5>
            </div>
            <div class="ibox-content">
                {!! $line1->container() !!}
            </div>

        </div>
        <div class="col-md-6">
            <div class="ibox-title">
                <h5>العملاء شهريا</h5>
            </div>
            <div class="ibox-content">
                {!! $line2->container() !!}
            </div>

        </div>
    </div>

</div>

@endsection

