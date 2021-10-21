@php
\Assets::addStyles([
'summernote',
'adminlte'
]);

\Assets::addScripts([
'summernote',
'stand-alone-button',
'adminlte'
]);
@endphp

@extends('layouts.admin')

@section('main')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
					<li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Bài viết</a></li>
					<li class="breadcrumb-item active">Thêm bài viết</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<form id="create-form" action="{{ route('admin.blog.store') }}" method="POST">
					@csrf

					<div class="row">
						<div class="col-lg-8">
							<div class="card">
								<div class="card-body">
									<div class="form-group">
										<label class="required" for="name">Tên</label>
										<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nhập tên">

										@error('name')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
									<div class="form-group">
										<label for="slug">Đường dẫn (Để trống sẽ tự động tạo)</label>
										<input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" id="slug" placeholder="Nhập dường dẫn">

										@error('slug')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
									<div class="form-group">
										<label for="description">Mô tả</label>
										<textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" placeholder="Nhập mô tả"></textarea>

										@error('description')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="body">Nội dung</label>
										<textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" rows="30" placeholder="Nhập nội dung"></textarea>

										@error('body')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="card">
								<div class="card-header">
									<h5>Xuất bản</h5>
								</div>

								<div class="card-body">
									@can('admin.blog.store')
									<button type="submit" class="btn btn-success">
										<i class="fal fa-check-circle"></i> Lưu
									</button>
									@endcan
									<a href="{{ route('admin.blog.index') }}" class="btn btn-default">
										<i class="fal fa-save"></i> Quay lại
									</a>
								</div>
							</div>

							<div class="card">
								<div class="card-header">
									<h5>Trạng thái</h5>
								</div>

								<div class="card-body">
									<select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
										<option value="1" selected>Kích hoạt</option>
										<option value="0">Bản nháp</option>
									</select>

									@error('status')
									<span class="invalid-feedback" role="alert">{{ $message }}</span>
									@enderror
								</div>
							</div>

							<div class="card">
								<div class="card-header">
									<h5>Hình ảnh</h5>
								</div>

								<div class="card-body">
									<div class="input-group">
										<span class="input-group-btn">
											<a id="lfm" data-input="image" data-preview="holder" data-type="blog" class="btn btn-primary text-white">
												<i class="fal fa-camera"></i> Chọn ảnh
											</a>
											<button type="button" id="remove_img" class="btn btn-danger text-white">
												<i class="fal fa-trash-alt"></i> Xoá
											</button>
										</span>
										<input class="form-control @error('image') is-invalid @enderror" type="hidden" name="image" id="image" value="{{ old('image') }}">

										@error('image')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
									<div id="holder" style="margin-top:15px"></div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@stop

@section('script')
<script>
	$(function() {
		// Summernote
		$('#body').summernote({
			height: 300, //set editable area's height
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'underline', 'clear']],
				['fontname', ['fontname']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['table', ['table']],
				['insert', ['link', 'lfm']],
				['view', ['fullscreen', 'codeview', 'help']],
			],
			buttons: {
				lfm: LFMButton
			}
		});

		$('#lfm').filemanager('blog');
	});
</script>
@stop