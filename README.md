# Matu Response

laravel 接口数据返回扩展

## 安装

```bash
composer require matu/response
```

## 使用


```php
<?php

use Matu\Response\ResponseFactory;

class HelloController
{

    public function hello()
    {
        $data = [
            'message'=> 'hello',
            'code'   =>  200
           ];

        return ResponseFactory::make()->withData($data);
    }
 }
```

- 返回带分页的列表

```php
    $lists = User::paginate();

    return ResponseFactory::make()->collection($lists, new UserTransformer());
```

- 返回单条数据

```php

    $list = User::find(1);

    return ResponseFactory::make()->collection($list, new UserTransformer());

```

- 返回错误信息

```php
    return ResponseFactory::make()->withBadRequest('错误提示');
```

- 请求成功，无返回数据

```php
    return ResponseFactory::make()->withCreated();
```

- 自定义返回数据

```php
        $data = [
            'message'=>'hello',
            'code'=>200
           ];

        return ResponseFactory::make()->withData($data);
```


## 其他

Transformer 参考[文档地址](https://fractal.thephpleague.com/)





