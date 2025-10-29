@extends('admin.layout.app')

@section('title', 'Detail Pesanan')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan #{{ $pesanan->kode_pesanan }}</h1>
        <a href="{{ route('admin.pesanan.index') }}" class="btn-secondary">
            ← Kembali
        </a>
    </div>
@endsection

@section('content')
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Informasi Pesanan -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pesanan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Kode Pesanan:</strong></td>
                                    <td>{{ $pesanan->kode_pesanan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Pesanan:</strong></td>
                                    <td>{{ $pesanan->tanggal_pesanan->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Dibutuhkan:</strong></td>
                                    <td>{{ $pesanan->tanggal_dibutuhkan ? \Carbon\Carbon::parse($pesanan->tanggal_dibutuhkan)->format('d M Y H:i') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'menunggu_pembayaran' => 'warning',
                                                'menunggu_konfirmasi_pembayaran' => 'info',
                                                'pembayaran_dikonfirmasi' => 'success',
                                                'diproses' => 'primary',
                                                'dikirim' => 'secondary',
                                                'selesai' => 'success',
                                                'dibatalkan' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $statusClass[$pesanan->status_pesanan] ?? 'secondary' }}">
                                            {{ ucwords(str_replace('_', ' ', $pesanan->status_pesanan)) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Customer:</strong></td>
                                    <td>{{ $pesanan->customer->nama_lengkap ?? $pesanan->customer->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $pesanan->customer->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>No. Telepon:</strong></td>
                                    <td>{{ $pesanan->nomor_telepon_penerima }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat:</strong></td>
                                    <td>
                                        {{ $pesanan->alamat_pengiriman }}<br>
                                        {{ $pesanan->kota_pengiriman }}, {{ $pesanan->provinsi_pengiriman }} {{ $pesanan->kode_pos_pengiriman }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($pesanan->catatan_pesanan)
                        <div class="mt-3">
                            <strong>Catatan Pesanan:</strong>
                            <p class="text-muted">{{ $pesanan->catatan_pesanan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detail Item Pesanan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Item</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pesanan->detailPesanan as $detail)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($detail->produk->gambarUtama)
                                                <img src="{{ Storage::url($detail->produk->gambarUtama->file_path) }}" 
                                                     alt="{{ $detail->nama_produk }}"
                                                     class="img-thumbnail me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <strong>{{ $detail->nama_produk }}</strong>
                                                @if($detail->catatan_produk)
                                                    <br><small class="text-muted">{{ $detail->catatan_produk }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td><strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong></td>
                                </tr>
                                @endforeach
                                <tr class="table-info">
                                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                    <td><strong>Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Aksi -->
        <div class="col-lg-4">
            <!-- Update Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pesanan.update-status', $pesanan->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="form-group">
                            <label for="status_pesanan">Status Pesanan</label>
                            <select name="status_pesanan" id="status_pesanan" class="form-control" required>
                                <option value="menunggu_pembayaran" {{ $pesanan->status_pesanan == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                <option value="menunggu_konfirmasi_pembayaran" {{ $pesanan->status_pesanan == 'menunggu_konfirmasi_pembayaran' ? 'selected' : '' }}>Menunggu Konfirmasi Pembayaran</option>
                                <option value="pembayaran_dikonfirmasi" {{ $pesanan->status_pesanan == 'pembayaran_dikonfirmasi' ? 'selected' : '' }}>Pembayaran Dikonfirmasi</option>
                                <option value="diproses" {{ $pesanan->status_pesanan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="dikirim" {{ $pesanan->status_pesanan == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="selesai" {{ $pesanan->status_pesanan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $pesanan->status_pesanan == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Konfirmasi Pembayaran -->
            @if($pesanan->pembayaran)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Bukti Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge badge-{{ $pesanan->pembayaran->status_pembayaran == 'dikonfirmasi' ? 'success' : ($pesanan->pembayaran->status_pembayaran == 'ditolak' ? 'danger' : 'warning') }}">
                            {{ ucwords(str_replace('_', ' ', $pesanan->pembayaran->status_pembayaran)) }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Rekening Tujuan:</strong><br>
                        {{ $pesanan->pembayaran->rekeningAdmin->nama_bank }}<br>
                        {{ $pesanan->pembayaran->rekeningAdmin->nomor_rekening }}<br>
                        a.n. {{ $pesanan->pembayaran->rekeningAdmin->nama_pemilik }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Jumlah:</strong><br>
                        Rp {{ number_format($pesanan->pembayaran->jumlah_pembayaran, 0, ',', '.') }}
                    </div>
                    
                    @if($pesanan->pembayaran->bukti_pembayaran)
                        <div class="mb-3">
                            <strong>Bukti Transfer:</strong><br>
                            <img src="{{ Storage::url($pesanan->pembayaran->bukti_pembayaran) }}" 
                                 alt="Bukti Pembayaran" 
                                 class="img-fluid border rounded cursor-pointer" 
                                 onclick="window.open(this.src, '_blank')"
                                 style="max-height: 200px;">
                        </div>
                    @endif
                    

                    
                    @if($pesanan->pembayaran->status_pembayaran == 'menunggu_konfirmasi')
                        <form action="{{ route('admin.pesanan.confirm-payment', $pesanan->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="form-group">
                                <label for="status">Konfirmasi Pembayaran</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Pilih Status</option>
                                    <option value="dikonfirmasi">Konfirmasi (Terima)</option>
                                    <option value="ditolak">Tolak</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-block">Konfirmasi Pembayaran</button>
                        </form>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection