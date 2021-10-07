<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Author;
use App\Rules\UperCase;
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $Blog=DB::table('blogs')->join('authors','authors.id','=','blogs.Author_id')->get();
        if ($Blog){
            return ['result',$Blog];
        }
        else{
            return ['error','something went wrong'];
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation=Validator::make($request->all(),[
            "title"=>['required',new UperCase],
            "description"=>'required',
            "image"=>"required"

        ]);
        if ($validation->fails()){
            return ['error',$validation->errors()];
        }
        //
        $image=$request->file('image')->store('public/blog');
        $blog=new Blog;
        $blog->title=$request->title;
        $blog->description=$request->description;
        $blog->image=$request->file('image')->hashName();
        $blog->author_id=$request->author_id;
       $result= $blog->save();
       if ($result){
           return ['success','Blog added successfully'];
       }
       else{
           return ['error','Blog do not add try again'];

       }
    }

    public function show($id)
    {
        //
        $blog=Blog::find($id);
        if($blog){
            $response=['result',$blog];
            return $response;
        }
        else{
            return ['error','do not show'];
        }
    }



  public function updateBlog(Request $request){
      $validation=Validator::make($request->all(),[
          "title"=>'required|unique:blogs',
          "description"=>'required',
//          "image"=>"required"

      ]);
      if ($validation->fails()){
          return ['error',$validation->errors()];
      }
        $blog=Blog::find($request->id);
        $blog->title=$request->title;
        $blog->description=$request->description;
      $result=  $blog->save();
if ($result){
    return ['result','Blog updated'];
}
else{
    return ['error','Blog not updated'];

}
  }

    public function destroy(Request $request ,$id)
    {
        //
        $blog=Blog::find($id);
        $result= $blog->delete();
        if ($result){
            return ['result','deleted'];
        }
        else{
            return ['error','something went wrong'];
        }
    }
    public function search($name){
        $result=DB::table('blogs')->where('title','like','%'.$name.'%')->get();
        if ($result){
            return ['result',$result];
        }
        else{
            return ['error','search do not match'];
        }
    }
}
