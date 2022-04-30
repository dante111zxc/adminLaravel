<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Card extends Model
{
    use HasFactory;
    public static $api_charge_card_money = 'https://naptudong.com/chargingws/v2';
    public static $partner_id = 6966361361;
    public static $partner_key = '9f0ce4c4e378b38b684864b61dfa0cc5';
    protected $table = 'card';


    protected $fillable = [
        'user_id',
        'tel_code',
        'code',
        'serial',
        'amount',
        'actually_received',
        'request_id',
        'status',
        'card_status',
        'note'
    ];


    public static function createCard ($request, $requestId, $status){
        try {
            $transaction = Card::query()->create([
                'user_id' => (Auth::check()) ? Auth::user()->id : 0,
                'tel_code' => $request['card_type'],
                'code' => $request['card_code'],
                'serial' => $request['card_serial'],
                'amount' => $request['card_price'],
                'request_id' => $requestId,
                'note' => 'Nạp Pcoin bằng thẻ ' . $request['card_type'],
                'status' => $status,
            ]);
            return $transaction;
        } catch (\Exception $exception) {

            return false;
        }
    }
    public static function chargingCard ($dataForm){
        try {
            $client = new Client();
            $response = $client->request('POST', self::$api_charge_card_money , ['form_params' => $dataForm]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            return false;
        }
    }
    public static function moneyToPcoin ($money){
        $feeTransaction = (25 * $money) / 100;
        $pcoin = $money - $feeTransaction;
        $user = User::query()->find(Auth::user()->id);
        $userPcoin = $user->pcoin + $pcoin;
        $user->fill(['pcoin' => $userPcoin]);
        return $user->save();
    }
    public static function checkCard ($dataForm) {
        try {
            $client = new Client();
            $response = $client->request('POST', self::$api_charge_card_money, ['form_params' => $dataForm]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $exception) {
            return false;
        }
    }

}
