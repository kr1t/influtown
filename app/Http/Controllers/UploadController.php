<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function imageUploadPost()

    {

        request()->validate([

            'uploadFileObj' => 'required|image|mimes:jpeg,png,jpg|max:5000',

        ]);



        $imageName = time() . '.' . request()->uploadFileObj->getClientOriginalExtension();



        request()->uploadFileObj->move(public_path('uploads/images'), $imageName);

        $inputName = explode('.', request()->qqfilename);


        return [
            'success' => true,
            'url' => ('/uploads/images/') . $imageName,
        ];
    }
}