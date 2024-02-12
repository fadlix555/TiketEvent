<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function welcome()
    {
        $data = Event::where('status', 'active')->get();

        return view('welcome', compact('data'));
    }

    public function detail(Event $Event)
    {
        if (auth()->check()) {
            return view('detailevent',compact('Event'));
        } else {
            return redirect()->route('login')->with('error', 'Login terlebih dahulu');
        }
    }

    public function order(request $request)
    {
        $detailorder = DetailOrder::with('Event')
        ->whereNull('bukti_pembayaran')
        ->where('user_id', auth()->id())
        ->where('status_pembayaran', 'pending')
        ->get();

        return view('order', compact('detailorder'));
    }

    public function postorder(Request $request, Event $Event)
{
    $request->validate([
        'banyak' => 'required|numeric|min:1',
    ]);

    // Mencari order pending yang tidak memiliki bukti pembayaran
    $existingPendingOrder = DetailOrder::where('event_id', $Event->id)
        ->where('status_pembayaran', 'pending')
        ->whereNull('bukti_pembayaran')
        ->first();

    if ($existingPendingOrder) {
        // Jika ada order pending yang tidak memiliki bukti pembayaran, tambahkan qty dan pricetotal pada order tersebut
        $newQty = $existingPendingOrder->qty + $request->banyak;

        if ($newQty > $Event->stok) {
            return redirect()->back()->with('notif', 'Maaf, stok tiket tidak mencukupi.');
        }

        $existingPendingOrder->update([
            'qty' => $newQty,
            'pricetotal' => $existingPendingOrder->pricetotal + ($Event->harga * $request->banyak),
        ]);
    } else {
        // Mencari order yang selesai atau ditolak
        $existingCompletedOrder = DetailOrder::where('event_id', $Event->id)
            ->whereIn('status_pembayaran', ['completed', 'rejected'])
            ->first();

        if ($existingCompletedOrder) {
            // Jika ada order yang selesai atau ditolak, buat order baru dengan status pembayaran pending
            DetailOrder::create([
                'qty' => $request->banyak,
                'user_id' => Auth::id(),
                'event_id' => $Event->id,
                'status_pembayaran' => 'pending',
                'pricetotal' => $Event->harga * $request->banyak,
            ]);
        } else {
            // Jika tidak ada order sebelumnya, buat order baru dengan status pembayaran pending
            DetailOrder::create([
                'qty' => $request->banyak,
                'user_id' => Auth::id(),
                'event_id' => $Event->id,
                'status_pembayaran' => 'pending',
                'pricetotal' => $Event->harga * $request->banyak,
            ]);
        }
    }

    return redirect()->route('order')->with('notif', 'Mohon selesaikan pembayaran');
}


    public function history()
    {
        $orderHistory = DetailOrder::with('Event')
            ->where('user_id', auth()->id())
            ->whereIn('status_pembayaran', ['completed', 'rejected', 'pending'])
            ->whereNotNull('bukti_pembayaran')
            ->get();

        return view('history', compact('orderHistory'));
    }

    public function bayar(request $request,DetailOrder $detailorder)
    {
        $event = $detailorder->event;
        return view('bayar',compact('detailorder','event'));
    }

    public function postbayar(request $request, DetailOrder $detailorder)
    {
        $request->validate([
            'bukti_pembayaran' => 'required' 
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'pricetotal' => $detailorder->pricetotal,
            'code' => 'INV' . Str::random(8)
        ]);

        $detailorder->update([
            'order_id' => $order->id,
            'bukti_pembayaran' => $request->bukti_pembayaran->store('img')
        ]);

        $event = $detailorder->event;
        $event->save();

        return redirect()->route('welcome')->with('notif', 'Berhasil membayar');
    }

    public function batalkanpesanan(DetailOrder $detailorder)
    {
        $detailorder->delete();
        return redirect()->route('order')->with('notif','Pesanan berhasil dibatalkan');
    }

    public function printInvoiceTicket($id)
    {
        // Retrieve the DetailOrder with the specified ID along with its related Order and Event
        $detailOrder = DetailOrder::with(['order', 'event','user'])->find($id);

        if (!$detailOrder) {
            abort(404); // Handle the case when DetailOrder is not found
        }

        // Pass the data to the Blade view
        $data = [
            'detailOrder' => $detailOrder,
        ];

        // Generate PDF using barryvdh/laravel-dompdf
        $pdf = PDF::loadView('invoice-ticket', $data);

        // Download the PDF with a custom filename
        return $pdf->download($detailOrder->order->code . '.pdf');
    }
}
