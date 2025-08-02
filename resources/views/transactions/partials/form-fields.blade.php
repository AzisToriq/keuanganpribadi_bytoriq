use Illuminate\Support\Facades\Storage; // Tambahkan di bagian atas

// ...

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'type' => 'required|in:income,expense',
        'category_id' => 'required|exists:categories,id',
        'date' => 'required|date',
        'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $validated['user_id'] = Auth::id();

    if ($request->hasFile('receipt')) {
        $validated['receipt'] = $request->file('receipt')->store('receipts', 'public');
    }

    Transaction::create($validated);

    return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
}

public function update(Request $request, Transaction $transaction)
{
    $this->authorizeAccess($transaction);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'type' => 'required|in:income,expense',
        'category_id' => 'required|exists:categories,id',
        'date' => 'required|date',
        'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    if ($request->hasFile('receipt')) {
        // Hapus file lama jika ada
        if ($transaction->receipt) {
            Storage::disk('public')->delete($transaction->receipt);
        }

        // Upload yang baru
        $validated['receipt'] = $request->file('receipt')->store('receipts', 'public');
    }

    $transaction->update($validated);

    return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate.');
}
