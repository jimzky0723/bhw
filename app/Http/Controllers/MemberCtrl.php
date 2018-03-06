<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Member;
use App\Payment;

class MemberCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addMember()
    {
        return view('member.add');
    }

    public function saveMember(Request $req)
    {
        $post = $_POST;
        print_r($post);

        $unique = array(
            $req->fname,
            $req->mname,
            $req->lname,
            $req->suffix,
            date('mdY',strtotime($req->dob)),
            $req->gender,
            $req->barangay,
            $req->muncity,
            $req->province
        );
        $post['unique_id'] = implode('',$unique);
        $post['added_by'] = Auth::user()->id;
        $post['date_added'] = date('Y-m-d H:i:s');
        $post['url_prof'] = self::uploadPicture($_FILES['prof_pic'],$post['unique_id'],'pictures');
        $post['url_sig'] = self::uploadPicture($_FILES['signature'],$post['unique_id'],'signatures');

        unset($post['amount1']);
        unset($post['OR_no1']);
        unset($post['payment_date1']);
        unset($post['amount2']);
        unset($post['OR_no2']);
        unset($post['payment_date2']);

        foreach($post as $key => $value)
        {
            $dataKey[] = $key;
            $dataVal[] = $value;
            if($value){
                $duplicate[] = "$key = '$value'";
            }
        }

        $key = implode(",",$dataKey);
        $value = implode("','",$dataVal);
        $tmp = implode(",",$duplicate);
        $q = "INSERT INTO member ($key) VALUES ('$value') ON DUPLICATE KEY UPDATE $tmp";
        DB::select($q);

        $member_id = Member::where('unique_id',$post['unique_id'])->first()->id;

        DB::table('payment')->insert([
            [
                'member_id' => $member_id,
                'payment_code' => 'registration',
                'amount' => $req->amount1,
                'OR_No' => $req->OR_no1,
                'year' => date('Y'),
                'payment_date' => $req->payment_date1,
                'added_by' => $post['added_by'],
                'date_added' => date('Y-m-d H:i:s')
            ],
            [
                'member_id' => $member_id,
                'payment_code' => 'annual',
                'amount' => $req->amount2,
                'OR_No' => $req->OR_no2,
                'year' => date('Y'),
                'payment_date' => $req->payment_date2,
                'added_by' => $post['added_by'],
                'date_added' => date('Y-m-d H:i:s')
            ],
        ]);

        return redirect()->back()->with('status','added');

    }

    function uploadPicture($file,$name,$type)
    {
        $path = public_path('upload/'.$type);
        $size = getimagesize($file['tmp_name']);
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_name = $name.'.'.$ext;
        if($size==FALSE){
            $name = 'default.png';
        }else{
            //create thumb
            $src = $path.'/'.$new_name;
            $dest = $path.'/'.$new_name;
            $desired_width = 370;
            if($type==='signatures')
            {
                $desired_width = 370;
            }
            //move uploaded file to a directory
            move_uploaded_file($file['tmp_name'],$path.'/'.$new_name);
            //$this->make_thumb($src, $dest, $desired_width,$ext);
            $new_ext = self::resize($desired_width,$dest,$src);
            $name = $name.'.'.$new_ext;
        }
        return $name;
    }

    function resize($newWidth, $targetFile, $originalFile) {

        $info = getimagesize($originalFile);
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                $new_name = $targetFile;
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                $new_name = $targetFile.'.'.$new_image_ext;
                break;

            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                break;

            default:
                throw new Exception('Unknown image type.');
        }

        $img = $image_create_func($originalFile);
        list($width, $height) = getimagesize($originalFile);

        $newHeight = ($height / $width) * $newWidth;
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        $image_save_func($tmp, "$new_name");
        if (file_exists($new_name)&& $new_image_ext=='png') {

            unlink($new_name);
        }


        return $new_image_ext;
    }

    public function listMember()
    {
        $data['records'] = Member::orderBy('lname','asc')
                    ->paginate(20);
        return view('member.index',$data);
    }

    public function editMember($id){
        $info = Member::where('id',$id)->first();
        return view('member.edit',['data' => $info]);
    }

    public function updateMember(Request $req,$id)
    {
        $data = $_POST;
        $unique_id = Member::where('id',$id)->first()->unique_id;

        if($_FILES['prof_pic']['name']){
            $data['url_prof'] = self::uploadPicture($_FILES['prof_pic'],$unique_id,'pictures');
        }
        if($_FILES['signature']['name']){
            $data['url_sig'] = self::uploadPicture($_FILES['signature'],$unique_id,'signatures');
        }
        Member::where('id',$id)
            ->update($data);
        return back()->with('status','success');
    }

    public function deleteMember($id)
    {
        Member::where('id',$id)
            ->delete();
        return redirect('member/list')->with('status','deleted');
    }
}
