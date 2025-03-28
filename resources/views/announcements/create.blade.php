@extends('adminlte.app')
@section('style')
<link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Announcement</h1>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <form action="{{ route('announcements.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <textarea id="summernote" name="content"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-default text-success"><i class="fad fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function () {
        // Summernote
        $('#summernote').summernote({
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18','24', '36', '48' , '64', '82', '150'],
			height: '320px',
			minHeight: null,             // set minimum height of editor
  			maxHeight: null, 
			dialogsInBody: true,
			dialogsFade: true,
			disableDragAndDrop: true,
			spellCheck: true,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'underline', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['table', ['table']],
				['insert', ['link', 'picture']],
				['view', ['fullscreen'/*, 'codeview', 'help'*/]],
			]
        })
    })
</script>
@endsection
