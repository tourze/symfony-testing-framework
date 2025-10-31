# Symfony Testing Framework

[English](README.md) | [中文](README.zh-CN.md)

This package provides enhanced testing utilities for Symfony applications.

## Features

- Enhanced WebTestCase with database management
- Type-safe service locator
- Authentication helpers for testing
- EasyAdmin test utilities
- PHPStan rules for test quality

## Authentication / 认证与默认账号

本测试框架不再内置依赖 BizUserBundle，而是提供基于内存用户（in-memory）的最小化认证配置：

- 默认账号：admin / password（角色：ROLE_ADMIN）
- 登录：`/login`（路由名：`app_login`）
- 登出：`/logout`（路由名：`app_logout`）
- EasyAdmin 后台：`/admin`

详细说明与覆盖方式请查看中文文档：README.zh-CN.md 中的“认证与默认账号”章节。
