<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    /**
     * @param $request
     * @return Client
     */
    public static function saveClient($request): Client
    {
        $client = new self([
            'name' => $request->name,
            'number' => $request->number,
            'mail' => $request->mail,
            'serial' => $request->serial,
            'passport_number' => $request->passport_number,
            'passport_data' => $request->passport_data,
        ]);

        $client->save();

        return $client;
    }
}
