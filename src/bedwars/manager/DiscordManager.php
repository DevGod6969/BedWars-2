<?php

namespace bedwars\manager;

use bedwars\discord\Webhook;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class DiscordManager extends Manager
{

    /**
     * @param Webhook $webhook
     * @return void
     */
    public function send(Webhook $webhook): void
    {
        Server::getInstance()->getAsyncPool()->submitTask(new class($webhook) extends AsyncTask {

            /** @var Webhook|null */
            private ?Webhook $discord = null;

            /**
             * @param Webhook|null $discord
             */
            public function __construct(?Webhook $discord)
            {
                $this->discord = $discord;
            }

            public function onRun(): void
            {
                $web = curl_init($this->discord->getURL());
                curl_setopt($web, CURLOPT_POSTFIELDS, json_encode($this->discord->getData()));
                curl_setopt($web, CURLOPT_POST, true);
                curl_setopt($web, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($web, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($web, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($web, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                $this->setResult(curl_exec($web));
                curl_close($web);
            }


            public function onCompletion(): void
            {
                $response = $this->getResult();
                if ($response !== '') {
                    Server::getInstance()->getLogger()->error('[Discord] Got error: ' . $response);
                }
            }
        });
    }
}