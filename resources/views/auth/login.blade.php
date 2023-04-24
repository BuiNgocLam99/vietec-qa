@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Đăng nhập</div>

                <div class="card-body">
                    
                    <form method="POST" id="form">
                        @csrf
                        
                        <div id="message"></div>

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

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Nhớ tài khoản
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Đăng nhập
                                </button>

                                <a class="btn btn-link" href="">
                                    Quên mật khẩu?
                                </a>
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

                $('span[id*="_error"]').text('');

                $.ajax({
                    url: "{{ route('login-post') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        if(response.error_message){
                            return $('#message').addClass('text-danger').text(response.error_message);
                        }else{
                            window.location.assign(response.url);
                        }
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
