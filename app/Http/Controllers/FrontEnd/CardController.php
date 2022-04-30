<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function callBackCardPhone (Request $request){

        try {

            $card = Card::query()->where([
                'tel_code' => $request->telco,
                'code' => $request->code,
                'serial' => $request->serial
            ])->update([
                'amount' => $request->value,
                'actually_received' => $request->amount,
            ]);

            return response()->json($card);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
