<?php

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use EasyCorp\Bundle\EasyAdminBundle\EasyAdminBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MakerBundle\MakerBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\UX\StimulusBundle\StimulusBundle;
use Symfony\UX\Turbo\TurboBundle;
use Symfony\UX\TwigComponent\TwigComponentBundle;
use Tourze\AccessTokenBundle\AccessTokenBundle;
use Tourze\BundleDependency\ResolveHelper;
use Tourze\DoctrineResolveTargetEntityBundle\DoctrineResolveTargetEntityBundle;
use Twig\Extra\TwigExtraBundle\TwigExtraBundle;

return ResolveHelper::resolveBundleDependencies([
    FrameworkBundle::class => ['all' => true],
    DoctrineBundle::class => ['all' => true],
    DebugBundle::class => ['dev' => true],
    TwigBundle::class => ['all' => true],
    WebProfilerBundle::class => ['dev' => true, 'test' => true],
    StimulusBundle::class => ['all' => true],
    TurboBundle::class => ['all' => true],
    TwigExtraBundle::class => ['all' => true],
    SecurityBundle::class => ['all' => true],
    MonologBundle::class => ['all' => true],
    MakerBundle::class => ['dev' => true],
    TwigComponentBundle::class => ['all' => true],
    EasyAdminBundle::class => ['all' => true],
    DoctrineFixturesBundle::class => ['dev' => true, 'test' => true],
    DoctrineResolveTargetEntityBundle::class => ['all' => true],

    // 考虑到很多业务都是需要登录的，我们直接在这里引入这些模块，以简化测试
    AccessTokenBundle::class => ['all' => true],
    BizUserBundle\BizUserBundle::class => ['all' => true],

    ...(is_file(__DIR__ . '/bundles-local.php') ? require __DIR__ . '/bundles-local.php' : []),
]);
