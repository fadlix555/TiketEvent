<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;

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

        return redirect()->route('admin');
    }

    public function pendingOrders()
    {
        $pendingOrders = Order::with('detailOrders')->whereHas('detailOrders', function ($query) {
            $query->where('status_pembayaran', 'pending');
        })->get();

        return view('orders', compact('pendingOrders'));
    }

    public function completedRejectedOrders()
    {
        $completedRejectedOrders = Order::with('detailOrders')->whereHas('detailOrders', function ($query) {
            $query->whereIn('status_pembayaran', ['completed', 'rejected']);
        })->get();

        return view('riwayat', compact('completedRejectedOrders'));

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

        $event->update($data);
        return redirect()->route('admin')->with('berhasil', 'Data Berhasil Di Edit');
    }

    public function hapus(event $event)
    {
        $event->delete();
        return redirect()->route('admin')->with('notif', 'Data berhasil di hapus');
    }
    
}
