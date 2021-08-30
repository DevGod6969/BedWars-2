<?php

namespace aaron2907\bedwars\lang;


use aaron2907\bedwars\lang\types\English;
use aaron2907\bedwars\lang\types\Spanish;

/**
 * Class TranslateManager
 * @package aaron2907\bedwars\lang
 */
class TranslateManager
{

    /** @var Translate[] */
    protected array $lang = [];

    private array $LANG_IDS = [
        'Español' => 0,
        'English' => 1
    ];


    /**
     * TranslateManager constructor.
     */
    public function __construct()
    {
        $lang = [
            new Spanish(),
            new English()
        ];

        foreach ($lang as $langType)
            $this->addLang($langType);
    }

    /**
     * @param $lang
     * @return bool
     */
    public function isLang($lang): bool
    {
        return isset($this->lang[$lang]);
    }

    /**
     * @param Translate $translate
     */
    public function addLang(Translate $translate): void
    {
        $this->lang[$translate->getName()] = $translate;
    }

    /**
     * @param string $lang
     * @return Translate
     */
    public function getLang(string $lang): Translate
    {
        return $this->lang[$lang];
    }

    /**
     * @param string $message
     * @param $lang
     * @return string
     */
    public function getTranslation(string $message, $lang): string
    {
        if (!$this->isLang($lang))
            return 'Error 404';

        $translation = $this->getLang($lang);

        return $translation->getConfig()->get($message);
    }

    /**
     * @param string $lang
     * @return int|null
     */
    public function getIdByLang(string $lang): ?int
    {
        return $this->LANG_IDS[$lang];
    }

    /**
     * @param int $id
     * @return string|null
     */
    public function getLangById(int $id): ?string
    {
        foreach ($this->LANG_IDS as $lang => $LANG_ID) {
            if ($LANG_ID == $id)
                return $lang;
        }
        return null;
    }
}