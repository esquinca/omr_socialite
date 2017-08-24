<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('home');
    }
    public function indexpolicies()
    {
         return view('termsofuse');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('submitx');
    }

     public function submit(Request $request)
     {
      $email = $request->email_addess;
      $sip = $request->sip;
      $mac = $request->mac;
      $client_mac = $request->client_mac;
      $uip = $request->uip;
      $ssid = $request->ssid;
      $vlan = $request->vlan;

      $res = DB::table('email_h10omr')->insert(['email' => $email]);

      return redirect('submitx');
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $email = $request->email_addess;
      // $sip = $request->sip;
      // $mac = $request->mac;
      // $client_mac = $request->client_mac;
      // $uip = $request->uip;
      // $ssid = $request->ssid;
      // $vlan = $request->vlan;

      $res = DB::table('email_h10omr')->insert(['email' => $email, 'created_at' => date('Y-m-d H:i:s')]);

      return "OK";
    }

    public function pagenotfound()
    {
        return view('errors.pagenotfound');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
