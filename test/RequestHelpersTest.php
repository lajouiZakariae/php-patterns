<?php

declare(strict_types=1);

use PHPPatterns\Http\Request;
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';

$_SERVER = [
    // "HTTP_HOST" => "auth.test",
    // "HTTP_USER_AGENT" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0",
    // "HTTP_ACCEPT" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
    // "HTTP_ACCEPT_LANGUAGE" => "en-BZ",
    // "HTTP_ACCEPT_ENCODING" => "gzip, deflate",
    // "HTTP_CONNECTION" => "keep-alive",
    // "HTTP_COOKIE" => "PHPSESSID=ocf1g82n1t10qig7c7ruhp01op; language=en",
    // "HTTP_UPGRADE_INSECURE_REQUESTS" => "1",
    // "SystemRoot" => "C:\WINDOWS",
    // "COMSPEC" => "C:\WINDOWS\system32\cmd.exe",
    // "PATHEXT" => ".COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH;.MSC",
    // "WINDIR" => "C:\WINDOWS",
    // "SERVER_NAME" => "auth.test",
    // "SERVER_ADDR" => "127.0.0.1",
    // "SERVER_PORT" => "80",
    // "REMOTE_ADDR" => "127.0.0.1",
    // "DOCUMENT_ROOT" => "C:/laragon/www/auth/public",
    // "REQUEST_SCHEME" => "http",
    // "CONTEXT_DOCUMENT_ROOT" => "C:/laragon/www/auth/public",
    // "SCRIPT_FILENAME" => "C:/laragon/www/auth/public/index.php",
    // "REMOTE_PORT" => "51191",
    // "GATEWAY_INTERFACE" => "CGI/1.1",
    // "SERVER_PROTOCOL" => "HTTP/1.1",
    // "REQUEST_METHOD" => "GET",
    // "QUERY_STRING" => "",
    "REQUEST_URI" => "",
    // "SCRIPT_NAME" => "/index.php",
    // "PHP_SELF" => "/index.php",
    // "REQUEST_TIME_FLOAT" => 1703610979.6218,
    // "REQUEST_TIME" => 1703610979,
];

$_GET = ['name' => 'lajoui', 'age' => "19", 'languages' => ['fr']];
$_POST = ['email' => 'lajoui', 'passwor' => '12345', 'children' => 5];

final class RequestHelpersTest extends TestCase
{
    public function testPath(): void
    {
        $request = new Request();

        $this->assertEquals($request->path(), '/');

        $_SERVER["REQUEST_URI"] = "/";
        $request = new Request();

        $this->assertEquals($request->path(), '/');

        $_SERVER["REQUEST_URI"] = "/admin";
        $request = new Request();

        $this->assertEquals($request->path(), '/admin');

        $_SERVER["REQUEST_URI"] = "/home/about";
        $request = new Request();

        $this->assertEquals($request->path(), '/home/about');
    }

    public function testParamAndInputExist(): void
    {
        $request = new Request();

        $this->assertEquals($request->paramExists('name'), true);
        $this->assertEquals($request->paramExists('name'), true);
        $this->assertEquals($request->inputExists('email'), true);
        $this->assertEquals($request->inputExists('password'), false);
    }

    public function testParamAndInput(): void
    {
        $request = new Request();

        $this->assertEquals($request->param('name'), 'lajoui');
        $this->assertEquals($request->param('age'), '19');
        $this->assertEquals($request->input('email'), 'lajoui');
        $this->assertEquals($request->input('password'), null);
        $this->assertEquals($request->param('languages'), ["fr"]);
    }

    public function testParamAndInputInteger(): void
    {
        $request = new Request();

        $this->assertEquals($request->paramIsInteger('age'), true);
        $this->assertEquals($request->paramIsInteger('name'), false);
        $this->assertEquals($request->inputIsInteger('children'), true);
        $this->assertEquals($request->inputIsInteger('email'), false);
        $this->assertEquals($request->paramInteger('age'), 19);
        $this->assertEquals($request->inputInteger('children'), 5);
        $this->assertEquals($request->paramInteger('age',), 19);
        $this->assertEquals($request->inputInteger('children'), 5);
    }

    // public function testWhenEquealsCall(): void
    // {

    // }
}
