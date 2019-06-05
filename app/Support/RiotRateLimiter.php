<?php

namespace App\Support;

class RiotRateLimiter
{
    private function parseRateLimits($headers)
    {
        $limits = [];

        foreach (explode(',', $headers) as $limitInterval) {
            $limitInterval = explode(':', $limitInterval);
            $limit = (int) $limitInterval[0];
            $interval = (int) $limitInterval[1];
            $limits[$interval] = $limit;
        }

        return $limits;
    }
}
