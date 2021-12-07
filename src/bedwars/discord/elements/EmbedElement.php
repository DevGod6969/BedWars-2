<?php

namespace bedwars\discord\elements;

abstract class EmbedElement implements \JsonSerializable
{

    /** @var array */
    public array $information = [];
}