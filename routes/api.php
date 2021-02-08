<?php

use App\Models\Request as RequestModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::match(['get', 'post'], '/ping', function (Request $request) {
    return response()->json(['status_code' => Response::HTTP_OK, 'message' => 'OK']);
});

//api/initiate
Route::post('/initiate', function (Request $request) {

    $model = RequestModel::create(['request_datetime' => now()]);
    return response()->json(['data' => $model, 'status_code' => Response::HTTP_CREATED]);
});

Route::post('/callback/send/{request_id}', function ($requestId, Request $request) {

    try {

        $requestData = [
            'payload' => $request->all(),
            'request_headers' => $request->header(),
            'received_datetime' => now(),
            'received' => true,
        ];

        $requestModel = RequestModel::where('request_id', $requestId)
            ->firstOrFail();

        $requestModel->update($requestData);

        $requestModel->payloadHistories()->create(
            array_merge($requestData, [
                'request_id' => $requestId,
                'request_datetime' => $requestModel->request_datetime,
            ])
        );

        Log::debug(json_encode($request->all()));

    } catch (ModelNotFoundException $e) {

        return "FAIL";
    }

})
    ->name('callback.url');

//@TODO protect with throttle
Route::post('/verify', function (Request $request) {

    try {

        Validator::make($request->all(), ['request_id' => 'required'])
            ->validate();

        $requestModel = RequestModel::where('request_id', $request->request_id)->firstOrFail();

        return response()->json(['data' => $requestModel, 'status_code' => Response::HTTP_OK]);

    } catch (ValidationException | Exception $e) {

        return response()->json([
            'status_code' => Response::HTTP_BAD_REQUEST, 'message' => 'Missing required fields.',
        ]);

    }
});
