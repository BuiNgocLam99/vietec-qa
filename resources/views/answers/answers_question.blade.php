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
                            <a href="#">{{ $answer->user->name }}</a>
                            <span class="text-muted ml-3">{{ $answer->getTimeAgo($answer->created_at) }}</span>
                            <p>{!! $answer->body !!}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-11 d-flex justify-content-between">
                            <p><a href="#">Bạn</a> đã thích điều này.</p>
                            <div>
                                <a href="#answer">Thích</a>
                                <a class="ml-3 reply" data-id="{{ $answer->id }}">Trả lời</a>
                                <a class="ml-3" href="#">. . .</a>
                            </div>
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
