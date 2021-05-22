<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ApiProductCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt_token',['except' => ['show']]);   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
            $authUser=auth('api')->user();
            $product=Product::find($request->product_id);
            $product->comment()->create([
                'user_id'=>$authUser->id,
                'comment'=>$request->comment
            ]);
            return response([
                'success'=>true
            ]);
        }catch(Exception $e){
            return response([
                'success'=>false
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
        $product=Product::findOrFail($id);
        $comments=[];
        foreach($product->comment as $productComment){
            $comment_item['productComment']=$productComment;
            $comment_item['userInfo']=User::find($productComment->user_id);
            $comments[]=$comment_item;
        }
        return response($comments);
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
        //
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
            $productComment=ProductComment::find($id);
            $authUserId=auth('api')->user()->id;
            if($authUserId==$productComment->user_id){
                $productComment->delete();
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
                'success'=>false
            ]);
        }
    }
}
