<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Order;
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
        $detailorder = DetailOrder::with('Event')->get();
        return view('order', compact('detailorder'));
    }

    public function postorder(Request $request, Event $Event)
    {
        $request->validate([
            'banyak' => 'required|numeric|min:1',
        ]);

        $existingOrder = DetailOrder::where('user_id', Auth::id())
            ->where('event_id', $Event->id)
            ->first();

        if ($existingOrder) {
            // Jika sudah ada order untuk event tersebut
            if ($existingOrder->status_pembayaran == 'completed') {
                // Jika status pembayaran sebelumnya adalah completed, create a new order
                DetailOrder::create([
                    'qty' => $request->banyak,
                    'user_id' => Auth::id(),
                    'event_id' => $Event->id,
                    'status_pembayaran' => 'pending',
                    'pricetotal' => $Event->harga * $request->banyak,
                ]);
            } else {
                // Jika status pembayaran sebelumnya bukan completed, update kuantitasnya
                $newQty = $existingOrder->qty + $request->banyak;

                if ($newQty > $Event->stok) {
                    return redirect()->back()->with('notif', 'Maaf, stok tiket tidak mencukupi.');
                }

                $existingOrder->update([
                    'qty' => $newQty,
                    'pricetotal' => $Event->harga * $newQty,
                ]);
            }
        } else {
            // Jika belum ada order untuk event tersebut
            if ($request->banyak > $Event->stok) {
                return redirect()->back()->with('notif', 'Maaf, stok tiket tidak mencukupi.');
            }

            DetailOrder::create([
                'qty' => $request->banyak,
                'user_id' => Auth::id(),
                'event_id' => $Event->id,
                'status_pembayaran' => 'pending',
                'pricetotal' => $Event->harga * $request->banyak,
            ]);
        }

        return redirect()->route('order');
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
}
