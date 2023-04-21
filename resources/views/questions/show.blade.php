@extends('layouts.app')

@section('content')
<style>
    #answer {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 60%;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
    }

    a.reply {
        cursor: pointer;
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
                                <div class="ml-auto"><a href="/questions" class="btn btn-outline-secondary">Back to all Questions</a></div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-1">
                                <a href="#" class="pr-3">
                                    <img class="rounded-circle" src="https://www.gravatar.com/avatar/8474e33c65caeb6891774fe495f2dbde?s=32" width="70px">
                                </a>
                            </div>
                            <div class="col-11">
                                <a href="#">{{ $question->user->name }}</a>
                                <span class="text-muted ml-3">{{ $question->getTimeAgo($question->created_at) }}</span>
                                <p>{!! $question->body !!}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-11 d-flex justify-content-between">
                                <p><a href="#">Bạn</a> đã thích điều này.</p>
                                <div>
                                    <a href="#">Thích</a>
                                    <a class="ml-3 reply">Trả lời</a>
                                    <a class="ml-3" href="#">. . .</a>
                                </div>
                            </div>
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
        <form id="answer" action="/questions/{{ $question->slug }}/answers" method="POST">
            @csrf
            <div class="form-group">
                <button type="button" class="btn btn-lg btn-outline-primary cancel">
                    -
                </button>
                <textarea id="editor" rows="7" name="body"></textarea>
                <button type="submit" class="btn btn-lg btn-outline-primary">
                    Gửi
                </button>
            </div>
        </form>


    </div>
    <script>
        var myEditor;
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                myEditor = editor;
            })
            .catch(error => {
                console.error( rror);
            });


        (function($) {
            // Ẩn hiện phần trả lời
            $(document).on('click', '.reply',function(e) {
                e.preventDefault();

                if($(this).data('id')){
                    $('#editor').data('parent_id', $(this).data('id'));
                }

                $('#answer').slideDown();
            });
            $('.cancel').click(function(e) {
                e.preventDefault();
                $('#answer').slideUp();
            });

            // Gửi câu trả lời
            $('#answer').submit(function(e) {
                e.preventDefault();

                if($('#editor').data('parent_id')){
                    var parent_id = $('#editor').data('parent_id');
                }
                var body = myEditor.getData();
                var formData = new FormData(this);

                formData.append('body', body);
                formData.append('parent_id', parent_id);

                var url = '/questions/{{ $question->slug }}/answers';

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
                    }
                });
            });
        })(jQuery);


    </script>
@endsection
