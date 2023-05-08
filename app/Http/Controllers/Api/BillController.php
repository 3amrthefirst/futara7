<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Company;
use App\Models\Product;
use App\Models\QuickBill;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class BillController extends Controller
{
    public function index(Request $request)
    {
        if ($request->paginate){
            $data = Bill::with('client' , 'company' , 'products')->where('company_id' , auth()->user()->id)->paginate($request->paginate);
        }else{
            $data =  Bill::with('client' , 'company' , 'products')->where('company_id' , auth()->user()->id)->get();
        }
        $total_bills = $data->sum('final_price');
        $total_tax = $data->sum('tax_amount');
        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'success',
            'bills_total_amount' => $total_bills ,
            'total_tax_amount' => $total_tax,
            'data'    => $data ,
        ]);
    }

    public function singleBill($id , Request $request)
    {
        if ($request->quick) {
            $data = QuickBill::with('company')->where('id', $id)->get();
            $data['tax_number'] = auth()->user()->tax_number;
            $data['company_logo'] = url('logo.jpg');
            $data['qr'] = url('qrcode/'.$id.'/quick/'.auth()->user()->id);

            if ($data) {
                return response()->json([
                    'code' => 200,
                    'status' => 1,
                    'errors' => null,
                    'message' => 'success',
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'code' => 404,
                    'status' => 0,
                    'errors' => null,
                    'message' => 'Not Found',
                    'data' => null
                ]);

            }
        }
        $data = Bill::with('client' , 'company' , 'products')->where('id' , $id)->get();
        $data['tax_number'] = auth()->user()->tax_number;
        $data['company_logo'] = url('logo.jpg');
        $data['qr'] = url('qrcode/'.$id.'/bill/'.auth()->user()->id);
        if ($data){
            return response()->json([
                'code'    => 200,
                'status'  => 1,
                'errors'  => null,
                'message' => 'success',
                'data'    => $data
            ]);
        }else{
            return response()->json([
                'code'    => 404,
                'status'  => 0,
                'errors'  => null,
                'message' => 'Not Found',
                'data'    => null
            ]);
        }

    }

    public function destroy($id)
    {
        $data = Bill::findOrFail($id);
        $data->delete();
        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'deleted',
            'data'    => null
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
          'company_id' => 'required|exists:companies,id',
          'client_id' => 'required|exists:clients,id'  ,
            'payment_type' => 'required' ,
        ];

        $data = validator()->make($request->all() , $rules);

        if ($data->fails())
        {
            return response()->json([
                'code'    => 422,
                'status'  => 0,
                'errors'  => $data->errors(),
                'message' => 'validation error',
                'data'    => null
            ]);
        }

        $record = Bill::create([
          'company_id' => $request->company_id ,
          'client_id' => $request->client_id ,
            'tax_amount' => 0 ,
            'final_price' => 0 ,
            'payment_type' => $request->payment_type
        ]);


        foreach ($request->products as $item)
        {
            $quantity = $item['quantity'] ?? 1 ;

            $record->products()->attach([ $item['id'] => [
                'quantity' => $quantity
                ] ]);
            $product = Product::find($item['id']);
            $price = $product->price * $quantity;
            $price_before_tax = $record->price_before_tax + $price ;
            $record->price_before_tax = $price_before_tax;

            if ($product->is_tax == 1){
                $tax = $product->price * $record->company->tax_rate / 100 ;
                $tax_amount = $record->tax_amount + $tax ;

                $record->tax_amount = $tax_amount ;
            }

            $record->save();
        }
        $record->final_price = $record->tax_amount + $record->price_before_tax ;
        $record->save();


        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'success',
            'data'    => $record
        ]);

    }

    public function pdfBill($id)
    {
        $data = Bill::with('company' , 'client' , 'products')->find($id);

        if ($data)
        {
            //return view('pdf.document' , compact('data'));
            $pdf = PDF::loadView('pdf.document', compact('data'));
            return $pdf->download();

        }else{
            return response()->json([
                'code'    => 404,
                'status'  => 1,
                'errors'  => null,
                'message' => 'not a record',
                'data'    => null
            ]);
        }
    }
    public function pdfBillApi($id)
    {
        $data = Bill::find($id);

        if ($data)
        {
            return redirect('pdf/'.$id);

        }else{
            return response()->json([
                'code'    => 404,
                'status'  => 1,
                'errors'  => null,
                'message' => 'not a record',
                'data'    => null
            ]);
        }
    }
    public function sum()
    {
        $bill = Bill::find(2);

        foreach ($bill->products as $product)
        {
            $price = $bill->final_price + $product->price ;
            $bill->final_price = $price;
            $bill->save();
        }
        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'success',
            'data'    => $bill
        ]);
    }

    public function makeQuickBill(Request $request)
    {
        $rules = [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required' ,
            'price' => 'required' ,
        ];

        $data = validator()->make($request->all() , $rules);

        if ($data->fails())
        {
            return response()->json([
                'code'    => 422,
                'status'  => 0,
                'errors'  => $data->errors(),
                'message' => 'validation error',
                'data'    => null
            ]);
        }
        $company = Company::find($request->company_id);
        $tax = $request->price * $company->tax_rate / 100 ;
        $final_price = $request->price + $tax ;
        $data = QuickBill::create([
            'company_id' => $request->company_id,
            'name' => $request->name ,
            'price' => $request->price ,
            'tax' => $tax ,
            'final_price' => $final_price ,
        ]);

        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'success',
            'data'    => $data
        ]);
    }

    public function quickBills()
    {
        $data = QuickBill::where('company_id' , auth()->user()->id)->get();
        $total_bills = $data->sum('final_price');
        $total_tax = $data->sum('tax_amount');
        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'success',
            'bills_total_amount' => $total_bills ,
            'total_tax_amount' => $total_tax,
            'data'    => $data
        ]);
    }

    public function QrIndex($id , $type , $coId)
    {
        return view('qrcode' , compact('id' , 'type' , 'coId'));
    }

    public function singleBillWeb($id , $type , $coId)
    {
        if ($type == 'quick') {
            $data = QuickBill::find($id);
            $data['tax_number'] = Company::find($coId)->tax_number;
            $data['company_logo'] = url('logo.jpg');

            return view('bill', compact('data'));
        }else{
            $data = Bill::find($id);
            $data['tax_number'] = Company::find($coId)->tax_number;
            $data['company_logo'] = url('logo.jpg');

            return view('bill', compact('data'));
        }
    }
}
