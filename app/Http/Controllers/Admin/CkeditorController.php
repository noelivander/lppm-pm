<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CkeditorController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileNameAs = $fileName.'_'.time().'.'.$extension;
        
            $request->file('upload')->storeAs(
                        'images/', $fileNameAs, ['disk' => 'public']
                    );
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/images/' . $fileNameAs);
            $msg = 'Image '.$fileName.' uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
            exit;
        }
    }
}
