<?php

namespace ChatPlus;

class Utils
{
    public static bool $lock = false;

    public static array $cooldown = [];

    public function __construct(public Main $plugin) {}

    public static function isLock(): bool
    {
        return self::$lock;
    }

    public static function setLock(bool $lock): void
    {
        self::$lock = $lock;
    }
}
