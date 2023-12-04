<?php

namespace ChatPlus;

class Utils
{
    public static bool $lock = false;
    public static array $cooldown = [];
    public static array $badword = [];
    public static array $messages = [];

    public function __construct(public Main $plugin)
    {
        $this->loadConfig();
    }

    public static function isLock(): bool
    {
        return self::$lock;
    }

    public static function setLock(bool $lock): void
    {
        self::$lock = $lock;
    }

    public function loadConfig(): void
    {
        $config = $this->plugin->config();

        foreach($config->get("bad-words") as $word){
            if(!isset(self::$badword[$word])){
                self::$badword[] = $word;
            }
        }

        foreach($config->get("messages") as $message){
            if(!isset(self::$messages[$message])){
                self::$messages[] = $message;
            }
        }
    }
}
