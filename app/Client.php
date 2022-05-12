<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client extends Model
{
    protected $guarded = [];

    /**
     * @param $request
     * @return Client
     */
    public static function saveClient($request): Client
    {
        $initials = '';
        $initialsArray = explode(' ', $request->name);
        foreach ($initialsArray as $key => $item) {
            $initials .= Str::upper(mb_substr($item, 0, 1));
            if (!(array_key_last($initialsArray) == $key)) {
                $initials .= '.';
            }
        }

        $client = new Client([
            'name' => $request->name,
            'initials' => $initials,
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
