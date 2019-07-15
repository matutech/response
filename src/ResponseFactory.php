<?php
/**
 * Created by PhpStorm.
 * User: sunlong
 * Date: 2019-02-24
 * Time: 17:41
 */

namespace Matu\Response;

use League\Fractal\Manager;


final class ResponseFactory
{
    public static function make()
    {
        return new Response(\response(), new Transform(new Manager()));
    }
}
