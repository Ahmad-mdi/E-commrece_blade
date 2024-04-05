<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class OrderController extends Controller
{
    public function create()
    {
        return view('client.orders.create', [
            'items' => Cart::getItems(),
            'total_items' => Cart::totalItems(),
            'total_price' => Cart::totalPrice(),
        ]);
    }

    public function store(OrderRequest $request)
    {
        $order = Order::query()->create([
            'price' => Cart::totalPrice(),
            'address' => $request->get('address'),
        ]);
        foreach (Cart::getItems() as $item) {
            $product = $item['product'];
            $productQty = $item['quantity'];
            $order->details()->create([
                'product_id' => $product->id,
                'count' => $productQty,
                'unit_price' => $product->price_with_discount,
                'total_price' => $productQty * $product->price_with_discount,
            ]);
        }
        Cart::removeAllItems();
        $invoice = (new Invoice)->amount($order->price);
        return Payment::purchase($invoice, function ($driver, $transactionId) use ($order) {
            $order->update([
                'transaction_id' => $transactionId,
            ]);
        })->pay()->render();
//        return back();
    }

    public function callback(Request $request)
    {
        $order = Order::query()->where('transaction_id',$request->get('Authority'))->first();
        $order->update([
           'payment_status' => $request->get('Status'),
        ]);
        return redirect(route('client.orders.show',$order));
    }

    public function show(Order $order)
    {
        return view('client.orders.show',[
           'order' => $order,
        ]);
    }
}
