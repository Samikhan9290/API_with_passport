<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WebsiteController extends Controller
{
    //
    public function index(){
        $data=['name'=>'sami','data'=>'hello sami'];
        $user['to']='salmann39000@gmail.com';
        Mail::send('mail',$data,function ($messages) use ($user){
            $messages->to($user['to']);
            $messages->subject('hello dev');
        });
    }
}
