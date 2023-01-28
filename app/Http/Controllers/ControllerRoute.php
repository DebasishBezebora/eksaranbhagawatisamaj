<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerRoute extends Controller
{
    //
    public function home()
    {
        $bg_pic = array("959333c57f676fc701fda0817a8a7eaf.jpg", "fcfbfcbc52a1d8163d55b738614c5b1d.jpg");
        $random_pic = array_rand($bg_pic, 1);
        $bgPic = $bg_pic[$random_pic];
        $res = array("SliderPic" => $bgPic);
        return view('home', $res);
    }
    //
    public function program()
    {
        $res = array("breadcrumb" => "কার্যসূচী");
        return view('content', $res);
    }
}
