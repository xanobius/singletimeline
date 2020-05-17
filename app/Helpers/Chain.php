<?php

namespace App\Helpers;

class Chain
{
    /**
     * @var ChainItem
     */
    private $current;

    public function __construct($start, $end, $defaultContent)
    {
        $this->current = new ChainItem($start, $end, null, null, $defaultContent, true);
    }

    public function getChain()
    {
        $this->rewind();
        do{
            $tot = [];
            $tot[] = $this->current->getItem();
        }while($this->current = $this->current->getNext());

        return $tot;
    }

    public function rewind()
    {
        $this->current = $this->current->getFirst();
    }


}
