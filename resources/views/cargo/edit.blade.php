@extends('layouts.app')

@section('title', 'Edit Data Cargo')
@section('page-title', 'Edit Data Cargo')
@section('page-subtitle', 'Perbarui data pengiriman cargo')

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-lg-8">
        <div class="card-panel">
            <div class="card-panel-header">
                <h5><i class="bi bi-pencil-square text-warning"></i> Edit Data Cargo</h5>
                <a href="{{ route('cargo.index') }}" class="btn-outline-custom"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
            <div class="card-panel-body">
                @if($errors->any())
                <div class="alert alert-danger" style="border-radius:12px;border:none;border-left:4px solid var(--danger);">
                    <ul class="mb-0" style="font-size:.87rem;">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('cargo.update', $cargo) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Nama Perusahaan</label>
                            <input type="text" name="nama_perusahaan" class="form-control form-control-custom" value="{{ old('nama_perusahaan', $cargo->nama_perusahaan) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">No BL</label>
                            <input type="text" name="no_bl" class="form-control form-control-custom" value="{{ old('no_bl', $cargo->no_bl) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-custom">Party</label>
                            <input type="number" name="party" class="form-control form-control-custom" value="{{ old('party', $cargo->party) }}" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-custom">Marking</label>
                            <input type="text" name="marking" class="form-control form-control-custom" value="{{ old('marking', $cargo->marking) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-custom">Cargo</label>
                            <input type="text" name="cargo" class="form-control form-control-custom" value="{{ old('cargo', $cargo->cargo) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">Lokasi</label>
                            <textarea name="lokasi" rows="3" class="form-control form-control-custom" required>{{ old('lokasi', $cargo->lokasi) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Status</label>
                            <select name="status" class="form-select form-select-custom" required>
                                <option value="proses" {{ old('status', $cargo->status)=='proses'?'selected':'' }}>Proses</option>
                                <option value="complete" {{ old('status', $cargo->status)=='complete'?'selected':'' }}>Complete</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Foto Bukti Barang</label>
                            @if($cargo->foto_url)
                            <div class="mb-2">
                                <img src="{{ $cargo->foto_url }}" alt="Foto" class="rounded-3" style="max-height:120px;border:2px solid var(--border-color);">
                                <p class="text-muted mt-1" style="font-size:.78rem;">Foto saat ini. Upload baru untuk mengganti.</p>
                            </div>
                            @endif
                            <div class="file-upload-area" onclick="document.getElementById('foto').click()">
                                <i class="bi bi-cloud-arrow-up"></i>
                                <p id="fileLabel">Klik untuk upload foto baru (Max 2MB)</p>
                                <input type="file" name="foto" id="foto" class="d-none" accept="image/*" onchange="this.previousElementSibling.textContent=this.files[0].name">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('cargo.index') }}" class="btn-outline-custom"><i class="bi bi-x-lg"></i> Batal</a>
                        <button type="submit" class="btn-success-custom"><i class="bi bi-check-lg"></i> Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
