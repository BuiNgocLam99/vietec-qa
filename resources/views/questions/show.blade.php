@extends('layouts.app')

@section('title')
    - {{ $question->title }}
@endsection

@section('content')
<style>
    *{
        padding: 0;
        margin: 0;
        border: none;
    }

    /* #answer {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 60%;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
    } */
    /* #answer {
    display: none;
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  width: 60%;
  margin: 0 auto; 
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
}  */

#answer {
  display: none;
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  width: 60%;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
  border-radius: 10px;
  border-top: 4px solid #2196F3;
}

#answer .top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

#answer .top-bar button {
  background-color: transparent;
  border: none;
  cursor: pointer;
  font-size: 20px;
  color: #2196F3;
}

#answer .top-bar button:hover {
  color: #1565C0;
}

#answer.minimized {
  width: 50px;
  height: 50px;
  padding: 5px;
}

#answer.minimized .top-bar {
  margin-bottom: 0;
}

#answer.minimized .form-group {
  display: none;
}

#answer.minimized button {
  font-size: 24px;
}

#answer.minimized textarea {
  display: none;
}

/*  */

    .feature-color{
        color: #666666;
        cursor: pointer;
    }

    .feature-color:hover{
        color: #466a9c
    }

    .feature-color:active{
        color: #C5CFDE
    }

    .liked{
        color: #2078F4;
    }

    .btn-modified{
        outline: none;
        border: none;
        background: none
    }

    .btn-modified:focus{
        outline: none;
        border: none;
    }

    .feature-modify {
        text-align: center;
        width: 28px;
        padding: 1px;
        border-radius: 50px;
    }

    .feature-modify:hover {
        border: 1px solid #D7DFEA;
        background: #D7DFEA;
    }

    .feature-modify:active {
        border: 1px solid #D7DFEA;
        background: #C5CFDE;
    }

    /* CSS của nút dropdown, phần chỉnh sửa hoặc xóa */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropbtn {
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        z-index: 1;
        min-width: 80px;
        padding: 5px;
        background-color: #f9f9f9;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }

    .dropdown-content a {
        color: black;
        padding: 5px 10px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .feature-modify {
        cursor: pointer;
    }

    .dropdown-content {
        border-radius: 5px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }

    .dropdown-btn {
        background-color: transparent;
        border: none;
        cursor: pointer;
        display: block;
        padding: 5px 10px;
        text-align: left;
        width: 100%;
    }

    .dropdown-btn:hover {
        background-color: #f1f1f1;
    }

    /* --------------------------------------modal dang nhap */

.modal-header {
  background-color: #FFFFFF;
  color: #535353;
}

.modal-body {
  padding: 20px;
}

.modal-footer {
  justify-content: space-between;
}

.modal-footer button {
  width: 100px;
}

.form-control {
  border: none;
  border-radius: 0;
  margin-bottom: 20px;
  padding: 10px;
  font-size: 16px;
}

.form-control:focus {
  box-shadow: none;
  border-bottom: 2px solid #008CBA;
}

.form-control:focus::-webkit-input-placeholder {
  color: #008CBA;
}

.form-control:focus:-moz-placeholder {
  color: #008CBA;
}

.form-control:focus::-moz-placeholder {
  color: #008CBA;
}

.form-control:focus:-ms-input-placeholder {
  color: #008CBA;
}
</style>

    <div class="container">
        {{--  Phần hiển thị câu hỏi  --}}
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h1>{{ $question->title }}</h1>
                                <div class="ml-auto"><a href="/questions" class="btn btn-outline-secondary">Quay lại</a></div>
                            </div>
                        </div>
                        <hr>
                        <div id="question">
                            @include('questions.question')
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        {{--  Phần hiển thị các câu trả lời  --}}
        <div id="answers">
            @include('answers.answers_question', compact('question'))
        </div>


        {{--  Phần viết câu trả lời của bạn  --}}
        @auth
        <div class="row justify-content-center mt-3 reply">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-1">
                                <a href="#" class="pr-3">
                                    <img class="rounded-circle" src="https://www.gravatar.com/avatar/8474e33c65caeb6891774fe495f2dbde?s=32" width="70px">
                                </a>
                            </div>
                            <div class="col-11">
                                <p>Viết câu trả lời ...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="mt-3">
            <button type="button" class="feature-color btn-modified" data-toggle="modal" data-target="#loginModal">Đăng nhập</button> để viết câu trả lời.
        </div>
        @endauth
        <form id="answer" method="POST">
            @csrf
            <div class="form-header">
            </div>
            <div class="form-group">
                <button type="button" class="cancel btn-modified feature-color">
                    <i class="fas fa-times"></i>
                </button>
                <textarea id="editor" rows="7" name="body"></textarea>
                <button type="submit" class="btn btn-lg btn-outline-primary">Send</button>
            </div>
        </form>
        
        <!-- Login Modal -->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" id="form">
                        <div class="modal-body">
                            @csrf
                            <div id="message"></div>
                            <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                            <span id="email_error" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu">
                            <span id="password_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-align-center">Đăng nhập</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Tạo trường dùng ckeditor
        var myEditor;
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                myEditor = editor;
            })
            .catch(error => {
                console.error( rror);
            });


        // Lắng nghe nếu trong phần trả lời có nội dung mới ẩn gửi được


        (function($) {
            // Ẩn hiện phần trả lời
            $(document).on('click', '.reply',function(e) {
                e.preventDefault();

                if($(this).data('id')){
                    $('#editor').attr('data-parent_id', $(this).data('id'));
                    myEditor.setData( '<a href="#">@' + $(this).data('fullname') + ' ' + '</a>' );
                }

                $('#answer').slideDown();
            });
            $('.cancel').click(function(e) {
                e.preventDefault();
                $('#answer').slideUp();
            });


            // Chức năng like
            $(document).on('submit', '.form-like', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                if(formData.has('question_id')){
                    var questionId = formData.get('question_id');
                    $.ajax({
                        url: '/questions/'+questionId+'/like',
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response){
                            if(response.liked){
                                $('#btn-like-post').addClass('liked');
                                $('#liked-question').html('<a href="#">Bạn</a> đã thích câu hỏi này.');
                            }else{
                                $('#btn-like-post').removeClass('liked');
                                $('#liked-question').html('');
                            }
                        }
                    });
                }else{
                    var answerId = formData.get('answer_id');
                    $.ajax({
                        url: '/answers/'+answerId+'/like',
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response){
                            if(response.liked){
                                $('#btn-like-answer-' + answerId).addClass('liked');
                                $('#liked-answer-'+ answerId).html('<a href="#">Bạn</a> đã thích câu trả lời này.');
                            }else{
                                $('#btn-like-answer-' + answerId).removeClass('liked');
                                $('#liked-answer-'+ answerId).html('');
                            }
                        }
                    });
                }
            });

            // Chức năng sửa bài viết
            $('#btn-modify-post').click(function(e) {
                e.preventDefault()

                myEditor.setData('{!! $question->body !!}')
                $('#answer').slideDown();

                $('.cancel').click(function(e){
                    confirm('Bạn có muốn thoát không');
                })

                $(document).on('submit', '#answer', function(e){
                    e.preventDefault();
                    var formData = new FormData();

                    $.ajax({
                        url: 'questions/{{ $question->id }}',
                        type: 'PUT',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            $('#question').html(response.html);
                        }
                    });
                })
            });
          

            // Chức năng xóa câu trả lời
            $(document).on('submit', '.form-delete-answer', function(e) {
                e.preventDefault();
                Swal.fire({
                title: 'Bạn có muốn xóa câu trả lời này không?',
                showDenyButton: true,
                confirmButtonText: 'Có',
                denyButtonText: `Không`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData(this);
                        var answerId = formData.get('answer_id');
                        var questionId = formData.get('question_id');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/questions/'+questionId+'/answers/'+answerId,
                            type: 'DELETE',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response){
                                $('#answers').html(response.html);
                            }
                        });
                    } 
                })
            });

            // Chức năng xóa câu hỏi
            $(document).on('submit', '#form-delete-question', function(e) {
                e.preventDefault();
                Swal.fire({
                title: 'Bạn có muốn xóa hỏi này không?',
                showDenyButton: true,
                confirmButtonText: 'Có',
                denyButtonText: `Không`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData(this);
                        var questionId = formData.get('question_id');
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: '/questions/'+questionId,
                            type: 'DELETE',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(response){
                                window.location.href = "/";
                            }
                        });
                    }
                })
            });


            // Gửi câu trả lời
            $('#answer').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var body = myEditor.getData();
                formData.append('body', body);

                if($('#editor').attr('data-parent_id')){
                    var parent_id = $('#editor').attr('data-parent_id');
                    formData.append('parent_id', parent_id);
                }

                var url = '/questions/{{ $question->id }}/answers';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response){
                        $('#answers').html(response.html);
                        $('#answer').slideUp();
                        myEditor.setData('');
                        $('#editor').attr('data-parent_id', '');
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
