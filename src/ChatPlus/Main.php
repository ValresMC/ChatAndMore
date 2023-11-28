<?php

namespace ChatPlus;

use ChatPlus\Commands\lockCommand;
use ChatPlus\Listeners\playerListeners;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase
{
    use SingletonTrait;

    public function onEnable(): void
    {
        $this->saveResource("config.yml");
        $this->getLogger()->info("by Valres est lancé !");

        $this->getServer()->getPluginManager()->registerEvents(new playerListeners($this, $this->utils()), $this);
        $this->getServer()->getCommandMap()->register("", new lockCommand($this));

        $config = $this->config();

        $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function() {

            $config = $this->config();
            $messages = $config->get("messages");

            Server::getInstance()->broadcastMessage($messages[array_rand($messages)]);

        }), $config->get("time"));
    }

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    public function config(): Config
    {
        return new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function utils(): Utils
    {
        return new Utils($this);
    }
}
