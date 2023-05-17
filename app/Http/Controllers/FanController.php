<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Models\Fan;
use Carbon\Carbon;
use Exception;

class FanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fans = Fan::all();

        if ($fans) {
            return ApiFormatter::createAPI(200, 'success', $fans);
        }else{
            return ApiFormatter::createAPI(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createToken()
    {
        return csrf_token();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|min:3',
                'age' => 'required|numeric',
                'email' => 'required',
                'phone'=>'required|numeric',
                'date' => 'required',
                'category' => 'required',
            ]);

            $fans = Fan::create([
                'name' => $request->name,
                'age' => $request->age,
                'email' => $request->email,
                'phone'=> $request->phone,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'category' => $request->category,
            ]);

            $dataSaved = Fan::where('id', $fans->id)->first();

            if ($dataSaved) {
                return ApiFormatter::createAPI(200, 'success', $dataSaved);
            }else{
                return ApiFormatter::createAPI(400, 'failed');
            }

        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error',$error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $ticket = Fan::find($id);
        if ($ticket) {
            return ApiFormatter::createAPI(200, 'success', $ticket);
        }else{
            return ApiFormatter::createAPI(400, 'failed');
        }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
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
        try {
            $request->validate([
                'name' => 'required|min:3',
                'age' => 'required|numeric',
                'email' => 'required',
                'phone'=>'required|numeric',
                'date' => 'required',
                'category' => 'required',
            ]);

            $fan = Fan::find($id);

            $fan->update([
                'name' => $request->name,
                'age' => $request->age,
                'email' => $request->email,
                'phone'=> $request->phone,
                'date' => Carbon::parse($request->date)->format('Y-m-d'),
                'category' => $request->category,
            ]);

            $updated = Fan::where('id', $fan->id)->first();

            if ($updated) {
                return ApiFormatter::createAPI(200, 'success', $updated);
            }else{
                return ApiFormatter::createAPI(400, 'failed');
            }
            
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $fan = Fan::find($id);
            $deleted = $fan->delete();

            if ($deleted) {
                return ApiFormatter::createAPI(200, 'success', 'Deleted Succeed');
            }else{
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function trash(){

        try {
            $trash = Fan::onlyTrashed()->get();
            if ($trash) {
                return ApiFormatter::createAPI(200, 'success', $trash);
            }else{
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }
    }

    public function restore($id){
        try {
            $fan = Fan::onlyTrashed()->where('id', $id);
            $fan->restore();
            $restored = Fan::where('id', $id)->first();

            if ($restored) {
                return ApiFormatter::createAPI(200, 'success', $restored);
            }else{
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());
        }

    }

    public function permanentDelete($id){
        try {
            $fan = Fan::onlyTrashed()->where('id', $id);
            $deleted = $fan->forceDelete();

            if($deleted){
                return ApiFormatter::createAPI(200, 'success', $deleted);
            }else{
                return ApiFormatter::createAPI(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createAPI(400, 'error', $error->getMessage());

        }
    }
}
