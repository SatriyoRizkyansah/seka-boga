<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display the homepage with featured products and categories
     */
    public function index()
    {
        $categories = Kategori::where('aktif', true)
            ->withCount(['produk' => function ($query) {
                $query->where('aktif', true)->where('tersedia', true);
            }])
            ->orderBy('nama_kategori')
            ->get();

        $featuredProducts = Produk::with(['kategori', 'gambarUtama'])
            ->where('aktif', true)
            ->where('tersedia', true)
            ->where('stok', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $cartCount = 0;
        if (Auth::check()) {
            $cartCount = Keranjang::where('customer_id', Auth::id())->sum('jumlah');
        }

        return view('customer.index', compact('categories', 'featuredProducts', 'cartCount'));
    }

    /**
     * Display products by category
     */
    public function category($categoryId)
    {
        $category = Kategori::where('aktif', true)->findOrFail($categoryId);
        
        $products = Produk::with(['kategori', 'gambarUtama'])
            ->where('kategori_produk_id', $categoryId)
            ->where('aktif', true)
            ->where('tersedia', true)
            ->where('stok', '>', 0)
            ->paginate(12);

        $cartCount = 0;
        if (Auth::check()) {
            $cartCount = Keranjang::where('customer_id', Auth::id())->sum('jumlah');
        }

        return view('customer.category', compact('category', 'products', 'cartCount'));
    }

    /**
     * Display product details
     */
    public function product($productId)
    {
                $product = Produk::with(['kategori', 'gambarProduk', 'gambarUtama'])
            ->where('aktif', true)
            ->where('tersedia', true)
            ->findOrFail($productId);

        $relatedProducts = Produk::with(['kategori', 'gambarUtama'])
            ->where('kategori_produk_id', $product->kategori_produk_id)
            ->where('id', '!=', $productId)
            ->where('aktif', true)
            ->where('tersedia', true)
            ->take(4)
            ->get();

        $cartCount = 0;
        if (Auth::check()) {
            $cartCount = Keranjang::where('customer_id', Auth::id())->sum('jumlah');
        }

        return view('customer.product', compact('product', 'relatedProducts', 'cartCount'));
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Silakan login terlebih dahulu');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Produk::findOrFail($productId);
        
        if ($request->quantity > $product->stok) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $cartItem = Keranjang::where('customer_id', Auth::id())
            ->where('produk_id', $productId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->jumlah + $request->quantity;
            if ($newQuantity > $product->stok) {
                return back()->with('error', 'Total quantity melebihi stok');
            }
            $cartItem->update(['jumlah' => $newQuantity]);
        } else {
            Keranjang::create([
                'customer_id' => Auth::id(),
                'produk_id' => $productId,
                'jumlah' => $request->quantity,
                'catatan' => $request->catatan
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Display cart
     */
    public function cart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItems = Keranjang::with(['produk.kategori', 'produk.gambarUtama'])
            ->where('customer_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });

        $cartCount = $cartItems->sum('jumlah');

        return view('customer.cart', compact('cartItems', 'total', 'cartCount'));
    }

    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'cart_id' => 'required|exists:keranjang,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Keranjang::where('id', $request->cart_id)
            ->where('customer_id', Auth::id())
            ->firstOrFail();

        $product = $cartItem->produk;
        
        if ($request->quantity > $product->stok) {
            return response()->json(['error' => 'Stok tidak mencukupi'], 400);
        }

        $cartItem->update(['jumlah' => $request->quantity]);

        $cartCount = Keranjang::where('customer_id', Auth::id())->sum('jumlah');
        $itemTotal = $cartItem->jumlah * $cartItem->produk->harga;
        $cartTotal = Keranjang::with('produk')
            ->where('customer_id', Auth::id())
            ->get()
            ->sum(function ($item) {
                return $item->jumlah * $item->produk->harga;
            });

        return response()->json([
            'success' => true,
            'cartCount' => $cartCount,
            'itemTotal' => number_format($itemTotal, 0, ',', '.'),
            'cartTotal' => number_format($cartTotal, 0, ',', '.')
        ]);
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $cartItem = Keranjang::where('id', $request->cart_id)
            ->where('customer_id', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        $cartCount = Keranjang::where('customer_id', Auth::id())->sum('jumlah');
        $cartTotal = Keranjang::with('produk')
            ->where('customer_id', Auth::id())
            ->get()
            ->sum(function ($item) {
                return $item->jumlah * $item->produk->harga;
            });

        return response()->json([
            'success' => true,
            'cartCount' => $cartCount,
            'cartTotal' => number_format($cartTotal, 0, ',', '.')
        ]);
    }
}
