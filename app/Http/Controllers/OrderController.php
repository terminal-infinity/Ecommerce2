<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function view_order(){
        $data=Order::all();
        return view('admin.partials.orders.order',compact('data'));
    }
    public function on_the_way($id){
        $data=Order::find($id);
        $data->status='On the way';
        $data->save();
        return redirect()->route('admin.view_order')->with('success','Order On The Way');
    }
    public function delivered($id){
        $data=Order::find($id);
        $data->status='Delivered';
        $data->save();
        return redirect()->route('admin.view_order')->with('success','Order Delivered');
    }

    public function print_pdf($id){
        $data=Order::find($id);
        $pdf = Pdf::loadView('admin.partials.orders.invoice', compact('data'));
        return $pdf->download('order.pdf');
    }
}
