@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Ask Question</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to all
                                    Questions</a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <form id="form" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="question-title">Question Title</label>
                                <input type="text" name="title" class="form-control">
                                <span id="title_error" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="question-body">Explain you question</label>
                                <div class="card">
                                    <div id="writequestion-body">
                                        <textarea id="editor" name="body" rows="10" class="form-control" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 244px;"></textarea>
                                        <span id="body_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-primary btn-lg">
                                    Ask Question
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );

            (function($) {
                $('form').submit('submit', function(e){
                    e.preventDefault();

                    var formData = new FormData(this);

                    $.ajax({
                        url: '{{ route('questions.store') }}',
                        type: 'POST',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(response){
                            var url = response.url;
                            window.location.href = url;
                        }
                    });
                })
            })(jQuery);
    </script>
@endsection
