<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class CustomCSSPlugin
 * @package Grav\Plugin
 */
class CustomCSSPlugin extends Plugin
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        $this->enable([
            'onAssetsInitialized' => ['onAssetsInitialized', 0]
        ]);
    }

    public function onAssetsInitialized()
    {
        $this->grav['assets']->addInlineCss($this->config->get('plugins.custom-css.css_inline'));

        foreach($this->config->get('plugins.custom-css.css_files', []) as $file) {
            $this->grav['assets']->addCss($file['path'], isset($file['priority']) ? $file['priority'] : null);
        }
    }
}
