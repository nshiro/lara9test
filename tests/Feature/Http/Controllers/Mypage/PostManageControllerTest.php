<?php

namespace Tests\Feature\Http\Controllers\Mypage;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostManageControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function ゲストはブログを管理できない()
    {
        $loginUrl = 'mypage/login';

        $this->get('mypage/posts')->assertRedirect($loginUrl);
    }

    /** @test */
    function マイページTOPを開ける()
    {
        // 認証済みの場合
        // $user = User::factory()->create();

        // $this->actingAs($user)
        //     ->get('mypage/posts')
        //     ->assertOk();

        $this->login();

        $this->get('mypage/posts')
            ->assertOk();
    }
}
