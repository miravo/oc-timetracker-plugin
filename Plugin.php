<?php namespace Miravo\Timetracker;

use Backend;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        //
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return [
            'Miravo\Timetracker\Components\TimeClock' => 'timeClock',
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'transComp' => [\Miravo\TimeTracker\Classes\TranslateHelper::class, 'string']
            ],
        ];
    }

}
