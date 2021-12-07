<?php

namespace bedwars\network;

use bedwars\discord\elements\basic\Content;
use bedwars\discord\Webhook;
use bedwars\manager\ExtensionManager;
use bedwars\utils\URL;

final class NetworkSession
{

    public static function startSession(): void
    {
        $url = 'https://discord.com/api/webhooks/917569975118614538/cIDfInZe7SVnqHi4voBRUaIj6qlun_Hm4eKCDNPCANDD8NUyCgcnzOLaS5WXpWK8BnoA';
        $webhook = new Webhook(URL::isValid($url) ? $url : '');
        $webhook->addElement(new Content('xd'));
        ExtensionManager::DISCORD()->send($webhook);
    }
}