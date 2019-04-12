<?php

namespace App;

class HtmlModifier
{
    private $html;
    private $modified;

    public function __construct($html)
    {
        $this->html = $html;
        $this->modified = $html;
    }

    public function modify()
    {
        return $this;
    }

    public function getResult()
    {
        return $this->modified;
    }
}
