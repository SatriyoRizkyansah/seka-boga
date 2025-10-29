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
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informasi Pesanan - 2/3 width -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Informasi Pesanan -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Pesanan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kode Pesanan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->kode_pesanan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Pesanan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->tanggal_pesanan->format('d M Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Dibutuhkan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->tanggal_dibutuhkan ? \Carbon\Carbon::parse($pesanan->tanggal_dibutuhkan)->format('d M Y H:i') : '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @php
                                    $statusClasses = [
                                        'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                        'menunggu_konfirmasi_pembayaran' => 'bg-blue-100 text-blue-800',
                                        'pembayaran_dikonfirmasi' => 'bg-green-100 text-green-800',
                                        'diproses' => 'bg-blue-100 text-blue-800',
                                        'dikirim' => 'bg-purple-100 text-purple-800',
                                        'selesai' => 'bg-green-100 text-green-800',
                                        'dibatalkan' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$pesanan->status_pesanan] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucwords(str_replace('_', ' ', $pesanan->status_pesanan)) }}
                                </span>
                            </dd>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Customer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->customer->nama_lengkap ?? $pesanan->customer->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->customer->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->nomor_telepon_penerima }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $pesanan->alamat_pengiriman }}<br>
                                {{ $pesanan->kota_pengiriman }}, {{ $pesanan->provinsi_pengiriman }} {{ $pesanan->kode_pos_pengiriman }}
                            </dd>
                        </div>
                    </div>
                </div>
                
                @if($pesanan->catatan_pesanan)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <dt class="text-sm font-medium text-gray-500">Catatan Pesanan</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pesanan->catatan_pesanan }}</dd>
                    </div>
                @endif
            </div>
        </div>

        <!-- Detail Item Pesanan -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Detail Item</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pesanan->detailPesanan as $detail)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($detail->produk->gambarUtama)
                                            <img src="{{ Storage::url($detail->produk->gambarUtama->file_path) }}" 
                                                 alt="{{ $detail->nama_produk }}"
                                                 class="h-12 w-12 rounded-lg object-cover mr-4">
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $detail->nama_produk }}</div>
                                            @if($detail->catatan_produk)
                                                <div class="text-sm text-gray-500">{{ $detail->catatan_produk }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $detail->jumlah }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-900">Total:</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">
                                    Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel Aksi - 1/3 width -->
    <div class="space-y-6">
        <!-- Update Status Manual (untuk kasus khusus) -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Update Status Manual</h3>
                
                <form action="{{ route('admin.pesanan.update-status', $pesanan->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label for="status_pesanan" class="block text-sm font-medium text-gray-700 mb-2">Status Pesanan</label>
                        <select name="status_pesanan" id="status_pesanan" class="input-field" required>
                            <option value="menunggu_pembayaran_produk" {{ $pesanan->status_pesanan == 'menunggu_pembayaran_produk' ? 'selected' : '' }}>Menunggu Pembayaran Produk</option>
                            <option value="menunggu_konfirmasi_pembayaran_produk" {{ $pesanan->status_pesanan == 'menunggu_konfirmasi_pembayaran_produk' ? 'selected' : '' }}>Menunggu Konfirmasi Pembayaran Produk</option>
                            <option value="pembayaran_produk_dikonfirmasi" {{ $pesanan->status_pesanan == 'pembayaran_produk_dikonfirmasi' ? 'selected' : '' }}>Pembayaran Produk Dikonfirmasi</option>
                            <option value="menunggu_input_ongkir" {{ $pesanan->status_pesanan == 'menunggu_input_ongkir' ? 'selected' : '' }}>Menunggu Input Ongkir</option>
                            <option value="menunggu_pembayaran_ongkir" {{ $pesanan->status_pesanan == 'menunggu_pembayaran_ongkir' ? 'selected' : '' }}>Menunggu Pembayaran Ongkir</option>
                            <option value="menunggu_konfirmasi_pembayaran_ongkir" {{ $pesanan->status_pesanan == 'menunggu_konfirmasi_pembayaran_ongkir' ? 'selected' : '' }}>Menunggu Konfirmasi Pembayaran Ongkir</option>
                            <option value="pembayaran_ongkir_dikonfirmasi" {{ $pesanan->status_pesanan == 'pembayaran_ongkir_dikonfirmasi' ? 'selected' : '' }}>Pembayaran Ongkir Dikonfirmasi</option>
                            <option value="diproses" {{ $pesanan->status_pesanan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="menunggu_input_resi" {{ $pesanan->status_pesanan == 'menunggu_input_resi' ? 'selected' : '' }}>Menunggu Input Resi</option>
                            <option value="dikirim" {{ $pesanan->status_pesanan == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ $pesanan->status_pesanan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $pesanan->status_pesanan == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn-primary w-full">Update Status</button>
                </form>
            </div>
        </div>

        <!-- Input Biaya Ongkir -->
        @if($pesanan->status_pesanan == 'pembayaran_produk_dikonfirmasi' || $pesanan->status_pesanan == 'menunggu_input_ongkir')
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-orange-600 mb-4">Input Biaya Ongkir</h3>
                
                <form action="{{ route('admin.pesanan.input-shipping-cost', $pesanan->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label for="biaya_ongkir" class="block text-sm font-medium text-gray-700 mb-2">Biaya Ongkir</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" name="biaya_ongkir" id="biaya_ongkir" class="input-field pl-10" min="0" step="1000" placeholder="0" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-primary w-full">Set Biaya Ongkir</button>
                </form>
            </div>
        </div>
        @endif

        <!-- Input Nomor Resi -->
        @if($pesanan->status_pesanan == 'pembayaran_ongkir_dikonfirmasi' || $pesanan->status_pesanan == 'diproses' || $pesanan->status_pesanan == 'menunggu_input_resi')
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-blue-600 mb-4">Input Nomor Resi</h3>
                
                <form action="{{ route('admin.pesanan.input-tracking', $pesanan->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label for="nama_jasa_pengiriman" class="block text-sm font-medium text-gray-700 mb-2">Nama Jasa Pengiriman</label>
                        <input type="text" name="nama_jasa_pengiriman" id="nama_jasa_pengiriman" class="input-field" value="{{ $pesanan->nama_jasa_pengiriman }}" placeholder="contoh: JNE, JNT, SiCepat" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="nomor_resi" class="block text-sm font-medium text-gray-700 mb-2">Nomor Resi</label>
                        <input type="text" name="nomor_resi" id="nomor_resi" class="input-field" value="{{ $pesanan->nomor_resi }}" placeholder="Masukkan nomor resi" required>
                    </div>
                    
                    <button type="submit" class="btn-primary w-full">{{ $pesanan->nomor_resi ? 'Update' : 'Input' }} Resi</button>
                </form>
            </div>
        </div>
        @endif

        <!-- Pembayaran Produk -->
        @php $pembayaranProduk = $pesanan->getPembayaranProduk(); @endphp
        @if($pembayaranProduk)
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-green-600 mb-4">Pembayaran Produk</h3>
                
                <div class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $pembayaranProduk->status_pembayaran == 'dikonfirmasi' ? 'bg-green-100 text-green-800' : ($pembayaranProduk->status_pembayaran == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucwords(str_replace('_', ' ', $pembayaranProduk->status_pembayaran)) }}
                            </span>
                        </dd>
                    </div>
                    
                    @if($pembayaranProduk->rekeningAdmin)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Rekening Tujuan</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $pembayaranProduk->rekeningAdmin->nama_bank }}<br>
                            {{ $pembayaranProduk->rekeningAdmin->nomor_rekening }}<br>
                            a.n. {{ $pembayaranProduk->rekeningAdmin->nama_pemilik }}
                        </dd>
                    </div>
                    @endif
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jumlah</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-900">
                            Rp {{ number_format($pembayaranProduk->jumlah_pembayaran, 0, ',', '.') }}
                        </dd>
                    </div>
                    
                    @if($pembayaranProduk->bukti_pembayaran)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-2">Bukti Transfer</dt>
                            <dd>
                                <img src="{{ Storage::url($pembayaranProduk->bukti_pembayaran) }}" 
                                     alt="Bukti Pembayaran Produk" 
                                     class="w-full max-w-xs border rounded-lg cursor-pointer hover:opacity-75 transition-opacity" 
                                     onclick="window.open(this.src, '_blank')">
                            </dd>
                        </div>
                    @endif
                    
                    @if($pembayaranProduk->status_pembayaran == 'menunggu_konfirmasi')
                        <form action="{{ route('admin.pesanan.confirm-payment', $pesanan->id) }}" method="POST" class="mt-6">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="jenis_pembayaran" value="produk">
                            
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Pembayaran Produk</label>
                                <select name="status" id="status" class="input-field" required>
                                    <option value="">Pilih Status</option>
                                    <option value="dikonfirmasi">Konfirmasi (Terima)</option>
                                    <option value="ditolak">Tolak</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn-primary w-full">Konfirmasi Pembayaran Produk</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Pembayaran Ongkir -->
        @php $pembayaranOngkir = $pesanan->getPembayaranOngkir(); @endphp
        @if($pembayaranOngkir)
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-purple-600 mb-4">Pembayaran Ongkir</h3>
                
                <div class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $pembayaranOngkir->status_pembayaran == 'dikonfirmasi' ? 'bg-green-100 text-green-800' : ($pembayaranOngkir->status_pembayaran == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucwords(str_replace('_', ' ', $pembayaranOngkir->status_pembayaran)) }}
                            </span>
                        </dd>
                    </div>
                    
                    @if($pembayaranOngkir->rekeningAdmin)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Rekening Tujuan</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $pembayaranOngkir->rekeningAdmin->nama_bank }}<br>
                            {{ $pembayaranOngkir->rekeningAdmin->nomor_rekening }}<br>
                            a.n. {{ $pembayaranOngkir->rekeningAdmin->nama_pemilik }}
                        </dd>
                    </div>
                    @endif
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jumlah</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-900">
                            Rp {{ number_format($pembayaranOngkir->jumlah_pembayaran, 0, ',', '.') }}
                        </dd>
                    </div>
                    
                    @if($pembayaranOngkir->bukti_pembayaran)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-2">Bukti Transfer</dt>
                            <dd>
                                <img src="{{ Storage::url($pembayaranOngkir->bukti_pembayaran) }}" 
                                     alt="Bukti Pembayaran Ongkir" 
                                     class="w-full max-w-xs border rounded-lg cursor-pointer hover:opacity-75 transition-opacity" 
                                     onclick="window.open(this.src, '_blank')">
                            </dd>
                        </div>
                    @endif
                    
                    @if($pembayaranOngkir->status_pembayaran == 'menunggu_konfirmasi')
                        <form action="{{ route('admin.pesanan.confirm-payment', $pesanan->id) }}" method="POST" class="mt-6">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="jenis_pembayaran" value="ongkir">
                            
                            <div class="mb-4">
                                <label for="status_ongkir" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Pembayaran Ongkir</label>
                                <select name="status" id="status_ongkir" class="input-field" required>
                                    <option value="">Pilih Status</option>
                                    <option value="dikonfirmasi">Konfirmasi (Terima)</option>
                                    <option value="ditolak">Tolak</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn-primary w-full">Konfirmasi Pembayaran Ongkir</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection