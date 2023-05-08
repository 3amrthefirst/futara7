<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Company;
use App\Models\Product;
use App\MyHelper\Helper;
use Helper\Attachment;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $model;
    protected $helper;
    protected $viewsDomain = 'admin/company.';
    protected $url = 'admin/companies';


    public function __construct()
    {
        $this->model = new Company();
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
                $q->where('name','LIKE','%'. $request->name .'%');
            }
            if ($request->phone) {
                $q->where('phone','LIKE','%'. $request->phone .'%');
            }
            if ($request->email) {
                $q->where('email','LIKE','%'. $request->email .'%');
            }
        })->latest()->paginate(10);
        $totalRecords = $records->count();
        return $this->view('index', compact('records'));
    }

        public function clients(Request $request , $id)
    {
        $records = Client::where('company_id' , $id )->where(function ($q) use ($request) {
            if ($request->name) {
                $q->where('name','LIKE','%'. $request->name .'%');
            }
            if ($request->phone) {
                $q->where('phone','LIKE','%'. $request->phone .'%');
            }
            if ($request->email) {
                $q->where('email','LIKE','%'. $request->email .'%');
            }
        })->latest()->paginate(10);
        $totalRecords = $records->count();
        return view('admin.company.clients-index', compact('records'));
    }

    public function categories(Request $request , $id)
    {
        $records = Category::where('company_id' , $id )->where(function ($q) use ($request) {
            if ($request->name) {
                $q->where('title','LIKE','%'. $request->name .'%');
            }

        })->latest()->paginate(10);
        $totalRecords = $records->count();
        return view('admin.company.categories-index', compact('records'));
    }
    public function products(Request $request , $id)
    {
        $category =  Category::find($id);
        $records = Product::where('category_id' , $id )->where(function ($q) use ($request) {
            if ($request->name) {
                $q->where('title','LIKE','%'. $request->name .'%');
            }

        })->latest()->paginate(10);
        $totalRecords = $records->count();
        return view('admin.company.products-index', compact('records' , 'category'));
    }

    public function create()
    {
        $model = $this->model ;
        $edit = false ;
        return  $this->view('create',compact('model','edit'));
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
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ];
        $messages = [
            'name.required' => 'الاسم مطلوب',
            'phone.required' => 'رقم الهاتف مطلوب',
            'email.required'=> 'البريد اﻹلكتروني مطلوب',
        ];
        $this->validate($request, $rules, $messages);
        $record = $this->model->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => "123",
        ]);
        if ($request->has('image')) {
            Attachment::addAttachment($request->image, $record, 'companies', ['save' => 'original', 'usage' => 'img']);
        }
        session()->flash('success', 'تم الإضافة');
        return redirect(route('companies.index'));
    }

    public function edit(Request $request,$id)
    {
        $model = $this->model->findOrFail($id);
        $edit = true ;
        return $this->view('edit', compact('model','edit'));
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

        session()->flash('success','تم التعديل');
        return redirect(route('companies.index'));
    }

    public function destroy($id){
        $record = $this->model->find($id);
        $record->delete();
        session()->flash('success','تم الحذف');
        return redirect(route('companies.index'));
    }

}
