<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\UserAddess;
use Exception;
use Illuminate\Http\Request;



class ApiAddessController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userAddess=auth('api')->user()->userAddess;
        return response($userAddess);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{ 
            $addessUser=auth('api')->user()->userAddess()->create([
                'state_name'=>$request->state_name,
                'city_name'=>$request->city_name,
                'city_code'=>$request->city_code,
                'post_code'=>$request->post_code,
                'lanline_phone'=>$request->lanline_phone,
                'addess_phone'=>$request->addess_phone,
                'address'=>$request->address
            ]);   
            if($addessUser){
                return response([
                    'success'=>true
                ]);
            }else{
                return response([
                    'success'=>false
                ]);
            }
        }catch(Exception $e){
            return response([
                'success'=>false,
                'message'=>$e
            ]);   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            return response(UserAddess::find($id));
        }catch(Exception $e){
            return response([
                'success'=>false,
                'message'=>$e
            ]);   
        }
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
        try{ 
            
            $addessUser=UserAddess::find($id)->update([
                'state_name'=>$request->state_name,
                'city_name'=>$request->city_name,
                'city_code'=>$request->city_code,
                'post_code'=>$request->post_code,
                'lanline_phone'=>$request->lanline_phone,
                'addess_phone'=>$request->addess_phone,
                'address'=>$request->address
            ]);   
            if($addessUser){
                return response([
                    'success'=>true
                ]);
            }else{
                return response([
                    'success'=>false
                ]);
            }
        }catch(Exception $e){
            return response([
                'success'=>false,
                'message'=>$e
            ]);   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $userAddess=UserAddess::find($id);
            if(auth('api')->user()->id==$userAddess->user_id){
                $userAddess->delete();
                return response([
                    'success'=>true
                ]);
            }else{
                return response([
                    'success'=>false
                ]);
            }
        }catch(Exception $e){
            return response([
                'success'=>false,
                'message'=>$e
            ]);
        }//end catch
    }
}
