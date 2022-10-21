<?php

declare(strict_types=1);

namespace app\tests\Unit;

use app\core\Request;
use app\core\Response;
use app\core\Router;
use app\core\singletons\Container;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $requestMock = $this->createMock(Request::class);
        $responseMock = $this->createMock(Response::class);
        $containerMock = $this->createMock(Container::class);

        $this->router = new Router(
            $requestMock,
            $responseMock,
            $containerMock
        );
    }

    
    public function test_it_registers_a_get_route_test(): void
    {
        //given router class
        

        //when get request is made
        $this->router->get("/users", ["Users", "index"]);

        $expected = [
            "get" => [
                "/users" => "index"
            ]
        ];

        //then assert get route is registered
        $this->assertEquals($expected, $this->router->routes);
    }
}