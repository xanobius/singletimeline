<?php
namespace App\Helpers;

use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Boolean;

class ChainItem
{
    /**
     * First element of the chain
     * @var bool
     */
    private $first = false;

    /**
     * Last element of the chain
     * @var bool
     */
    private $last = false;

    /**
     * reference to previous chain item
     * @var ChainItem
     */
    private $previous;

    /**
     * reference to next chain item
     * @var ChainItem
     */
    private $next;

    /**
     * is this element available for manipulation?
     * @var bool
     */
    private $writable;

    /**
     * Startdate (additional implementation information)
     * @var \Carbon\Carbon
     */
    private $start;

    /**
     * Enddate (additional implementation information)
     * @var \Carbon\Carbon
     */
    private $end;

    /**
     * Content of this chain (additional implementation information)
     * @var mixed
     */
    private $content;

    public $number;

    public static $counter = 0;

    public function __construct(
        Carbon $start,
        Carbon $end,
        ChainItem $previous = null,
        ChainItem $next = null,
        $content = null,
        bool $writable = false)
    {
        $this->number = ChainItem::$counter;
        ChainItem::$counter++;

        $this->setPrevious($previous)->setNext($next)
            ->setStart($start)->setEnd($end)
            ->setContent($content)
            ->setWritable($writable);
    }

    /**
     * Return formatted info of the item
     * @return array
     */
    public function getItem()
    {
        return [
            'start' => $this->start,
            'end' => $this->end,
            'content' => $this->content,
            'number' => $this->number
        ];
    }

    /**
     * return the first Element of the chain
     * @return ChainItem|mixed
     */
    public function getFirst()
    {
        return $this->first ?
            $this :
            $this->getPrevious()->getFirst();
    }

    public function insertChainItem(ChainItem $item)
    {
        // EXACT MATCH??


        // flush with the start
        if($item->getStart()->format('YmdHi') == $this->getStart()->format('YmdHi')){
            // Put it before: Return myself (its the last)
            $this->setStart($item->getEnd()->addMinute());
            $item->setPrevious($item->getPrevious());
            $this->setPrevious($item);
            return $this;
        }else{
            // flush with the end?
            if($item->getEnd()->format('YmdHi') == $this->getEnd()->format('YmdHis')){
                // Put it after: Return new element
                $this->setEnd($item->getStart()->subMinute());
                $item->setNext($this->getNext());
                $this->setNext($item);
                return $item;
            }
        }
        // put it in between. Need to create additional ChainItem
        $newItem = new ChainItem(
            $item->getEnd()->addMinute(),
            $this->getEnd(),
            $item,
            $this->getNext(),
            $this->content,
            true
        );

        $this->setEnd($item->getStart()->subMinute());
        $this->setNext($item);

        return $item;
    }


    /*********************
     * GETTERS & SETTERS *
     *********************/

    /**
     * @return bool
     */
    public function isFirst(): bool
    {
        return $this->first;
    }

    /**
     * @param bool $first
     * @return ChainItem
     */
    public function setFirst(bool $first): ChainItem
    {
        $this->first = $first;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLast(): bool
    {
        return $this->last;
    }

    /**
     * @param bool $last
     * @return ChainItem
     */
    public function setLast(bool $last): ChainItem
    {
        $this->last = $last;
        return $this;
    }

    /**
     * @return ChainItem|null
     */
    public function getPrevious(): ?ChainItem
    {
        return $this->previous;
    }

    /**
     * @param ChainItem|null $previous
     * @return ChainItem
     */
    public function setPrevious(ChainItem $previous = null, bool $stop_viceverca = false): ChainItem
    {
        $this->previous = $previous;
        if($previous == null){
            $this->first = true;
        }else{
            $this->first = false;
            if( ! $stop_viceverca){
                $previous->setNext($this, true);
            }
            // TODO: Also adjust end-time (-1 Second ?)
        }
        return $this;
    }

    /**
     * @return ChainItem|null
     */
    public function getNext(): ?ChainItem
    {
        return $this->next;
    }

    /**
     * @param ChainItem|null $next
     * @return ChainItem
     */
    public function setNext(ChainItem $next = null, bool $by_previous = false): ChainItem
    {
        $this->next = $next;
        if($next == null){
            $this->last = true;
        }else{
            $this->last = false;
            if( ! $by_previous){
                $next->setPrevious($this, true);
            }
            // TODO: also adjust start-time (+1 Second ?)
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isWritable(): bool
    {
        return $this->writable;
    }

    /**
     * @param bool $writable
     * @return ChainItem
     */
    public function setWritable(bool $writable): ChainItem
    {
        $this->writable = $writable;
        return $this;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getStart(): \Carbon\Carbon
    {
        return clone $this->start;
    }

    /**
     * @param \Carbon\Carbon $start
     * @return ChainItem
     */
    public function setStart(\Carbon\Carbon $start): ChainItem
    {
        $this->start = $start;
        return $this;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getEnd(): \Carbon\Carbon
    {
        return clone $this->end;
    }

    /**
     * @param \Carbon\Carbon $end
     * @return ChainItem
     */
    public function setEnd(\Carbon\Carbon $end): ChainItem
    {
        $this->end = $end;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return ChainItem
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }


}
