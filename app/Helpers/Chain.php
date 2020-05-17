<?php

namespace App\Helpers;

use App\Schedule;
use Carbon\Carbon;

class Chain
{
    /**
     * @var ChainItem
     */
    private $current;

    public function __construct(Carbon $start, Carbon $end, $defaultContent)
    {
        $this->current = new ChainItem($start, $end, null, null, $defaultContent, true);

        new ChainItem($end->addSecond(), $end->addDays(2)->endOfDay(), $this->current, null, '2');

        new ChainItem($end->addDays(3)->startOfDay(), $end->addDays(3)->endOfDay(), $this->current->getNext(), null, '3');
    }

    public function insertSchedule(Schedule $schedule)
    {
        // How many elements can be inserted in the chain?
        $items = 0;
        $this->rewind();
        // loop through all elements
        while( ! $this->current->isLast()){
            if(! $this->current->isWritable()){
                $this->current = $this->current->getNext();
            }else{
                // Search if there is some space to insert
                // delegate it to the Model, it's his job


            }
        }

    }

    public function getChain()
    {
        $this->rewind();
        $tot = [];
        do {
            $tot[] = $this->current->getItem();
        } while ($this->current = $this->current->getNext());

        return $tot;
    }

    public function rewind()
    {
        $this->current = $this->current->getFirst();
    }


}
