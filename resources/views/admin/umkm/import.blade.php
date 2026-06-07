@extends('layouts.app')

@section('content')

<style>
	.page-title {
		font-weight: 700;
		font-size: 20px;
		color: var(--color-black);
	}

	.btn-selanjutnya {
		background-color: var(--color-green-800);
		color: white;
		border: none;
		border-radius: 6px;
		padding: 8px 14px;
		font-size: 16px;
		font-weight: 500;
		transition: all 0.2s;
	}

	.btn-selanjutnya:hover {
		color: white;
		background-color: var(--color-green);
	}
</style>

<div class="container-fluid mb-5 p-3 p-md-4">
	<div class="card">
		<div class="card-header">
			<h3 class="page-title">Import Data UMKM dari Spreadsheet</h3>
		</div>
		<div class="card-body">
			@if(session('success'))
			<div class="alert alert-success">{{ session('success') }}</div>
			@endif

			<form action="{{ route('umkm.import.process') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="mb-3">
					<label for="file_csv" class="form-label">Pilih File CSV</label>
					<input class="form-control" type="file" id="file_csv" name="file_csv" required accept=".csv">
					<small class="text-muted">Pastikan file yang diunduh dari Google Spreadsheet berformat <b>.csv (Comma Separated Values)</b>.</small>
				</div>
				<button type="submit" class="btn btn-selanjutnya">Import Data</button>
			</form>
		</div>
	</div>
</div>
@endsection