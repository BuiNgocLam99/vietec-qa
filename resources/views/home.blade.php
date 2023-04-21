@extends('layouts.app')

@section('content')
    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item"><a data-toggle="tab" href="#questions" class="nav-link active">Questions</a></li>
                                <li class="nav-item"><a data-toggle="tab" href="#answers" class="nav-link">Answers</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                {{--  Phần hiển thị câu hỏi  --}}
                                <div id="questions" class="tab-pane fade in active">
                                    @if ($questions->count() == 0)
                                    <div class="alert alert-warning">
                                        <p>Bạn chưa có bài viết nào</p>
                                        <p><a href="/questions/create" class="">Tạo câu hỏi</a></p>
                                    </div>
                                    @else
                                    @foreach ($questions as $question)
                                    <div class="media post">
                                        <div class="d-flex flex-column counters">
                                            <div class="vote">
                                                <strong>{{ $question->votes_count }}</strong> {{ str_plural('vote', $question->votes_count) }}
                                            </div>
                                            <div class="status {{ $question->status }}">
                                                <strong>{{ $question->answers_count }}</strong> {{ str_plural('answer', $question->answers_count) }}
                                            </div>
                                            <div class="view">
                                                {{ $question->views . " " . str_plural('view', $question->views) }}
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
                                            <div class="excerpt">{{ $question->excerpt(350) }}</div>
                                            <p class="lead">
                                                Đã đăng {{ $question->getTimeAgo($question->created_at) }}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>

                                {{--  Phần hiển thị câu trả lời  --}}
                                <div id="answers" class="tab-pane fade">
                                    @if ($answers->count() == 0)
                                        <div class="alert alert-warning">
                                            <p>Bạn chưa trả lời bài viết nào</p>
                                        </div>
                                    @else
                                    @foreach ($answers as $answer)
                                    <div class="media post">
                                        <div class="d-flex flex-column counters">
                                            <div class="vote">
                                                <strong>{{ $answer->votes_count }}</strong> {{ str_plural('vote', $answer->votes_count) }}
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="d-flex align-items-center">
                                                <h3 class="mt-0"><a href="{{ route("questions.show", $question->slug) }}">{{ $question->title }}</a></h3>
                                            </div>
                                            <div class="excerpt">{{ $answer->excerpt(250) }}</div>
                                            <p class="lead">
                                                Đã trả lời {{ $answer->getTimeAgo($answer->created_at) }}
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
