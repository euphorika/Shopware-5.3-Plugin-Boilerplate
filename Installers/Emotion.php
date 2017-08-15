<?php

namespace PluginName\Installers;

use Shopware\Components\Emotion\ComponentInstaller;

class Emotion
{
    /** @var ComponentInstaller */
    private $emotionInstaller;

    /**
     * Emotion constructor.
     *
     * @param ComponentInstaller $emotionInstaller
     */
    public function __construct(ComponentInstaller $emotionInstaller)
    {
        $this->emotionInstaller = $emotionInstaller;
    }

    public function install()
    {
        $this->createEmotionElement();
    }

    private function createEmotionElement()
    {
        $element = $this->emotionInstaller->createOrUpdate(
            'PluginName',
            'Name of Emotion Element',
            [
                'name'        => 'Name of Emotion Element',
                'xtype'       => 'plugin_name',
                'template'    => 'plugin_name',
                'cls'         => 'plugin_name-element',
                'description' => '',
            ]
        );

        $element->createHtmlEditorField(
            [
                'name'       => 'content',
                'fieldLabel' => 'Inhalt',
            ]
        );
    }
}
