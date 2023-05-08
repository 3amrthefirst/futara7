<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <img src="" alt="">
    <h1>شركة فوتره  </h1>


    <p>فاتوره ضريبه مبسطة</p>
    </p>

    <hr>
    <div>
        <span >
            <p> &nbsp;   التاريخ &nbsp; &nbsp; {{$data->created_at}} &nbsp;</p>
        </span>

    </div>
    <hr>


    <h2> رقم الفاتوره : {{$data->id}}  </h2>
    <h2> رقم الضريبي للمنشأه : {{$data->company->tax_number}} </h2>
    <hr>
    <div >
            <span >
                <p> &nbsp;   الاجمالي &nbsp; &nbsp; {{$data->final_price}} &nbsp;</p>
            </span>
        <span >
                <p> &nbsp;   السعر &nbsp; &nbsp; {{$data->price_before_tax}} &nbsp;</p>
            </span>
        <span >
                <p> &nbsp;   الكميه &nbsp; &nbsp; {{count($data->products)}} &nbsp;</p>
            </span>
        <span >
                <p> &nbsp;   اسم الصنف &nbsp; &nbsp;
                    <br>
                    @foreach($data->products as $product)
                        {{$product->title}}
                    <br>
                    @endforeach
                    &nbsp;</p>
            </span>
    </div>


    <hr>
    <div>
        <p>  مبلغ الفاتزره الاجمالي {{$data->final_price}} &nbsp;</p>
    </div>
    <hr>
    <div>
        <p>{{$data->price_before_tax}}     اجمالي المبلغ غير شامل الضريبه المضافه <span> &nbsp;ريال سعودي</span></p>
    </div>
    <div>
        <p>  <span> &nbsp;SAR</span>  {{$data->final_price}}:Total amount </p>
    </div>

    <div>
        <p>  مجموع ضريبة القيمه المضافه {{$data->tax_amount}}<span> &nbsp;ريال سعودي</span>  </p>
    </div>

    <hr>
    <div>
        <p>  <span> &nbsp;SAR</span>  :Total  amount</p>
    </div>
    <div>
        <p>     اجمالي المبلغ {{$data->final_price}}<span> &nbsp;ريال سعودي</span></p>
    </div>


    <hr>


</body>
</html>
