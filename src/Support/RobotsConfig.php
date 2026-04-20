<?php

/**
 * Robots.txt Editor - Contensio plugin.
 * https://contensio.com
 *
 * @copyright   Copyright (c) 2026 Iosif Gabriel Chimilevschi
 * @license     https://www.gnu.org/licenses/agpl-3.0.txt  AGPL-3.0-or-later
 */

namespace Contensio\Plugins\RobotsTxt\Support;

use Contensio\Models\Setting;

/**
 * Reads and writes the robots.txt content from the core settings table.
 * module = 'plugin_robots_txt', setting_key = 'content'
 */
class RobotsConfig
{
    public static function get(): string
    {
        try {
            $stored = Setting::where('module', 'plugin_robots_txt')
                ->where('setting_key', 'content')
                ->value('value');

            if ($stored !== null) {
                return $stored;
            }
        } catch (\Throwable) {}

        return static::default();
    }

    public static function save(string $content): void
    {
        Setting::updateOrCreate(
            ['module' => 'plugin_robots_txt', 'setting_key' => 'content'],
            ['value'  => $content]
        );
    }

    public static function default(): string
    {
        $base = rtrim(config('app.url', 'https://example.com'), '/');
        return "User-agent: *\nAllow: /\n\nSitemap: {$base}/sitemap.xml\n";
    }
}
