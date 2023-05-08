<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Company;
use App\Models\Product;
use App\MyHelper\Helper;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $model;
    protected $helper;
    protected $viewsDomain = 'admin/category.';
    protected $url = 'admin/category';


    public function __construct()
    {
        $this->model = new Category();
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
        $model = $this->model ;
        $edit = false ;
        return  $this->view('create',compact('model','edit' , 'company'));
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
            'company_id' => 'required',
        ];
        $messages = [
            'name.required' => 'الاسم مطلوب',
            'company_id.required'=> ' اسم الشركه مطلوب',
        ];
        $this->validate($request, $rules, $messages);
        $record = $this->model->create($request->all());

        session()->flash('success', 'تم الإضافة');
        return redirect(route('category.index'));
    }

    public function edit(Request $request,$id)
    {   $company = Company::all();
        $model = $this->model->findOrFail($id);
        $edit = true ;
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
        session()->flash('success','تم التعديل');
        return redirect(route('category.index'));
    }

    public function destroy($id){
        $record = $this->model->find($id);
        $record->delete();
        session()->flash('success','تم الحذف');
        return redirect(route('category.index'));
    }
}
