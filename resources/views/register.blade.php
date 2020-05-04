<form action="{{route("user.register")}}" enctype="multipart/form-data" method="post">
    <input type="text" name="username" id="">
    <input type="text" name="first_name" id="">
    <input type="text" name="last_name" id="">
    <input type="text" name="email" id="">
    <input type="text" name="password" id="">
    <input type="text" name="password_confirmation" id="">
    <button type="submit">register</button>
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

