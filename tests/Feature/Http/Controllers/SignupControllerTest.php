<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignupControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function ユーザー登録画面が開ける()
    {
        $this->get('signup')
            ->assertOk();
    }

    /** @test */
    function ユーザー登録できる()
    {
        // データ検証
        // DBに保存
        // ログインされてからマイページにリダイレクト

        $validData = [
            'name' => '太郎',
            'email' => 'aaa@bbb.net',
            'password' => 'hogehoge',
        ];

        // $validData = User::factory()->raw();
        // $validData = User::factory()->validData();

        $this->post('signup', $validData)
            ->assertOk();

        unset($validData['password']);

        $this->assertDatabaseHas('users', $validData);

        $user = User::firstWhere($validData);
        // $this->assertNotNull($user);

        $this->assertTrue(Hash::check('hogehoge', $user->password));
    }

    /** @test */
    function 不正なデータではユーザー登録できない()
    {
        // $this->withoutExceptionHandling();
        $url = 'signup';

        // $this->post($url, [])
        //     ->assertRedirect();

        // $this->post($url, ['name' => ''])->assertSessionHasErrors(['name' => 'nameは必ず指定してください。']); // ->dumpSession()
        $this->post($url, ['name' => ''])->assertInvalid(['name' => '指定']);
        $this->post($url, ['name' => str_repeat('あ', 21)])->assertInvalid(['name' => '20文字以下']);
        $this->post($url, ['name' => str_repeat('あ', 20)])->assertvalid('name');


    }
}
