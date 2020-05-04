<form action="{{route("user.login")}}" enctype="multipart/form-data" method="post">
    @csrf
    <input type="text" name="email" id="">
    <input type="text" name="password" id="">
    <button type="submit">login</button>
</form>

<form action="{{route("facebook.login")}}">
    <button type="submit">facebook</button>
</form>


@if(count($errors))
    <div class="input-group">
        <div class="alert alert-danger error-row">
            <p class="my-1 px-2">{{ $errors->first() }}</p>
        </div>
    </div>
@endif

