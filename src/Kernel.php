<?php

namespace SymfonyTestingFramework;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Tourze\BundleDependency\ResolveHelper;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @param string $environment
     * @param bool $debug
     * @param string $projectDir
     * @param array $appendBundles 记录需要额外加载的Bundle
     */
    public function __construct(
        string $environment,
        bool $debug,
        private readonly string $projectDir,
        private readonly array $appendBundles,
    ) {
        $_ENV['APP_SECRET'] = 'TEST_APP_SECRET';
        $_ENV['TESTING_FRAMEWORK_PATH'] = realpath(__DIR__ . '/../');
        parent::__construct($environment, $debug);
    }

    /**
     * 这里我们处理额外附加的Bundle
     */
    protected function initializeBundles(): void
    {
        parent::initializeBundles();

        foreach (ResolveHelper::resolveBundleDependencies($this->appendBundles) as $bundleClass => $env) {
            if (!class_exists($bundleClass)) {
                continue;
            }

            $bundle = new $bundleClass();
            assert($bundle instanceof Bundle);

            $name = $bundle->getName();
            if (isset($this->bundles[$name])) {
                continue;
            }
            $this->bundles[$name] = $bundle;
        }
    }

    /**
     * 我们是测试内核，路径总是外部指定的
     */
    public function getProjectDir(): string
    {
        return $this->projectDir;
    }

    private function getConfigDir(): string
    {
        return realpath(__DIR__ . '/../config');
    }

    protected function build(ContainerBuilder $container): void
    {
        parent::build($container);

        // 方便我们读取并操作fixture
        if ($container->hasDefinition('doctrine.fixtures.loader')) {
            $container->getDefinition('doctrine.fixtures.loader')->setPublic(true);
        }
    }
}
