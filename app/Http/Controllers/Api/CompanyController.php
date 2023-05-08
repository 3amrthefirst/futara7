<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Subscribtion;
use App\Models\User;
use Helper\Attachment;
use Illuminate\Http\Request;
use Laravel\Passport\TokenRepository;


class CompanyController extends Controller
{

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'password' => 'required|min:8' ,
            'email' => 'required|email|unique:companies,email',
            'phone' => 'required'
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
            $user =Company::create($request->all());
            return response()->json([
                'code'    => 200,
                'status'  => 1,
                'errors'  => null,
                'message' => 'success',
                'data'    => $user
            ]);
        }
    }

    public function login(Request $request)
    {
        $rules = [
            'password' => 'required|min:8' ,
            'email' => 'required|email|exists:companies,email',
        ];

        $data = validator()->make($request->all(), $rules);
        if ($data->fails())
        {
            return response()->json([
                'code'    => 422,
                'status'  => 1,
                'errors'  => $data->errors(),
                'message' => 'bad Credentials',
                'data'    => null
            ]);
        }else{
            $user = Company::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'code'    => 422,
                    'status'  => 1,
                    'errors'  => $data->errors(),
                    'message' => 'bad Credentials',
                    'data'    => null
                ]);
            }
            $user['token'] = $user->createToken('passport_token')->accessToken;
            return response()->json([
                'code'    => 200,
                'status'  => 1,
                'errors'  => null,
                'message' => 'success',
                'data'    => $user
            ]);
        }

    }

    public function logout()
    {
        $token = auth()->user()->token();

        $tokenReposetory = app(TokenRepository::class);
        $tokenReposetory->revokeAccessToken($token->id);
        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'logout success',
            'data'    => null
        ]);
    }

    public function subscription()
    {
        $data = Subscribtion::all();
        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'success',
            'data'    => $data
        ]);

    }

    public function makeSubscription(Request $request)
    {
        $rules = [
            'company_id' => 'required|exists:companies,id' ,
            'subscription_id' => 'required|exists:subscribtions,id',
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
            $user = Company::findOrFail($request->company_id);
            $subscription = Subscribtion::findOrFail($request->subscription_id);
            $user->subscribe_id = $request->subscription_id;
            $user->subscription_end_date = now()->addDays($subscription->days) ;
            $user->save();
            return response()->json([
                'code'    => 200,
                'status'  => 1,
                'errors'  => null,
                'message' => 'success',
                'data'    => $user
            ]);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function firebase(Request $request)
    {
        $rules = [
            'firebase_id' => 'required',
            'phone' => 'required',
        ];

        $data = validator()->make($request->all(), $rules);

        if ($data->fails()) {
            return response()->json([
                'code' => 422,
                'status' => 1,
                'errors' => $data->errors(),
                'message' => 'bad Credentials',
                'data' => null
            ]);
        }else {
            $user = Company::where('phone', $request->phone)
                ->where('fire_base_id', $request->firebase_id)
                ->first();

            if ($user) {
                $user['token'] = $user->createToken('passport_token')->accessToken;

                return response()->json([
                    'code' => 200,
                    'status' => 1,
                    'errors' => null,
                    'message' => 'already user',
                    'data' => $user
                ]);
            } else {
                $user = Company::create([
                    'fire_base_id' => $request->firebase_id,
                    'phone' => $request->phone,
                    'name' => 'company',
                    'email' => 'company@ex.com',
                ]);
                $user['token'] = $user->createToken('passport_token')->accessToken;

                return response()->json([
                    'code' => 200,
                    'status' => 1,
                    'errors' => null,
                    'message' => 'success',
                    'data' => $user
                ]);
            }
        }
    }
    public function company($u_id){

        $company = Company::where('fire_base_id' , $u_id)->first();
        if (!$company)
        {
            return response()->json([
                'code'    => 404,
                'status'  => 0,
                'errors'  => 1,
                'message' => 'Not Found',
                'data'    => null
            ]);
        }else{
            return response()->json([
                'code'    => 200,
                'status'  => 1,
                'errors'  => null,
                'message' => 'success',
                'data'    => $company
            ]);
        }
    }
    public function companyByPhone($phone){

        $company = Company::where('phone' , $phone)->first();
        if (!$company)
        {
            return response()->json([
                'code'    => 404,
                'status'  => 0,
                'errors'  => 1,
                'message' => 'Not Found',
                'data'    => null
            ]);
        }else{
            return response()->json([
                'code'    => 200,
                'status'  => 1,
                'errors'  => null,
                'message' => 'success',
                'data'    => $company
            ]);
        }
    }
    public function index()
    {

        $data = $this->show(auth()->user()->id);
        $data['contact_us'] = Contact::all();
        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'success',
            'data'    => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user =Company::with('attachmentRelation')->find($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $record = Company::with('attachmentRelation')->findOrFail($id);
        $rules = [
            'tax_rate' => 'numeric'
        ];
        $this->validate($request,$rules);
        $record->update($request->all());

        $oldFile = $record->attachmentRelation ?? null;
//        dd($record->attachmentRelation);
        if ($request->has('image')) {
            Attachment::deleteAttachment($record, 'attachmentRelation', false, 'image');
            Attachment::updateAttachment($request->image,$oldFile , $record, 'company', ['save' => 'original', 'usage' => 'img']);
        }
        $data = $this->show($record->id);
        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'success',
            'data'    => $data
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Company::findOrFail($id);
        $record->delete();
        return response()->json([
            'code'    => 200,
            'status'  => 1,
            'errors'  => null,
            'message' => 'deleted',
            'data'    => null
        ]);
    }

}
