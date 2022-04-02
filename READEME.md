### Yii集成企业微信扩展

#### 1、 安装

```
$ composer require xushunbin/qiyewechat v0.0.1
```

#### 2、 配置
```
 'components' => [
        ...
        // 增加配置如下
        'wechat'  => [
            'class'        => \Qiyewechat\Wechat::class,
            'corpid'       => 'ww0c6f6831b3d47deb',
            'corpsecret'   => '456',
            'agentid'      => '1000004',
            'redirect_uri' => 'http://admin.jzcassociates.com',
        ],
    ],

```

### 简单使用

#### 1、 获取扫码登录连接

```
// 在控制器中使用
$state = uniqid();
Yii::$app->session->set('state', $state);
$loginUrl = Yii::$app->wechat->registerScanUrl($state);
return $this->redirect($loginUrl);
```

#### 2、 设置定时任务每一小时获取一次access_token
```
Yii::$app->wechat->flushAccessTokenPerHour(); 
```

#### 3、获取所有的部门

```
Yii::$app->wechat->createObject(Wechat::DEPARTMENT)->getAllDepartment();
```
