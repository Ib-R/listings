<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Validator;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return response()->json($items);
    }

    public function api()
    {
        return \File::get(public_path() . '\frontend\index.html');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required'
        ]);

        if($validator->fails()){
            $response = array('response'=> $validator->messages(), 'success' => false);
            return $response;
        } else {
            // create item
            $item = new Item;
            $item->title = $request->input('title');
            $item->body = $request->input('body');
            $item->save();

            return response()->json($item);

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
        $item = Item::find($id);
        return response()->json($item);
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
        $validator = Validator::make($request->all(),[
            'title' => 'required'
        ]);

        if($validator->fails()){
            $response = array('response'=> $validator->messages(), 'success' => false);
            return $response;
        } else {
            // find an item
            $item = Item::find($id);
            $item->title = $request->input('title');
            $item->body = $request->input('body');
            $item->save();

            return response()->json($item);

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
        $item = Item::find($id);
        $item->delete();

        $response = array('response'=> 'Item Deleted', 'success' => true);
            return $response;
    }
}
