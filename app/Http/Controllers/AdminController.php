<?php


namespace App\Http\Controllers;


use App\Services\CancelReservationService;
use App\Services\ListReservationService;
use App\Validators\AdminReservationValidator;
use App\Validators\CancelReservationValidator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminController
{
    /**
     * Cancel reservation endpoint
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reservationCancel(Request $request)
    {
        $data = $request->all();

        $validator = new CancelReservationValidator($data);
        if (!$validator->validate()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->getErrors()
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $status = (new CancelReservationService($data))->cancelReservation();
            $data = CancelReservationValidator::RESERVATION_DELETED_TEXT;
        } catch (\Exception $exception) {
            $status = false;
            $data = [$exception->getMessage(), $exception->getTrace()];
        }

        return response()->json([
            'status' => $status,
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Reservation list for admin user endpoint
     *
     * @param Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reservationList(Request $request, int $id)
    {
        $data = $request->all();
        $data['room_id'] = $id;

        $validator = new AdminReservationValidator($data);
        if (!$validator->validate()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->getErrors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $status = true;
        try {
            $data = (new ListReservationService($data))->getAdminList();
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