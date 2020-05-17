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

//        new ChainItem($end->addDays(3)->startOfDay(), $end->addDays(3)->endOfDay(), $this->current->getNext(), null, '3');
    }

    public function insertSchedule(Schedule $schedule, $content)
    {
        // How many elements can be inserted in the chain?
        $items = 0;
        $this->rewind();
        // loop through all elements
        $search = true;
        $runs = 0;
        while( $search){
            $runs++;
            if($runs > 10)break;

            if(! $this->current->isWritable()){
                if($this->current->isLast()){
                    break;
                }
                $this->current = $this->current->getNext();
//                dump('Current is: ' . $this->current->number);
//                dump($this->current);
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
//                dump('Current is: ' . $this->current->number);
//                dump($this->current);
//                break;
            }
        }
        return;

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
