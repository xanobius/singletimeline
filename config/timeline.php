<?php

return [
    /*
     * Can be combined, although some combinations should be captured by the application (q.e. event + timerange)
     * since event is a single point in time an thus can have only a start-time
     * It MUST have a combi with weekday or daterange OR a defined date (first two should be prefered for repetition)
     */
    'schedule_types' => [
        'weekdays' => 1,
        'timerange' => 2,
        'daterange' => 4,
        'event' => 8
    ],
    'weekdays' => [
        'monday' => 1,
        'tuesday' => 2,
        'wednesday' => 4,
        'thursday' => 8,
        'friday' => 16,
        'saturday' => 32,
        'sunday' => 64
    ],
];
