{!! \App\MyHelper\Field::text('title' , 'الاسم' ) !!}
{!! \App\MyHelper\Field::text('price' , 'السعر' ) !!}
{!! \App\MyHelper\Field::number('optional_price	' , ' السعر الاختياري ' ) !!}
{!! \App\MyHelper\Field::fileWithPreview('image' , 'الصوره' ) !!}
<div class="form-group {{$errors->has('category_id') ? 'has-error':'' }}" id="{{'category_id'}}_wrap">
    <label for="{{'category_id'}}">{{'اسم القسم'}}</label>
    <div class="">
        <select name="{{'category_id'}}" class="form-control">
            @foreach($category as $com)
                <option value="{{$com->id}}"> قسم :{{$com->title}} | شركه {{ $com->company->name }} </option>
            @endforeach
        </select>
    </div>
    <span class="help-block"><strong id="{{'category_id'}}_error">{{$errors->first('category_id')}}</strong></span>
</div>
