<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\CalculatorService;

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

        return response()->json([
            'result' => $return['result'],
            'message' => $return['message'],
        ], $return['status']);
    }
}
