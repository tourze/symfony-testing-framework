<?php

declare(strict_types=1);

namespace SymfonyTestingFramework\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * 在测试环境中将所有 Procedure 类标记为 public
 *
 * 这个 CompilerPass 只在测试环境中生效，让测试可以通过 container->get() 获取 Procedure 实例。
 * 只标记继承 Tourze\JsonRPC\Core\Procedure\BaseProcedure 的服务，避免影响其他服务。
 *
 * @author Claude
 */
class MakeProceduresPublicPass implements CompilerPassInterface
{
    private const BASE_PROCEDURE_CLASS = 'Tourze\JsonRPC\Core\Procedure\BaseProcedure';

    public function process(ContainerBuilder $container): void
    {
        // 检查 BaseProcedure 类是否存在
        if (!class_exists(self::BASE_PROCEDURE_CLASS)) {
            return;
        }

        foreach ($container->getDefinitions() as $id => $definition) {
            $class = $definition->getClass();

            // 跳过没有类名的定义（如抽象定义、工厂定义）
            if (null === $class) {
                continue;
            }

            // 跳过参数占位符（如 %kernel.project_dir%）
            if (str_starts_with($class, '%') && str_ends_with($class, '%')) {
                continue;
            }

            // 使用字符串检查避免自动加载
            // 如果类名不包含 "Procedure"，大概率不是 Procedure 类，跳过
            if (!str_contains($class, 'Procedure')) {
                continue;
            }

            // 现在才尝试加载类并检查继承关系
            try {
                if (!class_exists($class, true)) {
                    continue;
                }

                $reflection = new \ReflectionClass($class);

                // 检查是否是 BaseProcedure 的子类（不包括 BaseProcedure 本身）
                if ($reflection->isSubclassOf(self::BASE_PROCEDURE_CLASS)) {
                    $definition->setPublic(true);
                }
            } catch (\ReflectionException|\Error $e) {
                // 忽略无法反射的类
                continue;
            }
        }
    }
}
