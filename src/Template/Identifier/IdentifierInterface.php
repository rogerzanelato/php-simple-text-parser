<?php

namespace TextParser\Template\Identifier;

use TextParser\Template\Model\Template;

interface IdentifierInterface
{
    public function __invoke(Template $Template);
}
