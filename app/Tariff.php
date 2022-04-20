<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $guarded = [];

    public $another;


    /**
     * @param $request
     * @return array
     */
    public static function prepareObject($request): array
    {
        $attributes = [];
        $json = [];
        $elems = $request->all();
        unset($elems['_token']);

        foreach ($elems as $key => $elem) {
            if (str_contains($key, 'json-name-')) {
                $json[$elem] = [
                    'name' => $elem
                ];
                $elemKey = $elem;
            } elseif (str_contains($key, 'json-price-')) {
                $json[$elemKey]['price'] = $elem;
            } else {
                $attributes[$key] = $elem;
            }
        }

        $attributes['another'] = json_encode($json);

        return $attributes;
    }
}
