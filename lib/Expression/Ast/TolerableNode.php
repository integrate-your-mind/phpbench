<?php

namespace PhpBench\Expression\Ast;

class TolerableNode implements Node
{
    /**
     * @var Node
     */
    private $value;
    /**
     * @var Node
     */
    private $tolerance;

    public function __construct(Node $value, Node $tolerance)
    {
        $this->value = $value;
        $this->tolerance = $tolerance;
    }

    public function tolerance(): Node
    {
        return $this->tolerance;
    }

    public function value(): Node
    {
        return $this->value;
    }
}
