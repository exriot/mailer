<?php

namespace App;

class MarkdownUndresser
{
    private $md_text;
    private $modified;

    public function __construct($md_text)
    {
        $this->md_text = $md_text;
        $this->modified = $md_text;
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
