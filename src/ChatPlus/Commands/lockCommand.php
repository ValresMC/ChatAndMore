<?php

namespace ChatPlus\Commands;

use ChatPlus\Main;
use ChatPlus\Utils;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;

class lockCommand extends Command
{
    public function __construct(public Main $plugin)
    {
        parent::__construct("lock", "§7Lock the chat");
        $this->setPermission("lock.command");
        $this->setPermissionMessage("§cYou are not allow to lock the chat !");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        $config = $this->plugin->config();

        if ($sender instanceof Player) {
            if (Utils::isLock()) {
                Utils::setLock(false);
                $sender->sendMessage($config->get("lock-success"));
                Server::getInstance()->broadcastMessage(str_replace("{user}", $sender->getName(), $config->get("lock-message")));
            } else {
                Utils::setLock(true);
                $sender->sendMessage($config->get("unlock-success"));
                Server::getInstance()->broadcastMessage(str_replace("{user}", $sender->getName(), $config->get("unlock-message")));
            }
        }
    }
}
