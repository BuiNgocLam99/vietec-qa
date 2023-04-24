@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Đăng ký</div>

                <div class="card-body">
                    <form id="form" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" required autofocus>
                                <span id="username_error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fullname" class="col-md-4 col-form-label text-md-right">Fullname</label>

                            <div class="col-md-6">
                                <input id="fullname" type="text" class="form-control" name="fullname" required autofocus>
                                <span id="fullname_error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" name="email" type="email" class="form-control" required autofocus>
                                <span id="email_error" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Mật khẩu</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                                <span id="password_error" class="text-danger"></span>
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Đăng ký
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function($) {
    $(document).ready(function(){

    $(".spinner-container").hide();

    $('#form').submit(function(e){
    e.preventDefault();

    $(".spinner-container").show();

    var formData = new FormData(this);

    $('span[id*="_error"]').text("");

    $.ajax({
    url: "{{ route('register') }}",
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    beforeSend: function() {
    $('.spinner').show();
    },
    success: function(response){
    window.location.assign(response.url);
    },
    error: function(reject){
    var response = $.parseJSON(reject.responseText);
    $.each(response.errors, function(key, val){
        $("#" + key + "_error").text(val[0]);
    })
    },
    complete: function() {
    $(".spinner-container").hide();
    }
    })
    })
    })                                                                                          
    })(jQuery);
</script>
@endsection
