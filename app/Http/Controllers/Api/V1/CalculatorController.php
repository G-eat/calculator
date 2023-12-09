<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\CalculatorService;
use App\Models\CalculatorHistory;

class CalculatorController extends Controller
{
    private $calculatorService;

    public function __construct(CalculatorService $calculatorService)
    {
        $this->calculatorService = $calculatorService;
    }

    public function calculate(Request $request) : JsonResponse 
    {
        $input = $request->input;

        $return = $this->calculatorService->evaluateExpression($input);

        /* add history to db */
        $this->addHistoryToDb($input, $return);

        return response()->json([
            'result' => $return['result'],
            'message' => $return['message'],
        ], $return['status']);
    }

    private function addHistoryToDb($input, $return)
    {
        // only if is valid
        if($return['status'] == 200) 
        {
            CalculatorHistory::create([
                'user_id'   => auth()->id(),
                'result'    => $input . ' = ' . $return['result']
            ]);
        }
    }


    public function calculatorHistory() : JsonResponse 
    {
        $history = CalculatorHistory::select('user_id','result','created_at')->where('user_id',auth()->id())->orderBy('created_at','desc')->paginate(1);

        return response()->json([
            'calculatorHistory' => $history
        ], 200);
    }
}
