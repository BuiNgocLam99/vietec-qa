<div class="media post">
    <div class="d-flex flex-column counters">
        <div class="likes">
            {{-- <strong>{{ $question->likes }}</strong> {{ str_plural('Lượt thích', $question->likes) }} --}}
            <strong>{{ $question->likes_count }}</strong> Lượt thích
        </div>
        <div class="answers">
            {{-- <strong>{{ $question->answers_count }}</strong> {{ str_plural('Câu trả lời', $question->answers_count) }} --}}
            <strong>{{ $question->answers_count }}</strong> Câu trả lời
        </div>
        <div class="views">
            <strong>{{ $question->views}}</strong> Lượt xem
        </div>
    </div>
    <div class="media-body">
        <div class="d-flex align-items-center">
            <h3 class="mt-0"><a href="{{ route("questions.show", $question->slug) }}">{{ $question->title }}</a></h3>
            <div class="ml-auto">
                @can ('update', $question)
                    <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-info">Edit</a>
                @endcan
                @can ('delete', $question)
                    <form class="form-delete" method="post" action="{{ route('questions.destroy', $question->id) }}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                @endcan
            </div>
        </div>
        <p class="lead">
            Tạo bởi
            <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
            <small class="text-muted">{{ $question->created_date }}</small>
        </p>
        <div class="excerpt">{{ $question->excerpt(350) }}</div>
    </div>
</div>
