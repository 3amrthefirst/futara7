

<div class="form-group {{$errors->has($name) ? 'has-error':'' }}" id="{{$name}}_wrap">
    <label for="{{$name}}">{{$label}}</label>
    <div class="">
       <select name="{{$name}}" class="form-control">
        @foreach($options as $com)
            <option value="{{$com->id}}"> {{$com->name}} </option>
        @endforeach
       </select>
    </div>
    <span class="help-block"><strong id="{{$name}}_error">{{$errors->first($name)}}</strong></span>
</div>
