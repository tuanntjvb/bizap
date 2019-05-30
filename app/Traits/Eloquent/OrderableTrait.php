<?php

namespace App\Traits\Eloquent;

use App\Utils;
use Carbon\Carbon;

trait OrderableTrait
{
    public function scopeLatestFirst($query)
    {
        return $query->orderBy(CREATED_AT, 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCreatedToday($query)
    {
        $today = Carbon::now(Utils::getTz())->startOfDay()->timezone(UTC);
        return $query->where(CREATED_AT, '>=', $today->format(DATE_TIME_FORMAT));
    }

    /**
     * @param $query
     * @param $from
     * @param $to
     * @param string $format
     * @return mixed
     */
    public function scopeCreatedRange($query, $from, $to, $format = null)
    {
        $format = $format ? $format : DATE_FORMAT;

        if (!empty($from)) {
            $from = Carbon::createFromFormat($format, $from, Utils::getTz())->startOfDay()->timezone('UTC');
        }

        if (!empty($to)) {
            $to = Carbon::createFromFormat($format, $to, Utils::getTz())->endOfDay()->timezone('UTC');
        }

        if (!empty($from) && !empty($to)) {
            return $query->whereBetween(CREATED_AT, [
                $from->format(DATE_TIME_FORMAT),
                $to->format(DATE_TIME_FORMAT)
            ]);
        } else {
            if (!empty($from)) {
                $query = $query->where(CREATED_AT, '>=', $from->format(DATE_TIME_FORMAT));
            }

            if (!empty($to)) {
                $query = $query->where(CREATED_AT, '<=', $to->format(DATE_TIME_FORMAT));
            }
        }

        return $query;
    }
}
