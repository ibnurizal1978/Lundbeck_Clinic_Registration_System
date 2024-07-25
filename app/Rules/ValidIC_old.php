<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidIC implements Rule
{
    public $status;
    public $fl_nric;
    public $cl_nric;
    public $l4_nric;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($status = '', $fl_nric, $cl_nric, $l4_nric)
    {
        $this->status   = $status;
        $this->fl_nric  = $fl_nric;
        $this->cl_nric  = $cl_nric;
        $this->l4_nric  = $l4_nric;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->status != 'new') {
            return true;
        }

        $check_nric = DB::table('patients')->where('nric', 'like', '%' . $this->fl_nric . $this->cl_nric . $this->l4_nric . '%')->get();
        if ($check_nric->isEmpty()) {
            return true;
        } else {
            return false;
        }
        // $number = $value;

        // if (strlen($number) !== 9) {
        //     return false;
        // }
        // $newNumber = strtoupper($number);
        // $icArray = [];
        // for ($i = 0; $i < 9; $i++) {
        //     $icArray[$i] = $newNumber[$i];
        // }
        // $icArray[1] = intval($icArray[1], 10) * 2;
        // $icArray[2] = intval($icArray[2], 10) * 7;
        // $icArray[3] = intval($icArray[3], 10) * 6;
        // $icArray[4] = intval($icArray[4], 10) * 5;
        // $icArray[5] = intval($icArray[5], 10) * 4;
        // $icArray[6] = intval($icArray[6], 10) * 3;
        // $icArray[7] = intval($icArray[7], 10) * 2;

        // $weight = 0;
        // for ($i = 1; $i < 8; $i++) {
        //     $weight += $icArray[$i];
        // }
        // $offset = ($icArray[0] === "T" || $icArray[0] == "G") ? 4 : 0;
        // $temp = ($offset + $weight) % 11;

        // $st = ["J", "Z", "I", "H", "G", "F", "E", "D", "C", "B", "A"];
        // $fg = ["X", "W", "U", "T", "R", "Q", "P", "N", "M", "L", "K"];

        // $theAlpha = "";
        // if ($icArray[0] == "S" || $icArray[0] == "T") {
        //     $theAlpha = $st[$temp];
        // } else if ($icArray[0] == "F" || $icArray[0] == "G") {
        //     $theAlpha = $fg[$temp];
        // }

        // return ($icArray[8]==$theAlpha);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User with this nric already registered.';
        // return 'The nric is not valid.';
    }
}
