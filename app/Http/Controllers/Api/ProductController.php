<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Helper\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request , $id)
    {
        if ($request->paginate){
            $data = Product::with('attachmentRelation')->where('category_id' , $id)->paginate($request->paginate);
        }else{
            $data = Product::with('attachmentRelation')->where('category_id' , $id)->get();
        }

        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'success',
            'data'    => $data
        ]);

    }
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'optional_price' => 'required|numeric',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id' ,
            'image' => 'required' ,
            'is_tax' => 'required'
        ];

        $data = validator()->make($request->all(), $rules);


        if ($data->fails())
        {
            return response()->json([
                'code'    => 422,
                'status'  => 1,
                'errors'  => $data->errors(),
                'message' => 'failed',
                'data'    => null
            ]);
        }else{
            $product =Product::create($request->all());
            if ($request->has('image')) {
                Attachment::addAttachment($request->image, $product, 'products', ['save' => 'original', 'usage' => 'img']);
            }
            $product['image'] = $product->attachmentRelation;

            return response()->json([
                'code'    => 200,
                'status'  => 1,
                'errors'  => null,
                'message' => 'success',
                'data'    => $product
            ]);
        }
    }
}
