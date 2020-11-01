<?php

namespace App\Bundy;

class Toast
{
    public static function make($message, $type = 'success')
    {
        return [
            'toast' => [
                'type' => $type,
                'message' => $message
            ]
        ];
    }

    public static function flash($message, $type = 'success')
    {
        session()->flash('toast', [
            'type' => $type,
            'message' => $message
        ]);
    }

    public static function parseAndFlash($payload)
    {
        if (! is_null($payload)) {
            $toast = $payload['toast'];
            self::flash($toast['message'], $toast['type']);
        }
    }
}