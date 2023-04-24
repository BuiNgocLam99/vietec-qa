<div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>
                            {{ $question->answers->count() }} Câu trả lời
                        </h2>
                    </div>
                    <hr>
                    @foreach ($question->answers as $answer)
                    <div class="row">
                        <div class="col-1">
                            <a href="#" class="pr-3">
                                <img class="rounded-circle" src="https://www.gravatar.com/avatar/8474e33c65caeb6891774fe495f2dbde?s=32" width="70px">
                            </a>
                        </div>
                        <div class="col-11">
                            <a href="#">{{ $answer->user->fullname }}</a>
                            <span class="text-muted ml-3">{{ $answer->getTimeAgo($answer->created_at) }}</span>
                            <p>{!! $answer->body !!}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-11 d-flex justify-content-between align-items-center">
                            @auth
                                @if (in_array($answer->id, $likedAnswers))
                                    <p id="liked-answer-{{ $answer->id }}"><a href="#">Bạn</a> đã thích câu trả lời này.</p>
                                @else
                                    <p id="liked-answer-{{ $answer->id }}"></p>
                                @endif
                                
                            <div class="d-flex justify-content-between align-items-center">
                                <form class="form-like" method="POST">
                                    @csrf
                                    <input type="hidden" name="answer_id" value="{{ $answer->id }}">
                                    <button type="submit" class="question{{ in_array($answer->id, $likedAnswers) ? ' liked' : '' }} feature-color btn-modified" id="btn-like-answer-{{ $answer->id }}">Thích</button>
                                </form>
                                <button class="mr-3 ml-3 feature-color btn-modified reply" data-id="{{ $answer->id }}" data-fullname="{{ $answer->user->fullname }}">Trả lời</button>
                                <div class="dropdown">
                                    <button class="dropbtn btn-modified"><i class="fas fa-ellipsis-h fa-lg feature-color feature-modify"></i></button>
                                    <div class="dropdown-content">
                                        <button class="dropdown-btn">Sửa</button>
                                        <form class="form-delete-answer" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="answer_id" value="{{ $answer->id }}">
                                            <input type="hidden" name="question_id" value="{{ $answer->question_id }}">
                                            <button type="submit" class="dropdown-btn btn-delete-answer">Xóa</button>
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
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    (function($) {
        
    })(jQuery);
</script>
