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
    public function cariEvent(Request $request)
    {
        // Ambil kriteria pencarian dari input pengguna
        $kriteria = $request->input('kriteria');
    
        // Lakukan pencarian event berdasarkan kriteria
        $data = Event::where('status', 'active')
                    ->where(function($query) use ($kriteria) {
                        $query->where('nama', 'like', '%' . $kriteria . '%')
                            ->orWhere('lokasi', 'like', '%' . $kriteria . '%');
                    })
                    ->get();
    
        // Kondisikan view berdasarkan hasil pencarian
        if ($data->isEmpty()) {
            // Jika tidak ada hasil pencarian, tetap definisikan $data agar tidak error di view
            $data = collect(); // Membuat collection kosong
        }
    
        // Tampilkan view welcome dengan data yang sesuai
        return view('welcome', compact('data'));
    }
    

    // Fungsi untuk menampilkan halaman utama dengan event terbaru
    public function welcome()
    {
        // Ambil semua event yang memiliki status 'active'
        $data = Event::all();

        return view('welcome', compact('data'));
    }

    public function detail(Event $Event)
    {
        return view('detailevent',compact('Event'));
    }

    public function order(request $request)
    {
        $detailorder = DetailOrder::with('Event')
        ->whereNull('bukti_pembayaran')
        ->where('user_id', auth()->id())
        ->where('status_pembayaran', 'pending')
        ->get();

        return view('transaksi.pesan', compact('detailorder'));
    }

    public function postorder(Request $request, Event $Event)
    {
        if (auth()->check()) {
            $request->validate([
                'banyak' => 'required|numeric|min:1',
            ]);

            if ($request->banyak > $Event->stok) {
                return redirect()->back()->with('notif', 'Maaf, stok tiket tidak mencukupi.');
            }
    
            // Mencari order pending yang tidak memiliki bukti pembayaran
            $existingPendingOrder = DetailOrder::where('event_id', $Event->id)
                ->where('status_pembayaran', 'pending')
                ->whereNull('bukti_pembayaran')
                ->first();
    
            if ($existingPendingOrder) {
                // Jika ada order pending yang tidak memiliki bukti pembayaran, tambahkan qty dan pricetotal pada order tersebut
                $newQty = $existingPendingOrder->qty + $request->banyak;
                
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
        
        } else {

            return redirect()->route('login')->with('notif', 'Login terlebih dahulu');
        }
    }


    public function history()
    {
        $orderHistory = DetailOrder::with('Event')
            ->where('user_id', auth()->id())
            ->whereIn('status_pembayaran', ['completed', 'rejected', 'pending'])
            ->whereNotNull('bukti_pembayaran')
            ->get();

        return view('user.riwayatuser', compact('orderHistory'));
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
        $pdf = PDF::loadView('transaksi.invoice-ticket', $data);

        // Download the PDF with a custom filename
        return $pdf->download($detailOrder->order->code . '.pdf');
    }
}
