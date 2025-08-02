<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $query = Transaction::with('category')->where('user_id', $userId);

        $this->applyFilters($query, $request, $userId);

        $transactions = $query->latest()->get();
        $categories = Category::where('user_id', $userId)->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric',
            'type'        => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'date'        => 'required|date',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Validasi ownership kategori
        $this->authorizeCategory($validated['category_id']);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('receipt')) {
            $validated['receipt'] = $request->file('receipt')->store('receipts', 'public');
        }

        Transaction::create($validated);

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Transaction $transaction)
    {
        $this->authorizeAccess($transaction);

        $categories = Category::where('user_id', Auth::id())->get();

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorizeAccess($transaction);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric',
            'type'        => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'date'        => 'required|date',
            'receipt'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Validasi ownership kategori
        $this->authorizeCategory($validated['category_id']);

        // Handle file baru
        if ($request->hasFile('receipt')) {
            if ($transaction->receipt && Storage::disk('public')->exists($transaction->receipt)) {
                Storage::disk('public')->delete($transaction->receipt);
            }

            $validated['receipt'] = $request->file('receipt')->store('receipts', 'public');
        }

        $transaction->update($validated);

        return redirect()->route('transactions.index')
                         ->with('success', 'Transaksi berhasil diupdate.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeAccess($transaction);

        // Hapus file jika ada
        if ($transaction->receipt && Storage::disk('public')->exists($transaction->receipt)) {
            Storage::disk('public')->delete($transaction->receipt);
        }

        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }

   public function exportPdf(Request $request)
{
    $userId = Auth::id();
    $query = Transaction::with('category')->where('user_id', $userId);

    $this->applyFilters($query, $request, $userId);

    $transactions = $query->latest()->get();

    $printedAt = now()->translatedFormat('d F Y, H:i');

    $pdf = Pdf::loadView('transactions.pdf', [
        'transactions' => $transactions,
        'printedAt' => $printedAt,
        'month' => $request->month 
    ])->setPaper('a4', 'portrait');

    return $pdf->download('laporan-transaksi.pdf');
}


    /**
     * Pastikan transaksi milik user yang login
     */
    private function authorizeAccess(Transaction $transaction): void
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
    }

    /**
     * Pastikan kategori milik user
     */
    private function authorizeCategory($categoryId): void
    {
        $exists = Category::where('id', $categoryId)
                          ->where('user_id', Auth::id())
                          ->exists();

        if (! $exists) {
            abort(403, 'Kategori tidak ditemukan atau bukan milik Anda.');
        }
    }

    /**
     * Filter transaksi berdasarkan parameter pencarian
     */
    private function applyFilters(&$query, Request $request, $userId): void
    {
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category_id')) {
            $this->authorizeCategory($request->category_id);
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);
            $query->whereYear('date', $year)
                  ->whereMonth('date', $month);
        }
    }
}
