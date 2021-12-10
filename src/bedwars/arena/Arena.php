<?php

namespace bedwars\arena;

class Arena
{

    /** @var ArenaOptions */
    public ArenaOptions $options;
    /** @var string */
    public string $name;
    /** @var bool */
    public bool $load = false;

    /**
     * @param string $name
     * @param ArenaOptions $options
     */
    public function __construct(string $name, ArenaOptions $options)
    {
        $this->setName($name);
        $this->setOptions($options);
    }

    /**
     * @return ArenaOptions
     */
    public function getOptions(): ArenaOptions
    {
        return $this->options;
    }

    /**
     * @param ArenaOptions $options
     */
    public function setOptions(ArenaOptions $options): void
    {
        $this->options = $options;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isLoad(): bool
    {
        return $this->load;
    }

    /**
     * @param bool $load
     */
    public function setLoad(bool $load): void
    {
        $this->load = $load;
    }
}