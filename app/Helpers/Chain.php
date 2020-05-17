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
    }

    public function insertSchedule(Schedule $schedule, $content)
    {
        // How many elements can be inserted in the chain?
        $items = 0;
        $this->rewind();
        // loop through all elements
        $search = true;
        while( $search){
            if(! $this->current->isWritable()){
                if($this->current->isLast()){
                    break;
                }
                $this->current = $this->current->getNext();
            }else{
                // Search if there is some space to insert
                // delegate it to the Model, it's his job
                $boundaries = $schedule->getNextBlock(
                    $this->current->getStart(),
                    $this->current->getEnd()
                );

                if($boundaries){
                    $ci = new ChainItem($boundaries[0], $boundaries[1], null, null, $content, false);
                    $this->current = $this->current->insertChainItem($ci);
                }else{
                    // no space in this one, go to the next
                    if($this->current->isLast()){
                        break;
                    }
                    $this->current = $this->current->getNext();
                }
            }
        }
        return $this;
    }

    public function getChain()
    {
        $this->rewind();
        $tot = [];
        $tot[] = $this->current->getItem();

        while($this->current->getNext() != null){
            $this->current = $this->current->getNext();
            $tot[] = $this->current->getItem();
        }

        return $tot;
    }

    public function rewind()
    {
        $this->current = $this->current->getFirst();
    }


}
