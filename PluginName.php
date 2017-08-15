<?php

namespace PluginName;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use PluginName\Installers\Emotion;

class PluginName extends Plugin
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('plugin_name.plugin_dir', $this->getPath());

        parent::build($container);
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstallContext $context)
    {
        $this->createEvents(null, $context->getCurrentVersion());

        parent::install($context);
    }

    /**
     * {@inheritDoc}
     */
    public function uninstall(UninstallContext $context)
    {
        parent::uninstall($context);
    }

    /**
     * {@inheritDoc}
     */
    public function update(UpdateContext $updateContext)
    {
        $this->createEvents($updateContext->getCurrentVersion(), $updateContext->getUpdateVersion());

        parent::update($updateContext);
    }

    /**
     * @param string|null $oldVersion
     * @param string|null $newVersion
     *
     * @return bool
     */
    public function createEvents($oldVersion = null, $newVersion = null)
    {
        $versionClosures = [

            '1.0.0' => function () {
                (new Emotion($this->container->get('shopware.emotion_component_installer')))->install();

                return true;
            },
        ];

        foreach ($versionClosures as $version => $versionClosure) {
            if ($oldVersion === null || (version_compare($oldVersion, $version, '<') && version_compare(
                        $version,
                        $newVersion,
                        '<='
                    ))
            ) {
                if (!$versionClosure($this)) {
                    return false;
                }
            }
        }

        return true;
    }
}
