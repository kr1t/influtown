<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Influencer;
use App\Report;
use App\User;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Report::with('influencer.user')->with('user')->whereStatus(0)->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $req = $request->all();


        $i = Report::create($req);
        foreach ($request->image_urls as $img) {
            $i->images()->create([
                "image_url"
                => $img
            ]);
        }

        return ['status' => true];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $influencer = Influencer::find($id);
        if (!$influencer) {
            return [
                "status" => "failed"
            ];
        }

        $user =  User::where('line_user_id', $request->line_user_id)->first();

        $influencer->user;
        return [
            "status" => "success",
            "influencer" =>  $influencer,
            "user" => $user

        ];
    }

    public function update($id, Request $request)
    {
        $report = Report::find($id);
        $report->update([
            'status' => 1
        ]);

        return $report;
    }
}