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
            ->assertRedirect('mypage/posts');

        unset($validData['password']);

        $this->assertDatabaseHas('users', $validData);

        $user = User::firstWhere($validData);
        // $this->assertNotNull($user);

        $this->assertTrue(Hash::check('hogehoge', $user->password));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    function 不正なデータではユーザー登録できない()
    {
        // $this->withoutExceptionHandling();
        $url = 'signup';

        User::factory()->create(['email' => 'aaa@bbb.net']);

        // $this->get('signup');

        $this->from('signup')->post($url, [])
            ->assertRedirect('signup');

        // 注意点
        // (1) カスタムメッセージを設定している時は、そちらが優先される
        // (2) 入力エラーが出る前に言語ファイルを読もうとしている箇所がある時は、
        //      そちらもtestingに対応させる必要あり

        app()->setLocale('testing');

        // $this->post($url, ['name' => ''])->assertSessionHasErrors(['name' => 'nameは必ず指定してください。']); // ->dumpSession()
        $this->post($url, ['name' => ''])->assertInvalid(['name' => 'required']);
        $this->post($url, ['name' => str_repeat('あ', 21)])->assertInvalid(['name' => 'max']);
        $this->post($url, ['name' => str_repeat('あ', 20)])->assertvalid('name');

        $this->post($url, ['email' => ''])->assertInvalid(['email' => 'required']);
        $this->post($url, ['email' => 'aa@bb@cc'])->assertInvalid(['email' => 'email']);
        $this->post($url, ['email' => 'aa@ああ.net'])->assertInvalid(['email' => 'email']);
        $this->post($url, ['email' => 'aaa@bbb.net'])->assertInvalid(['email' => 'unique']);

        $this->post($url, ['password' => ''])->assertInvalid(['password' => 'required']);
        $this->post($url, ['password' => 'abcd123'])->assertInvalid(['password' => 'min']);
        $this->post($url, ['password' => 'abcd1234'])->assertValid('password');
    }
}
