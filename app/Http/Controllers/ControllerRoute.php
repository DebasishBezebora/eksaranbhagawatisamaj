<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\site_settings;
use App\Models\links;
use App\Models\photo_gallery;

class ControllerRoute extends Controller
{
    //
    public function home()
    {
        $bg_pic = array("959333c57f676fc701fda0817a8a7eaf.jpg", "fcfbfcbc52a1d8163d55b738614c5b1d.jpg");
        $random_pic = array_rand($bg_pic, 1);
        $bgPic = $bg_pic[$random_pic];

        $photos = DB::table('photo_galleries')
            ->select(DB::raw('GROUP_CONCAT(`Photos`) as Photos'))
            ->whereIn('ID', [3, 7, 8])
            ->first();
        $dataPhotos = compact('photos');

        // var_dump($dataPhotos);

        $siteSettings = site_settings::where('Active', '=', 1)->first();
        $dataSitesettings = compact('siteSettings');

        $res = array("SliderPic" => $bgPic);
        $finalRes = array_merge($res, $dataSitesettings, $dataPhotos);
        return view('home', $finalRes);
    }

    // links

    public function program()
    {
        $siteSettings = site_settings::where('Active', '=', 1)->first();
        $siteLink = links::where('Active', '=', 1)->first();
        $dataSitesettings = compact('siteSettings');
        $dataSitelink = compact('siteLink');
        $finalRes = array_merge($dataSitesettings, $dataSitelink);
        return view('content', $finalRes);
    }

    // photos

    public function gallery()
    {
        $siteSettings = site_settings::where('Active', '=', 1)->first();
        $siteGlimpse = photo_gallery::all();
        $dataSitesettings = compact('siteSettings');
        $link = compact('siteGlimpse');
        $finalRes = array_merge($dataSitesettings, $link);
        return view('gallery', $finalRes);
    }

    // photos

    public function photographs($id)
    {
        $siteSettings = site_settings::where('Active', '=', 1)->first();
        $siteGlimpse = photo_gallery::where('ID', '=', $id)->first();
        $dataSitesettings = compact('siteSettings');
        $link = compact('siteGlimpse');
        $finalRes = array_merge($dataSitesettings, $link);
        return view('galleries', $finalRes);
    }
}
