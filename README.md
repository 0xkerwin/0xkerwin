### 个人博客系统
---

#### 简介

系统基于Yii2框架开发，后台样式使用了AdminLTE，集成RBAC，前台样式使用了Bootstrap。


[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)

#### 主要功能

- 首页统计
- 文章分类和文章内容的增删改查
- 图片上传
- RBAC权限管理（角色、权限增删改查，以及给赋予角色权限）
- 菜单配置（自定义菜单，可以根据用户权限显示和隐藏菜单）
- 操作日志

#### 安装要求

- PHP >= 5.4
- MySql
- Redis

#### 安装

- 克隆项目

```
git clone https://github.com/0xkerwin/0xkerwin.git
```

- 执行` composer install `安装Yii2；
- 运行` init `对系统进行初始化；
- 导入Mysql数据，sql文件在doc目录下。
