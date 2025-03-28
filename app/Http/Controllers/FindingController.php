<?php

namespace App\Http\Controllers;

use App\Models\Finding;
use Illuminate\Http\Request;

class FindingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'modal_content' => view('findings.create')->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'finding_name' => 'required'
        ]);
        Finding::create([
            'name' => $request->get('finding_name'),
            'description' => $request->get('finding_description'),
        ]);
        return back()->with('alert-success', 'Finding successfully ADDED');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Finding  $finding
     * @return \Illuminate\Http\Response
     */
    public function show(Finding $finding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finding  $finding
     * @return \Illuminate\Http\Response
     */
    public function edit(Finding $finding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finding  $finding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Finding $finding)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finding  $finding
     * @return \Illuminate\Http\Response
     */
    public function destroy(Finding $finding)
    {
        //
    }
}
