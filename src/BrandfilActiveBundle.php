<?php

declare(strict_types=1);

namespace Brandfil\ActiveBundle;

use Brandfil\ActiveBundle\DependencyInjection\BrandfilActiveBundleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class BrandfilActiveBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }

    public function getContainerExtension()
    {
        return new BrandfilActiveBundleExtension();
    }
}