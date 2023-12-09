<?php


namespace App\Services;


class CalculatorService
{
    public function evaluateExpression($string) 
    {
        // pattern to allow only numbers and . + - * /  ( ) operations and add more security
        $pattern = '/^[\d\s\.\(\)\+\-\*\/]+$/';
    
        if (preg_match($pattern, $string)) {
            try {
                $math_string ="return (".$string.");";
                $result = eval($math_string);
            } catch (\ParseError  $e) {
                return $this->returnFormat('Error', 'Syntax error' , 400);
            }
            
            return $this->returnFormat($result, 'Success', 200);
        } else {
            return $this->returnFormat('Error', 'Invalid characters in input', 400);
        }
    }

    private function returnFormat($result, $message, $statusCode)
    {
        return [
            'result'    => $result, 
            'message'   => $message, 
            'status'    => $statusCode
        ];
    }
}
