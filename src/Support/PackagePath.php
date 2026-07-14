<?php

namespace NoahBoos\LaravelCommands\Support;

class PackagePath {
    public static function base(): string {
        return dirname(__DIR__, 2);
    }

    public static function src(): string {
        return self::base() . '/src';
    }

    public static function stubs(): string {
        return self::base() . '/stubs';
    }
}
