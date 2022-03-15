<?php

namespace Tests\Feature\Http\Controllers\Mypage;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginControllerTest extends TestCase
{
    /** @test */
    function ログイン画面を開ける()
    {
        $this->get('mypage/login')
            ->assertOK();
    }
}
