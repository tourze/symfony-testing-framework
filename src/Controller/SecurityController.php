<?php

namespace SymfonyTestingFramework\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * 提供最小可用的登录/登出路由，满足 EasyAdmin 模板依赖。
 * 注意：这里不实现真实的认证逻辑，仅用于测试环境下路由存在性检查。
 */
final class SecurityController
{
    #[Route(path: '/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(): Response
    {
        return new Response('OK');
    }

    #[Route(path: '/logout', name: 'app_logout', methods: ['GET', 'POST'])]
    public function logout(): Response
    {
        return new Response('OK');
    }
}
