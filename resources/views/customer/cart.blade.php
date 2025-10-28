@extends('customer.layouts.app')

@section('title', 'Keranjang Belanja - Seka Boga Catering')

@section('content')
<div class="bg-gradient-to-br from-green-50 to-white min-h-screen">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <h1 class="text-3xl md:text-5xl font-bold mb-4">Keranjang Belanja</h1>
                <p class="text-xl mb-6 opacity-90">Review pesanan Anda sebelum melanjutkan ke checkout</p>
                <div class="flex items-center justify-center gap-4 text-sm">
                    <span class="bg-white/20 px-4 py-2 rounded-full">
                        {{ $cartItems->count() }} Item dalam Keranjang
                    </span>
                    <a href="{{ route('customer.home') }}" 
                       class="hover:bg-white/20 px-4 py-2 rounded-full transition-colors duration-300 inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Content -->
    <section class="py-12">
        <div class="container mx-auto px-6">
            @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                    <div class="bg-white rounded-2xl shadow-lg p-6 transition-shadow duration-300 hover:shadow-xl" id="cart-item-{{ $item->id }}">
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Product Image -->
                            <div class="w-full md:w-32 h-32 flex-shrink-0">
                                @if($item->produk->gambarUtama)
                                <img src="{{ Storage::url($item->produk->gambarUtama->path_gambar) }}" 
                                     alt="{{ $item->produk->nama_produk }}" 
                                     class="w-full h-full object-cover rounded-lg">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>

                            <!-- Product Details -->
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $item->produk->nama_produk }}</h3>
                                        <p class="text-sm text-green-600 mb-2">{{ $item->produk->kategori->nama_kategori }}</p>
                                        <p class="text-gray-600 text-sm">{{ Str::limit($item->produk->deskripsi, 100) }}</p>
                                    </div>
                                    <button onclick="removeFromCart('{{ $item->id }}')" 
                                            class="text-red-500 hover:text-red-700 p-2 hover:bg-red-50 rounded-full transition-colors duration-300"
                                            title="Hapus dari keranjang">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Price and Quantity -->
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                                    <div class="text-2xl font-bold text-green-600">
                                        Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                        <span class="text-sm text-gray-500 font-normal">/ {{ $item->produk->satuan }}</span>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                            <button onclick="updateQuantity('{{ $item->id }}', 'decrease')" 
                                                    class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <span id="quantity-{{ $item->id }}" class="px-4 py-2 font-medium">{{ $item->jumlah }}</span>
                                            <button onclick="updateQuantity('{{ $item->id }}', 'increase')" 
                                                    class="px-3 py-2 bg-gray-100 hover:bg-gray-200 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div id="subtotal-{{ $item->id }}" class="text-lg font-semibold text-gray-800">
                                            Rp {{ number_format($item->jumlah * $item->produk->harga, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Special Notes -->
                                @if($item->catatan)
                                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <div>
                                            <span class="text-sm font-medium text-yellow-800">Catatan:</span>
                                            <p class="text-sm text-yellow-700">{{ $item->catatan }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Ringkasan Pesanan</h2>
                        
                        <!-- Items Summary -->
                        <div class="space-y-3 mb-6">
                            @foreach($cartItems as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ Str::limit($item->produk->nama_produk, 30) }} ({{ $item->jumlah }}x)</span>
                                <span class="font-medium">Rp {{ number_format($item->jumlah * $item->produk->harga, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>

                        <hr class="my-4">

                        <!-- Total -->
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-xl font-bold text-gray-800">Total</span>
                            <span id="grand-total" class="text-2xl font-bold text-green-600">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-4">
                            <button onclick="proceedToCheckout()" 
                                    class="w-full bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Lanjut ke Pembayaran
                            </button>
                            
                            <a href="{{ route('customer.home') }}" 
                               class="w-full border-2 border-green-600 text-green-600 px-6 py-3 rounded-lg font-semibold hover:bg-green-600 hover:text-white transition-colors duration-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Lanjut Belanja
                            </a>
                        </div>

                        <!-- Contact Info -->
                        <div class="mt-6 p-4 bg-green-50 rounded-lg">
                            <h3 class="font-semibold text-green-800 mb-2">Butuh Bantuan?</h3>
                            <div class="space-y-2 text-sm text-green-700">
                                <a href="https://wa.me/6281234567890" class="flex items-center gap-2 hover:text-green-900">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                    </svg>
                                    WhatsApp: 081234567890
                                </a>
                                <a href="tel:+6281234567890" class="flex items-center gap-2 hover:text-green-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    Telepon
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="w-32 h-32 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-gray-600 mb-4">Keranjang Belanja Kosong</h3>
                <p class="text-gray-500 mb-8">Belum ada produk dalam keranjang belanja Anda</p>
                <a href="{{ route('customer.home') }}" 
                   class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-300 inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Mulai Belanja
                </a>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
// Update quantity function
async function updateQuantity(cartId, action) {
    const quantityElement = document.getElementById(`quantity-${cartId}`);
    const subtotalElement = document.getElementById(`subtotal-${cartId}`);
    let currentQuantity = parseInt(quantityElement.textContent);
    
    let newQuantity = action === 'increase' ? currentQuantity + 1 : currentQuantity - 1;
    
    if (newQuantity < 1) {
        if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
            removeFromCart(cartId);
        }
        return;
    }
    
    try {
        const response = await fetch('{{ route("customer.cart.update") }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                cart_id: cartId,
                quantity: newQuantity
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            quantityElement.textContent = newQuantity;
            subtotalElement.textContent = 'Rp ' + data.itemTotal;
            document.getElementById('grand-total').textContent = 'Rp ' + data.cartTotal;
            
            // Update cart counter in layout
            updateCartCounter(data.cartCount);
            
            // Show success message
            showNotification('Keranjang berhasil diperbarui', 'success');
        } else {
            showNotification(data.error || 'Gagal memperbarui keranjang', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat memperbarui keranjang', 'error');
    }
}

// Remove from cart function
async function removeFromCart(cartId) {
    if (!confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
        return;
    }
    
    try {
        const response = await fetch('{{ route("customer.cart.remove") }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                cart_id: cartId
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Remove item from DOM
            const cartItem = document.getElementById(`cart-item-${cartId}`);
            cartItem.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => {
                cartItem.remove();
                
                // Update totals
                document.getElementById('grand-total').textContent = 'Rp ' + data.cartTotal;
                
                // Update cart counter in layout
                updateCartCounter(data.cartCount);
                
                // If cart is empty, reload page to show empty state
                if (data.cartCount === 0) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                }
            }, 300);
            
            showNotification('Item berhasil dihapus dari keranjang', 'success');
        } else {
            showNotification(data.error || 'Gagal menghapus item dari keranjang', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat menghapus item', 'error');
    }
}

// Proceed to checkout function
function proceedToCheckout() {
    // For now, show alert. Later can redirect to checkout page
    alert('Fitur checkout akan segera tersedia. Silakan hubungi kami melalui WhatsApp untuk melanjutkan pesanan.');
}

// Update cart counter in layout
function updateCartCounter(count) {
    const cartCounters = document.querySelectorAll('.cart-counter');
    cartCounters.forEach(counter => {
        counter.textContent = count;
        if (count === 0) {
            counter.style.display = 'none';
        } else {
            counter.style.display = 'flex';
        }
    });
}

// Show notification function
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 transform translate-x-full`;
    
    if (type === 'success') {
        notification.classList.add('bg-green-500');
    } else if (type === 'error') {
        notification.classList.add('bg-red-500');
    } else {
        notification.classList.add('bg-blue-500');
    }
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Add fade out animation CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from { opacity: 1; transform: scale(1); }
        to { opacity: 0; transform: scale(0.95); }
    }
`;
document.head.appendChild(style);
</script>
@endpush