<?php

namespace ChatPlus\Listeners;

use ChatPlus\Main;
use ChatPlus\Utils;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class playerListeners implements Listener
{
    public function __construct(public Main $plugin, readonly Utils $utils) {}

    public function onChat(PlayerChatEvent $event): void
    {
        $player = $event->getPlayer();
        $config = $this->plugin->config();
        $time = time();

        if(!$player->hasPermission("chat.bypass")){
            if (Utils::isLock()) {
                $event->cancel();
                $player->sendMessage($config->get("lock-chat"));
            } else {
                if(isset(Utils::$cooldown[$player->getName()]) and Utils::$cooldown[$player->getName()] > $time){
                    $event->cancel();
                    $remaining = Utils::$cooldown[$player->getName()] - $time;
                    $player->sendMessage(str_replace("{time}", $remaining, $config->get("cooldown-message")));
                } else {
                    $cooldown = $config->get("cooldown");
                    Utils::$cooldown[$player->getName()] = $time + $cooldown;

                    foreach(Utils::$badword as $word){
                        if(stripos($event->getMessage(), $word) !== false){
                            $event->cancel();
                            $player->sendMessage(str_replace("{word}", $word, $config->get("bad-words-message")));
                            break;
                        }
                    }
                }
            }
        }
    }
}
