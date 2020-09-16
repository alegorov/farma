<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items = Notification::select('id', 'created_at', 'updated_at')
            ->orderBy('id')->get()->all();

        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $json_data = $request->json_data;

        Notification::create(compact('id', 'json_data'));

        return response()->json(['status' => 'OK']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Notification $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Notification $notification)
    {
        $id = $notification->id;
        $json_data = json_decode($notification->json_data);
        $created_at = $notification->created_at;
        $updated_at = $notification->updated_at;

        return response()->json(
            compact(
                'id',
                'json_data',
                'created_at',
                'updated_at'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Notification $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Notification $notification)
    {
        $json_data = $request->json_data;

        $notification->update(compact('json_data'));

        return response()->json(['status' => 'OK']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Notification $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return response()->json(['status' => 'OK']);
    }
}
