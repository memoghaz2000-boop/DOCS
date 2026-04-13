<?php

return [
    /*
    |--------------------------------------------------------------------------
    | FMEA Gate State Threshold
    |--------------------------------------------------------------------------
    |
    | This value determines the maximum acceptable Risk Priority Number (RPN)
    | before a project's FMEA Gate State is considered 'Fail'. You can define 
    | this in your .env file or modify the default value here.
    |
    */

    'gate_threshold' => env('FMEA_GATE_THRESHOLD', 150),
];
