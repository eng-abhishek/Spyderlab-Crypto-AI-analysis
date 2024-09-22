@extends('backend.layouts.app')

@section('content')
<div class="d-flex align-items-center mb-3">
	<div>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('backend.dashboard')}}">DASHBOARD</a></li>
			<li class="breadcrumb-item active"><a href="{{route('backend.cms.index')}}">CMS</a></li>
			<li class="breadcrumb-item active">CMS</li>
		</ul>
		<h1 class="page-header">Edit CMS</h1>
	</div>
</div>

@include('backend.layouts.partials.alert-messages')

<div class="card">
	<div class="card-body">
	{{ Form::model($record, array('route' => ['backend.cms.update', $record->id], 'id' => 'edit-cms-form')) }}
		@method('PUT')

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Slug: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::text('slug', null, array('class' => 'form-control', 'placeholder' => 'Slug', 'readonly', 'autocomplete' => 'off', 'autofocus')) }}
				@error('slug')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="row mb-3">
			<div class="col-lg-3 col-md-4">
				<label class="form-label" for="">Description: <span class="text-danger">*</span></label>
			</div>
			<div class="col-lg-9 col-md-8">
				{{ Form::textarea('description', null, array('class' => 'form-control wysiwyg-editor', 'placeholder' => 'Description here..', 'autocomplete' => 'off', 'autofocus')) }}
				@error('name')
				<div class="invalid-feedback d-block">{{ $message }}</div>
				@enderror
			</div>
		</div>


		<div class="row">
			<div class="col-lg-12 col-md-12 text-end">
				<button type="submit" class="btn btn-primary">Add</button>
				<a href="{{route('backend.cms.index')}}" class="btn btn-secondary">Back</a>
			</div>
		</div>

		{{ Form::close() }}
	</div>
	<div class="card-arrow">
		<div class="card-arrow-top-left"></div>
		<div class="card-arrow-top-right"></div>
		<div class="card-arrow-bottom-left"></div>
		<div class="card-arrow-bottom-right"></div>
	</div>
</div>
@endsection

@section('scripts')
{!! JsValidator::formRequest('App\Http\Requests\Backend\BlogCategoryRequest', '#add-cms-form'); !!}

<script src="https://cdn.tiny.cloud/1/0zd77szgwodoh5cpn374abwz6ghwbp3h8dw9wvdray0my39i/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

{{--<script src="https://cdn.tiny.cloud/1/6idzkmn8t8dvil9yar9gn3kg2bs9gpvm57hlbry7ls8pfzwq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>--}}

<script type="text/javascript">
	$(document).ready(function(){

		var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

		tinymce.init({
			selector: 'textarea.wysiwyg-editor',
			plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
			imagetools_cors_hosts: ['picsum.photos'],
			menubar: 'file edit view insert format tools table help',
			toolbar: 'undo redo | bold italic underline strikethrough blockquote| fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl | toc',
			toolbar_sticky: true,
			autosave_ask_before_unload: true,
			autosave_interval: '30s',
			autosave_prefix: '{path}{query}-{id}-',
			autosave_restore_when_empty: false,
			autosave_retention: '2m',
			image_advtab: true,
			importcss_append: true,
			images_upload_url: 'postAcceptor.php',
			automatic_uploads: false,
			height: 600,
			image_caption: true,
			quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
			noneditable_noneditable_class: 'mceNonEditable',
			toolbar_mode: 'sliding',
			contextmenu: 'link image imagetools table',
			skin: useDarkMode ? 'oxide-dark' : 'oxide',
			content_css: useDarkMode ? 'dark' : 'default',
			content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
			rel_list: [
			{ title: 'None', value: '' },
			{ title: 'No Follow', value: 'nofollow' },
			{ title: 'Sponsored', value: 'sponsored' }
			]
		});
});
</script>

@endsection