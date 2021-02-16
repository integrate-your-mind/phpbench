<?php

namespace PhpBench\Expression\Parselet;

use PhpBench\Expression\Ast\ArgumentListNode;
use PhpBench\Expression\Ast\FunctionNode;
use PhpBench\Expression\Ast\Node;
use PhpBench\Expression\Parser;
use PhpBench\Expression\PrefixParselet;
use PhpBench\Expression\Token;
use PhpBench\Expression\Tokens;

class FunctionParselet implements PrefixParselet
{
    public function tokenType(): string
    {
        return Token::T_FUNCTION;
    }

    public function parse(Parser $parser, Tokens $tokens): Node
    {
        $functionToken = $tokens->chomp();

        if ($tokens->current()->type === Token::T_CLOSE_PAREN) {
            $arguments = [];
        } else {
            $arguments = $parser->parseList($tokens);
            $arguments = $this->resolveArguments($arguments);
        }

        $tokens->chomp(Token::T_CLOSE_PAREN);

        return new FunctionNode(rtrim($functionToken->value, '('), $arguments);
    }

    /**
     * @return array<Node>
     */
    private function resolveArguments(Node $arguments): array
    {
        if ($arguments instanceof ArgumentListNode) {
            return $arguments->expressions();
        }

        return [$arguments];
    }
}