<?php

/**
 * Robots.txt Editor — Contensio plugin.
 * https://contensio.com
 *
 * @copyright   Copyright (c) 2026 Iosif Gabriel Chimilevschi
 * @license     https://www.gnu.org/licenses/agpl-3.0.txt  AGPL-3.0-or-later
 */

namespace Contensio\Plugins\RobotsTxt\Http\Controllers;

use Contensio\Plugins\RobotsTxt\Support\RobotsConfig;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RobotsTxtController extends Controller
{
    /**
     * Serve the public /robots.txt response.
     */
    public function serve()
    {
        return response(RobotsConfig::get(), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    /**
     * Admin editor page.
     */
    public function edit()
    {
        return view('robots-txt::admin.settings', ['content' => RobotsConfig::get()]);
    }

    /**
     * Save updated robots.txt content.
     */
    public function update(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:65535'],
        ]);

        RobotsConfig::save($request->input('content'));

        return back()->with('success', 'robots.txt saved.');
    }

    /**
     * Reset to the plugin default.
     */
    public function reset()
    {
        RobotsConfig::save(RobotsConfig::default());

        return back()->with('success', 'robots.txt reset to default.');
    }
}
