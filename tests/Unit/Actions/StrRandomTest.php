<?php

namespace Tests\Unit\Actions;

use App\Actions\StrRandom;
use PHPUnit\Framework\TestCase;
// use Tests\TestCase;

class StrRandomTest extends TestCase
{
    /** @test */
    function StrRandom_正しい文字数を返す()
    {
        // class_alias(\Illuminate\Support\Str::class, \Str::class);

        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(10);

        $this->assertTrue(strlen($ret1) === 8);
        $this->assertTrue(strlen($ret2) === 10);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す1()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す2()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す3()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す4()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す5()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す6()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す7()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す8()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す9()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す10()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す11()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す12()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す13()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す14()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }

    /** @test */
    function StrRandom_ランダムの文字列を返す15()
    {
        $random = new StrRandom();

        $ret1 = $random->get(8);
        $ret2 = $random->get(8);

        $this->assertFalse($ret1 === $ret2);
    }
}
