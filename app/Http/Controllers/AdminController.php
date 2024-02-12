<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Log;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function events()
    {
        $events = Event::all();
        return view('admin', compact('events'));
    }

    public function updateEventStatus(Event $event, Request $request)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $event->update([
            'status' => $request->status,
        ]);

        Log::create([
            'user_id' => auth()->id(),
            'activity' => Auth::user()->role . ' ' . Auth::user()->nama . ' ' . 'Merubah status event menjadi' . ' ' . $event->status,
        ]);

        return redirect()->route('admin');
    }

    public function pendingOrders()
    {
        $pendingOrders = Order::with('detailOrders')->whereHas('detailOrders', function ($query) {
            $query->where('status_pembayaran', 'pending');
        })->get();

        return view('orders', compact('pendingOrders'));
    }

    public function completedRejectedOrders(Request $request)
    {
        $completedRejectedOrders = Order::with('detailOrders')->whereHas('detailOrders', function ($query) {
            $query->whereIn('status_pembayaran', ['completed', 'rejected']);
        });
    
        if ($request->has('start_date') && $request->has('end_date')) {
            // Mendapatkan rentang tanggal dari input date
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            
            // Memastikan format tanggal yang benar
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
    
            // Menambahkan kondisi whereBetween untuk menyaring order berdasarkan rentang tanggal
            $completedRejectedOrders->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }
    
        $completedRejectedOrders = $completedRejectedOrders->get();
    
        return view('riwayat', compact('completedRejectedOrders'));
    }

    public function printRiwayatTransaksi(Request $request)
    {
        // Menggunakan with() untuk memuat detailOrders dalam kueri utama
        $orders = Order::with('detailOrders')->whereHas('detailOrders', function ($query) {
            $query->whereIn('status_pembayaran', ['completed', 'rejected']);
        });
    
        // Mendapatkan rentang tanggal dari input date
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Memastikan format tanggal yang benar (telah diubah sebelumnya)
        // $startDate = date('Y-m-d', strtotime($startDate));
        // $endDate = date('Y-m-d', strtotime($endDate));
    
        // Filter orders berdasarkan rentang tanggal
        $orders->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
    
        // Mengambil data setelah filter
        $orders = $orders->get();
    
        // Menghasilkan file PDF dari view 'riwayat-pdf' dengan data yang dimasukkan
        $pdf = PDF::loadView('riwayat-pdf', compact('orders'));
    
        // Mengunduh file PDF dengan nama tertentu
        return $pdf->download('Riwayat-Transaksi.pdf');
    }
    



    public function updateOrderStatus($id, Request $request)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:pending,completed,rejected',
        ]);

        
        $order = Order::where('id',$id)->first();
        $detailorder = DetailOrder::where('order_id',$order->id)->first();
        $detailorder->status_pembayaran = $request->status_pembayaran;

        if ($detailorder->status_pembayaran === 'completed') {
            $detailorder->event->stok -= $detailorder->qty;
        }

        Log::create([
            'user_id' => auth()->id(),
            'activity' => Auth::user()->role . ' Mengkonfirmasi pembayaran menjadi ' . $detailorder->status_pembayaran,
        ]);

        $detailorder->event->save();
        $detailorder->save();

        return redirect()->route('orders');
    }

    public function tambah()
    {
        $data = Category::all();
        return view('tambah',compact('data'));
    }

    public function posttambah(request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'map' => 'required',
            'foto' => 'required',
            'lokasi' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
            'stok' => 'required',
            'Category_id' => 'required',
        ]);


        Event::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'map' => $request->map,
            'foto' => $request->foto->store('img'),
            'status' => 'active',
            'lokasi' => $request->lokasi,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'stok' => $request->stok,
            'Category_id' => $request->Category_id,
        ]);

        Log::create([
            'user_id' => auth()->id(),
            'activity' => Auth::user()->role . ' ' . Auth::user()->nama . ' Menambah Event',
        ]);

        return redirect()->route('admin')->with('berhasil', 'Berhasil menambahkan event');
    }

    public function edit(event $event)
    {
        $category = Category::all();
        return view('edit',compact('event', 'category'));
        
    }

    public function postedit(request $request,event $event)
    {
        $data = $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'map' => 'required',
            'lokasi' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
            'stok' => 'required',
            'Category_id' => 'required',
        ]);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->foto->store('img');
        } else {
            unset($data['foto']);
        }

        Log::create([
            'user_id' => auth()->id(),
            'activity' => Auth::user()->role  . ' ' . Auth::user()->nama  . ' Mengedit Event ' . $event->nama,
        ]);

        $event->update($data);
        return redirect()->route('admin')->with('berhasil', 'Data Berhasil Di Edit');
    }

    public function log()
    {
        $log = Log::all();
        return view('log',compact('log'));
    }

    public function hapus(event $event)
    {
        $event->delete();

        Log::create([
            'user_id' => auth()->id(),
            'activity' => Auth::user()->role . ' ' . Auth::user()->role . ' Mengedit Event ' . $event->nama,
        ]);

        return redirect()->route('admin')->with('notif', 'Data berhasil di hapus');
    }

    
}
