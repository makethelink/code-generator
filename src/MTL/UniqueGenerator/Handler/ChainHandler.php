<?php
namespace MTL\UniqueGenerator\Handler;

class ChainHandler implements HandlerInterface
{
    protected $handlers = array();

    public function addHandler(HandlerInterface $handler)
    {
        $this->handlers[] = $handler;

        return $this;
    }

    public function handle($data)
    {
        $chainedData = null;
        foreach ($this->handlers as $handler) {
            if (!$chainedData) {
                $chainedData = $handler->handle($data);
            } else {
                $chainedData = $handler->handle($chainedData);
            }
        }

        return ;
    }
}