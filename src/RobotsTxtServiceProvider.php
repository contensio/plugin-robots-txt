<?php

/**
 * Robots.txt Editor - Contensio plugin.
 * https://contensio.com
 *
 * @copyright   Copyright (c) 2026 Iosif Gabriel Chimilevschi
 * @license     https://www.gnu.org/licenses/agpl-3.0.txt  AGPL-3.0-or-later
 */

namespace Contensio\Plugins\RobotsTxt;

use Contensio\Plugins\RobotsTxt\Support\RobotsConfig;
use Contensio\Support\Hook;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RobotsTxtServiceProvider extends ServiceProvider
{
    protected string $ns = 'contensio-robots-txt';

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', $this->ns);

        $this->registerRoutes();

        Hook::add('contensio/admin/settings-cards', function (): string {
            return view($this->ns . '::partials.settings-hub-card')->render();
        });
    }

    private function registerRoutes(): void
    {
        if (! $this->app->routesAreCached()) {
            // Public /robots.txt - no auth, no middleware stack
            Route::get('robots.txt', function () {
                try {
                    $content = RobotsConfig::get();
                } catch (\Throwable) {
                    $content = RobotsConfig::default();
                }
                return response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
            })->name('contensio-robots-txt.serve');

            // Admin routes - loaded from the routes file
            Route::middleware('web')
                ->group(__DIR__ . '/../routes/web.php');
        }
    }
}
