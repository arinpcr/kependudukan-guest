@extends('layouts.guest.app')

@section('title', 'Edit Data Warga - Sistem Kependudukan')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 800px;">
            <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Edit Data</h4>
            <h1 class="mb-5 display-4">Formulir Edit Warga</h1>
        </div>

        <div class="row justify-content-center wow fadeIn" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <div class="bg-light border border-primary rounded p-5">
                    
                    <a href="{{ route('warga.index') }}" class="btn btn-secondary btn-sm mb-4">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Warga
                    </a>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('warga.update', $warga) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('no_ktp') is-invalid @enderror" 
                                           name="no_ktp" id="no_ktp" value="{{ old('no_ktp', $warga->no_ktp) }}" 
                                           placeholder="Nomor KTP" required>
                                    <label for="no_ktp">
                                        <i class="fas fa-id-card me-2 text-primary"></i>Nomor KTP
                                    </label>
                                    @error('no_ktp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           name="nama" id="nama" value="{{ old('nama', $warga->nama) }}" 
                                           placeholder="Nama Lengkap" required>
                                    <label for="nama">
                                        <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap
                                    </label>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                            name="jenis_kelamin" id="jenis_kelamin" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <label for="jenis_kelamin">
                                        <i class="fas fa-venus-mars me-2 text-primary"></i>Jenis Kelamin
                                    </label>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('agama') is-invalid @enderror" 
                                           name="agama" id="agama" value="{{ old('agama', $warga->agama) }}" 
                                           placeholder="Agama">
                                    <label for="agama">
                                        <i class="fas fa-pray me-2 text-primary"></i>Agama
                                    </label>
                                    @error('agama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" 
                                           name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', $warga->pekerjaan) }}" 
                                           placeholder="Pekerjaan">
                                    <label for="pekerjaan">
                                        <i class="fas fa-briefcase me-2 text-primary"></i>Pekerjaan
                                    </label>
                                    @error('pekerjaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('telp') is-invalid @enderror" 
                                           name="telp" id="telp" value="{{ old('telp', $warga->telp) }}" 
                                           placeholder="Nomor Telepon">
                                    <label for="telp">
                                        <i class="fas fa-phone me-2 text-primary"></i>Nomor Telepon
                                    </label>
                                    @error('telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" id="email" value="{{ old('email', $warga->email) }}" 
                                           placeholder="Alamat Email">
                                    <label for="email">
                                        <i class="fas fa-envelope me-2 text-primary"></i>Alamat Email
                                    </label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dokumen KK Section -->
                            <div class="col-12">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-file-upload me-2"></i>Upload Dokumen Kartu Keluarga (KK)
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Current Documents -->
                                        @if($warga->documents->count() > 0)
                                        <div class="mb-3">
                                            <h6 class="text-info">
                                                <i class="fas fa-files me-2"></i>Dokumen Saat Ini:
                                            </h6>
                                            <div class="list-group">
                                                @foreach($warga->documents as $document)
                                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="{{ $document->file_icon }} me-2"></i>
                                                        {{ $document->original_name }}
                                                        <small class="text-muted ms-2">
                                                            ({{ number_format($document->file_size / 1024, 2) }} KB)
                                                        </small>
                                                    </div>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ $document->file_url }}" 
                                                           target="_blank" 
                                                           class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ $document->file_url }}" 
                                                           download="{{ $document->original_name }}"
                                                           class="btn btn-outline-success btn-sm">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif

                                        <!-- File Upload -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-plus me-2 text-success"></i>Tambah Dokumen Baru
                                            </label>
                                            <input type="file" 
                                                   class="form-control @error('documents.*') is-invalid @enderror" 
                                                   name="documents[]" 
                                                   id="documents" 
                                                   multiple
                                                   accept=".jpg,.jpeg,.png,.pdf">
                                            <small class="form-text text-muted">
                                                Format: JPG, JPEG, PNG, PDF. Maksimal 5MB per file. Dapat memilih multiple file.
                                            </small>
                                            @error('documents.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- File Preview -->
                                        <div id="filePreview" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('warga.index') }}" class="btn btn-secondary me-md-2 px-4">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save me-2"></i>Update Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format KTP number input (16 digit)
        const ktpInput = document.getElementById('no_ktp');
        if (ktpInput) {
            ktpInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            
            ktpInput.addEventListener('blur', function() {
                if (this.value.length !== 16 && this.value.length > 0) {
                    showToast('Nomor KTP harus terdiri dari 16 digit');
                    this.focus();
                }
            });
        }

        // Format phone number input
        const telpInput = document.getElementById('telp');
        if (telpInput) {
            telpInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9+]/g, '');
            });
        }

        // Auto-capitalize name
        const nameInput = document.getElementById('nama');
        if (nameInput) {
            nameInput.addEventListener('blur', function() {
                this.value = this.value.toUpperCase();
            });
        }

        // Auto-capitalize agama and pekerjaan
        const agamaInput = document.getElementById('agama');
        if (agamaInput) {
            agamaInput.addEventListener('blur', function() {
                this.value = this.value.toUpperCase();
            });
        }

        const pekerjaanInput = document.getElementById('pekerjaan');
        if (pekerjaanInput) {
            pekerjaanInput.addEventListener('blur', function() {
                this.value = this.value.toUpperCase();
            });
        }

        // File preview for documents
        const documentsInput = document.getElementById('documents');
        const filePreview = document.getElementById('filePreview');

        if (documentsInput && filePreview) {
            documentsInput.addEventListener('change', function(e) {
                filePreview.innerHTML = '';
                
                if (this.files.length > 0) {
                    const fileList = document.createElement('div');
                    fileList.className = 'list-group';
                    
                    Array.from(this.files).forEach((file, index) => {
                        const fileItem = document.createElement('div');
                        fileItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                        
                        const fileInfo = document.createElement('div');
                        fileInfo.innerHTML = `
                            <i class="fas fa-file me-2 text-primary"></i>
                            ${file.name}
                            <small class="text-muted ms-2">(${(file.size / 1024).toFixed(2)} KB)</small>
                        `;
                        
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'btn btn-outline-danger btn-sm';
                        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                        removeBtn.onclick = function() {
                            // Create new DataTransfer to remove file
                            const dt = new DataTransfer();
                            Array.from(documentsInput.files).forEach((f, i) => {
                                if (i !== index) dt.items.add(f);
                            });
                            documentsInput.files = dt.files;
                            fileItem.remove();
                            
                            if (documentsInput.files.length === 0) {
                                filePreview.innerHTML = '';
                            }
                        };
                        
                        fileItem.appendChild(fileInfo);
                        fileItem.appendChild(removeBtn);
                        fileList.appendChild(fileItem);
                    });
                    
                    filePreview.appendChild(fileList);
                }
            });
        }

        // Form submission loading state
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupdate...';
                }
            });
        }
    });

    function showToast(message) {
        const toast = new bootstrap.Toast(document.getElementById('errorToast'));
        document.getElementById('toastMessage').textContent = message;
        toast.show();
    }
</script>

<!-- Toast for error messages -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span id="toastMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endpush