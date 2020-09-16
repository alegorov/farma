<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/notifications",
     *     summary="Get list of notifications",
     *     tags={"Notifications"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     * )
     */
    public function index()
    {
        $items = Notification::select('id', 'created_at', 'updated_at')
            ->orderBy('id')->get()->all();

        return response()->json($items);
    }

    /**
     * @OA\Post(
     *     path="/notifications",
     *     summary="Create notification",
     *     tags={"Notifications"},
     *     description="Create notification",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Notification id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="json_data",
     *         in="query",
     *         description="Notification JSON string",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     * )
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $json_data = $request->json_data;

        Notification::create(compact('id', 'json_data'));

        return response()->json(['status' => 'OK']);
    }

    /**
     * @OA\Get(
     *     path="/notifications/{notification_id}",
     *     summary="Get notification by id",
     *     tags={"Notifications"},
     *     description="Get notification by id",
     *     @OA\Parameter(
     *         name="notification_id",
     *         in="path",
     *         description="Notification id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Notification is not found",
     *     )
     * )
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
     * @OA\Put(
     *     path="/notifications/{notification_id}",
     *     summary="Update notification by id",
     *     tags={"Notifications"},
     *     description="Update notification by id",
     *     @OA\Parameter(
     *         name="notification_id",
     *         in="path",
     *         description="Notification id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="json_data",
     *         in="query",
     *         description="Notification JSON string",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Notification is not found",
     *     )
     * )
     */
    public function update(Request $request, Notification $notification)
    {
        $json_data = $request->json_data;

        $notification->update(compact('json_data'));

        return response()->json(['status' => 'OK']);
    }

    /**
     * @OA\Delete(
     *     path="/notifications/{notification_id}",
     *     summary="Delete notification by id",
     *     tags={"Notifications"},
     *     description="Delete notification by id",
     *     @OA\Parameter(
     *         name="notification_id",
     *         in="path",
     *         description="Notification id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Notification is not found",
     *     )
     * )
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return response()->json(['status' => 'OK']);
    }
}
