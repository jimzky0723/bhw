<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;

use App\Http\Requests;

class GenerateCtrl extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generateID($id){
        $data = Member::where('id',$id)->first();
        $mname = isset($data->mname) ? $data->mname[0] : '';
        $name = $data->fname.' '.$mname.'. '.$data->lname.' '.$data->suffix;
        $path = public_path('upload/pictures/');
        $prof_pic = $path.''.$data->url_prof;
        $user = array(
            array(
                'name'=> $name,
                'font-size'=>'27',
                'color'=>'grey'
            ),

            array(
                'name'=> 'Barangay Health Worker',
                'font-size'=>'25',
                'color'=>'white'
            ),

            array(
                'name'=> str_pad($data->id, 4, '0', STR_PAD_LEFT),
                'font-size'=>'23',
                'color'=>'white'
            ),
            array(
                'picture' => $prof_pic,
                'filename' => $data->unique_id
            )

        );
        $file = $this->create_image($user);
        return $file;
    }


    function create_image($user){
        $fontname = base_path('resources/assets/fonts/Capriola-Regular.ttf');
        $quality = 100;
        $i = 300;
        $file = public_path('upload/final/'.$user['3']['filename'].".jpg");
        $url = asset('public/upload/final/'.$user['3']['filename'].".jpg");

        // if the file already exists dont create it again just serve up the original
        //if (!file_exists($file)) {


        // define the base image that we lay our text on
        $prof_pic = $user[3]['picture'];
        $raw = $path = public_path('upload/raw.jpg');
        $im = imagecreatefromjpeg($raw);

        // setup profile picture
        $condition = GetImageSize($prof_pic);
        $format = $condition[2];
        if($format==1)
            $im2 = imagecreatefromgif($prof_pic);
        if($format==2)
            $im2 = imagecreatefromjpeg($prof_pic);
        if($format==3)
            $im2 = imagecreatefrompng($prof_pic);


        // setup the text colours
        $color['grey'] = imagecolorallocate($im, 54, 56, 60);
        $color['green'] = imagecolorallocate($im, 55, 189, 102);
        $color['white'] = imagecolorallocate($im, 255, 255, 255);

        // this defines the starting height for the text block

        $y = imagesy($im) - 365;

        $pos = $user[1];
        $x = self::center_text($fontname, $pos['name'], $pos['font-size']);
        imagettftext($im, $pos['font-size'], 0, $x, $i, $color[$pos['color']], $fontname,$pos['name']);
        $i+=500;

        $value = $user[0];
        $x = self::center_text($fontname,$value['name'], $value['font-size']);
        imagettftext($im, $value['font-size'], 0, $x, $i, $color[$value['color']], $fontname,$value['name']);
        $i+=70;

        $idNo = $user[2];
        $x = self::center_text($fontname, $idNo['name'], $idNo['font-size']);
        imagettftext($im, $idNo['font-size'], 0, $x, $i, $color[$idNo['color']], $fontname,$idNo['name']);


        // create the image

        imagecopy($im, $im2, (imagesx($im)/2)-(imagesx($im2)/2), (imagesy($im)/2)-(imagesy($im2)/2)+17, 0, 0, imagesx($im2), imagesy($im2));
        imagejpeg($im, $file, $quality);

        return $url;
    }

    function center_text($fontname,$string, $font_size){


        $image_width = 638;
        $dimensions = imagettfbbox($font_size, 0, $fontname, $string);

        return ceil(($image_width - $dimensions[4]) / 2);
    }

}
