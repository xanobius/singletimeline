<?php
namespace App\Helpers;

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

    public function __construct($s, $e, ChainItem $p = null, ChainItem $n = null, $c = null, $w = false)
    {
        $this->setPrevious($p)->setNext($n)
            ->setStart($s)->setEnd($e)
            ->setContent($c)
            ->setWritable($w);
    }

    public function getItem()
    {
        return [
            'start' => $this->start,
            'end' => $this->end,
            'content' => $this->content
        ];
    }

    public function getFirst()
    {
        return $this->first ?
            $this :
            $this->getPrevious()->getFirst();
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
    public function setPrevious(ChainItem $previous = null): ChainItem
    {
        $this->previous = $previous;
        if($previous == null){
            $this->first = true;
        }else{
            $previous->setNext($this);
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
    public function setNext(ChainItem $next = null): ChainItem
    {
        $this->next = $next;
        if($next == null){
            $this->last = true;
        }else{
            $next->setPrevious($this);
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
        return $this->start;
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
        return $this->end;
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
