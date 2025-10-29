<!DOCTYPE html>
<html>
<head>
    <title>Checkout Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Checkout Test</h1>
        
        @if(Auth::check())
            <div class="bg-green-100 p-4 rounded mb-4">
                <p>✅ User logged in: {{ Auth::user()->name }}</p>
                <p>📧 Email: {{ Auth::user()->email }}</p>
            </div>
            
            @if($cartItems->count() > 0)
                <div class="bg-blue-100 p-4 rounded mb-4">
                    <p>🛒 Cart items: {{ $cartItems->count() }}</p>
                    @foreach($cartItems as $item)
                        <p>- {{ $item->produk->nama_produk }} ({{ $item->jumlah }}x)</p>
                    @endforeach
                </div>
                
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl mb-4">💰 Total: Rp {{ number_format($total, 0, ',', '.') }}</h2>
                    
                    <form action="{{ route('customer.checkout.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block mb-2">Nama Penerima:</label>
                                <input type="text" name="nama_penerima" value="{{ $user->nama_lengkap }}" class="w-full p-2 border rounded" required>
                            </div>
                            <div>
                                <label class="block mb-2">Nomor Telepon:</label>
                                <input type="text" name="nomor_telepon_penerima" value="{{ $user->nomor_telepon }}" class="w-full p-2 border rounded" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block mb-2">Alamat Pengiriman:</label>
                            <textarea name="alamat_pengiriman" class="w-full p-2 border rounded" required>{{ $user->alamat_lengkap }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block mb-2">Kota:</label>
                                <input type="text" name="kota_pengiriman" value="{{ $user->kota }}" class="w-full p-2 border rounded" required>
                            </div>
                            <div>
                                <label class="block mb-2">Provinsi:</label>
                                <input type="text" name="provinsi_pengiriman" value="{{ $user->provinsi }}" class="w-full p-2 border rounded" required>
                            </div>
                            <div>
                                <label class="block mb-2">Kode Pos:</label>
                                <input type="text" name="kode_pos_pengiriman" value="{{ $user->kode_pos }}" class="w-full p-2 border rounded" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block mb-2">Tanggal Acara:</label>
                                <input type="date" name="tanggal_acara" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full p-2 border rounded" required>
                            </div>
                            <div>
                                <label class="block mb-2">Waktu Acara:</label>
                                <input type="time" name="waktu_acara" class="w-full p-2 border rounded" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block mb-2">Catatan (Opsional):</label>
                            <textarea name="catatan_pesanan" class="w-full p-2 border rounded" placeholder="Catatan untuk pesanan..."></textarea>
                        </div>
                        
                        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">
                            🛍️ Buat Pesanan
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-red-100 p-4 rounded">
                    <p>❌ Keranjang kosong</p>
                </div>
            @endif
        @else
            <div class="bg-red-100 p-4 rounded">
                <p>❌ User not logged in</p>
                <a href="{{ route('login') }}" class="text-blue-600">Login here</a>
            </div>
        @endif
    </div>
</body>
</html>