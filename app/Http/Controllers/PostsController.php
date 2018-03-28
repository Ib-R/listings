<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return View('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_img'=>'image|nullable|max:1999'
        ]);

        //handle file upload

        if($request->hasFile('cover_img')){

            //Get filename with the extension
            $fileNameWithExt = $request->file('cover_img')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extention = $request->file('cover_img')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extention;
            //Upload File
            $path = $request->file('cover_img')->storeAs('public/cover_imgs', $fileNameToStore);

        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        //create post
        $post = new Post;
        $post->user_id = Auth()->user()->id;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_img = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success','Post Created Successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return View('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //check for the correct user

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Access');
        }

        return View('posts.edit')->with('post',$post);
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
        $post = Post::find($id);
        //check for the correct user

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Access');
        }
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required'
        ]);

        // //handle file upload

        if($request->hasFile('cover_img')){

            //Get filename with the extension
            $fileNameWithExt = $request->file('cover_img')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extention = $request->file('cover_img')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extention;
            //Upload File
            $path = $request->file('cover_img')->storeAs('public/cover_imgs', $fileNameToStore);

        }

        //create post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_img')){
            $post->cover_img = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success','Post Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        //check for the correct user

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Access');
        }

        //Delete file if it's not the default

        if($post->cover_img != 'noimage.jpg' ){
            Storage::delete('public/cover_imgs/'.$post->cover_img);
        }

        $post->delete();
        return redirect('/posts')->with('success','Post Deleted Successfully!');

    }
}
