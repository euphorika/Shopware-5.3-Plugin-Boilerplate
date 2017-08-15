<?php

namespace PluginName\Subscribers\Frontend;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Shopware\Components\Theme\LessDefinition;

class Resources implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDir;

    /**
     * Resources constructor.
     *
     * @param string $pluginDir
     */
    public function __construct($pluginDir)
    {
        $this->pluginDir = $pluginDir;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Theme_Compiler_Collect_Plugin_Less'       => 'onCollectLessFiles',
            'Theme_Compiler_Collect_Plugin_Javascript' => 'onCollectJavascriptFiles',
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
    public function onCollectLessFiles(\Enlight_Event_EventArgs $args)
    {
        $lessDir = $this->pluginDir . '/Resources/views/frontend/_public/src/less/';

        $less = new LessDefinition(
            [],
            [
                $lessDir . 'plugin_name.less',
            ]
        );

        return new ArrayCollection([$less]);
    }

    /**
     * @return ArrayCollection
     */
    public function onCollectJavascriptFiles()
    {
        $jsDir = $this->pluginDir . '/Resources/views/frontend/_public/src/js/';

        return new ArrayCollection(
            [
              $jsDir . 'jquery.plugin_name.js',
            ]
        );
    }
}
