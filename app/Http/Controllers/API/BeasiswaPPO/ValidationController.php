<?php

namespace App\Http\Controllers\API\BeasiswaPPO;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidationController extends Controller
{
    public function check_validation(Request $request)
    {
        try {
            $applicants = Applicant::where($request->field, $request->value)->get();
            if (count($applicants) > 0) {
                $users = User::where($request->field, $request->value)->get();
                if (count($users) > 0) {
                    return response()->json([
                        'data' => [
                            'name' => $applicants[0]->name,
                            'email' => $applicants[0]->email,
                            'phone' => $applicants[0]->phone,
                        ],
                        'message' => 'Account found in users and applicant.',
                        'create' => false
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'data' => [
                            'name' => $applicants[0]->name,
                            'email' => $applicants[0]->email,
                            'phone' => $applicants[0]->phone,
                        ],
                        'message' => 'Account found in applicant only.',
                        'create' => true
                    ], Response::HTTP_NOT_FOUND);
                }
            } else {
                $users = User::where($request->field, $request->value)->get();
                if (count($users) > 0) {
                    return response()->json([
                        'data' => [
                            'name' => $users[0]->name,
                            'email' => $users[0]->email,
                            'phone' => $users[0]->phone,
                        ],
                        'message' => 'Account found in users and applicant. ada di user',
                        'create' => false
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'data' => null,
                        'message' => 'Account not found in users and applicant.ss',
                        'create' => true
                    ], Response::HTTP_NOT_FOUND);
                }
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), $th->getCode());
        }
    }
}
