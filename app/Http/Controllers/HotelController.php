<?php


namespace App\Http\Controllers;


use App\Services\AddReservationService;
use App\Services\ListReservationService;
use App\Validators\AddReservationValidator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class HotelController extends BaseController
{

    public function reservation(Request $request)
    {
        $data = $request->all();

        $validator = new AddReservationValidator($data);
        if (!$validator->validate()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->getErrors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $errors = [];
        $status = true;
        $reservation = null;
        try {
            $service = new AddReservationService($data);
            $reservation = $service->makeReservation();
        } catch (\Exception $exception) {
            $status = false;
            $errors[] = $exception->getMessage();
        }

        return response()->json([
            'status' => $status,
            'errors' => $errors,
            'reservation_id' => $reservation
        ], Response::HTTP_OK);
    }

    public function reservationList(Request $request, int $id)
    {
        $data = $request->all();
        $data['room_id'] = $id;

        $status = true;
        try {
            $data = (new ListReservationService($data))->getList();
        } catch (\Exception $exception) {
            $status = false;
            $data = [$exception->getMessage(), $exception->getTrace()];
        }

        return response()->json([
            'status' => $status,
            'data' => $data
        ]);
    }

}