Route::get('/test-invoice/{order}', function(\App\Models\Order $order) {
    return view('invoices.order-invoice', compact('order'));
})->middleware('auth');