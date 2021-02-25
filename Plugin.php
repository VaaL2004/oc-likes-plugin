<?php namespace Xl1034\Likes;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public $require = ['RainLab.User'];

    public function registerComponents()
    {
        return [
            'Xl1034\Likes\Components\LikeButton' => 'LikeButton'
        ];
    }

    public function registerSettings()
    {
    }


    public function boot()
    {

    }
}
