<?php

namespace App\Http\Controllers;

use App\EuromillionsDraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EuromillionsDrawController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getResult(Request $request){
        if ($request->isJson()) {

            $euromillions = Cache::remember('usersTable', 1, function() {
                return EuromillionsDraw::all()->first();
            });

            if ($euromillions){

                $results = [
                    $euromillions->result_regular_number_one,
                    $euromillions->result_regular_number_two,
                    $euromillions->result_regular_number_three,
                    $euromillions->result_regular_number_four,
                    $euromillions->result_regular_number_five,
                    $euromillions->result_lucky_number_one,
                    $euromillions->result_lucky_number_two,
                ];

                $result = implode(",",$results);

                $data = [
                    "error"     => 0,
                    "draw"      => $euromillions->draw_date,
                    "results"   => $result
                ];

                return response()->json($data, 201);

            } else {
                return response()->json(['error' => 'User found'], 401, []);
            }

        } else {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }
}
