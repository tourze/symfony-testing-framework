# symfony-testing-framework

[English](README.md) | [中文](README.zh-CN.md)



## 功能特性

- 特性 1
- 特性 2
- 特性 3

## 安装

```bash
composer require tourze/symfony-testing-framework
```

## 快速开始

```php
<?php

// 示例代码
```

## 认证与默认账号

为保证本测试框架不依赖具体业务用户实现（例如 BizUserBundle），已内置最小化的基于内存用户（in-memory）的认证配置：

- 默认提供者：`in_memory`
- 默认账号：用户名 `admin`，密码 `password`
- 默认角色：`ROLE_ADMIN`
- 登录路径：`/login`（路由名：`app_login`）
- 登出路径：`/logout`（路由名：`app_logout`）
- EasyAdmin 后台：`/admin`（需要 `ROLE_ADMIN`）

相关配置位于 `packages/symfony-testing-framework/config/packages/security.yaml`：

```yaml
security:
  providers:
    users_in_memory:
      memory:
        users:
          admin: { password: password, roles: ROLE_ADMIN }
  firewalls:
    main:
      provider: users_in_memory
      form_login:
        login_path: app_login
        check_path: app_login
```

在测试环境下（`when@test`）也保持使用内存用户，并放宽密码哈希成本以提升执行速度。内存用户使用明文哈希（`plaintext`），仅用于开发/测试场景。

### 覆盖/替换为自有用户体系

如果你的项目需要接入自有用户实体或用户提供者，可以在宿主应用的 `config/packages/security.yaml` 中覆盖提供者与防火墙设置。例如：

```yaml
security:
  providers:
    app_user_provider:
      entity:
        class: App\Entity\User
        property: email
  firewalls:
    main:
      provider: app_user_provider
      form_login:
        login_path: app_login
        check_path: app_login
```

如需彻底移除内置默认账号，只需在宿主应用中定义你自己的 `providers` 与 `firewalls.main.provider`，即可覆盖本包默认配置。

## 贡献

详情请参阅 [CONTRIBUTING.md](CONTRIBUTING.md)。

## 许可

MIT 许可证 (MIT)。详情请参阅 [许可文件](LICENSE)。
