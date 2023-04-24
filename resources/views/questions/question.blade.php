<div>
    <div class="row mt-4">
        <div class="col-1">
            <a href="#" class="pr-3">
                <img class="rounded-circle" src="https://www.gravatar.com/avatar/8474e33c65caeb6891774fe495f2dbde?s=32" width="70px">
            </a>
        </div>
        <div class="col-11">
            <a href="#">{{ $question->user->fullname }}</a>
            <span class="text-muted ml-3">{{ $question->getTimeAgo($question->created_at) }}</span>
            <p id="question-body">{!! $question->body !!}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-1"></div>
        <div class="col-11 d-flex justify-content-between">
            @auth
                @if (in_array($question->id, $likedQuestions))
                    <p id="liked-question"><a href="#">Bạn</a> đã thích câu hỏi này.</p>
                @else
                    <p id="liked-question"></p>
                @endif
            <div class="d-flex justify-content-between align-items-center">
                <form class="form-like" method="POST">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <button type="submit" class="question{{ in_array($question->id, $likedQuestions) ? ' liked' : '' }} feature-color btn-modified" id="btn-like-post">Thích</button>
                </form>
                <button class="mr-3 ml-3 feature-color btn-modified reply">Trả lời</button>
                <div class="dropdown">
                    <button class="dropbtn btn-modified"><i class="fas fa-ellipsis-h fa-lg feature-color feature-modify"></i></button>
                    <div class="dropdown-content">
                        <button class="dropdown-btn" id="btn-modify-post">Sửa</button>
                        <form id="form-delete-question" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="question_id" value="{{ $question->id }}">
                            <button type="submit" class="dropdown-btn btn-delete-question">Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <p></p>
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="feature-color btn-modified" data-toggle="modal" data-target="#loginModal">Thích</button>
            </div>
            @endauth
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
