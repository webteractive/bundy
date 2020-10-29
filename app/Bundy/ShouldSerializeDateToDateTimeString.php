<?php

namespace App\Bundy;

trait ShouldSerializeDateToDateTimeString
{
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     * TODO: Move to the new handling
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
