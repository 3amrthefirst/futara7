<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\MyHelper\Helper;
use Helper\Attachment;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $model;
    protected $helper;
    protected $viewsDomain = 'admin/products.';
    protected $url = 'admin/products';


    public function __construct()
    {
        $this->model = new Product();
        $this->helper = new Helper();
    }

    private function view($view, $params = [])
    {
        return view($this->viewsDomain . $view, $params);
    }

    public function index(Request $request)
    {
        $records = $this->model->where(function ($q) use ($request) {
            if ($request->name) {
                $q->where('title','LIKE','%'. $request->name .'%');
            }
        })->latest()->paginate(10);
        $totalRecords = $records->count();
        return $this->view('index', compact('records'));
    }

    public function create()
    {
        $company = Company::all();
        $category = Category::all();
        $model = $this->model ;
        $edit = false ;
        return  $this->view('create',compact('model','edit' , 'company' , 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'image' => 'required'
        ];
        $messages = [
            'title.required' => 'الاسم مطلوب',
            'content.required' => 'التفاصيل مطلوب',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب ان يكون رقم',
            'category_id.required'=> ' اسم القسم مطلوب',
            'image.required' => 'الصوره مطلوبه'
        ];
        $this->validate($request, $rules, $messages);
        $record = $this->model->create($request->all());
        if ($request->has('image')) {
            Attachment::addAttachment($request->image, $record, 'products', ['save' => 'original', 'usage' => 'img']);
        }
        session()->flash('success', 'تم الإضافة');
        return redirect(route('product.index'));
    }

    public function edit(Request $request,$id)
    {
        $company = Company::all();
        $category = category::all();
        $model = $this->model->findOrFail($id);
        $edit = true;
        return $this->view('edit', compact('model','edit' , 'company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $record = $this->model->findOrFail($id);
        $record->update($request->all());
        $oldFile = $record->attachmentRelation[0] ?? null;
        if ($request->has('image')) {
            Attachment::deleteAttachment($record, 'attachmentRelation', false, 'image');
            Attachment::updateAttachment($request->image,$oldFile , $record, 'products', ['save' => 'original', 'usage' => 'img']);
        }

        session()->flash('success','تم التعديل');
        return redirect(route('product.index'));
    }

    public function destroy($id){
        $record = $this->model->find($id);
        $record->delete();
        session()->flash('success','تم الحذف');
        return redirect(route('product.index'));
    }
}
