@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Import Data UMKM dari Spreadsheet</h4>
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
                <button type="submit" class="btn btn-primary">Import Data</button>
            </form>
        </div>
    </div>
</div>
@endsection