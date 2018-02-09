<?php

namespace App\Controllers;

use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Rpc\Client\Bean\Annotation\Reference;
use Swoft\Rpc\Client\Service\Service;
use App\Lib\DemoInterface;

/**
 * rpc controller test
 *
 * @Controller(prefix="rpc")
 */
class RpcController
{

    /**
     * @Reference("user")
     *
     * @var DemoInterface
     */
    private $demoService;

    /**
     * @Reference(name="user", version="1.0.1")
     *
     * @var DemoInterface
     */
    private $demoServiceV2;


    /**
     * @Reference("user")
     * @var \App\Lib\MdDemoInterface
     */
    private $mdDemoService;

    /**
     * @RequestMapping(route="call")
     * @return array
     */
    public function call()
    {
        $version  = $this->demoService->getUser('11');
        $version2 = $this->demoServiceV2->getUser('11');

        return [
            'version'  => $version,
            'version2' => $version2,
        ];
    }

    /**
     * @RequestMapping("validate")
     */
    public function validate()
    {
        $result = $this->demoService->getUserByCond(1, 2, 'boy', '4');

        return ['validator', $result];
    }


    /**
     * @RequestMapping("pm")
     */
    public function parentMiddleware()
    {
        $result = $this->mdDemoService->parentMiddleware();

        return ['parentMiddleware', $result];
    }

    /**
     * @RequestMapping("fm")
     */
    public function funcMiddleware()
    {
        $result = $this->mdDemoService->funcMiddleware();

        return ['funcMiddleware', $result];
    }
}