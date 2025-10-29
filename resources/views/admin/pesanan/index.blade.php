@extends('admin.layout.app')

@section('title', 'Kelola Pesanan')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Kelola Pesanan</h1>
    </div>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow rounded-lg mb-6">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex justify-between items-center">
            <h6 class="text-lg font-medium text-gray-900">Filter Pesanan</h6>
            <form method="GET" action="{{ route('admin.pesanan.index') }}">
                <select name="status" class="input-field w-auto" onchange="this.form.submit()">
                    @foreach($statusList as $key => $label)
                        <option value="{{ $key }}" {{ $status == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
</div>

    <!-- Tabel Pesanan -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            @if($pesanan->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pesanan as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->kode_pesanan }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->customer->nama_lengkap ?? $order->customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->customer->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order->tanggal_pesanan->format('d M Y H:i') }}</div>
                                    @if($order->tanggal_dibutuhkan)
                                        <div class="text-sm text-gray-500">Dibutuhkan: {{ \Carbon\Carbon::parse($order->tanggal_dibutuhkan)->format('d M Y H:i') }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">Rp {{ number_format($order->total_keseluruhan, 0, ',', '.') }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->detailPesanan->count() }} item</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$order->status_pesanan] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucwords(str_replace('_', ' ', $order->status_pesanan)) }}
                                    </span>
                                    @if($order->pembayaran && $order->pembayaran->status_pembayaran == 'menunggu_konfirmasi')
                                        <div class="text-xs text-blue-600 mt-1">Ada bukti pembayaran</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.pesanan.show', $order->id) }}" 
                                       class="text-green-600 hover:text-green-900">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($pesanan->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $pesanan->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <div class="text-gray-400 text-sm">Tidak ada pesanan</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection