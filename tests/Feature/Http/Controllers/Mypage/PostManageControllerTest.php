<?php

namespace Tests\Feature\Http\Controllers\Mypage;

use App\Models\Comment;
use App\Models\Post;
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
        $this->get('mypage/posts/create')->assertRedirect($loginUrl);
        $this->post('mypage/posts/create', [])->assertRedirect($loginUrl);
        $this->get('mypage/posts/edit/1')->assertRedirect($loginUrl);
        $this->post('mypage/posts/edit/1', [])->assertRedirect($loginUrl);
        $this->delete('mypage/posts/delete/1')->assertRedirect($loginUrl);
    }

    /** @test */
    function マイページ、ブログ一覧で自分のデータのみ表示される()
    {
        $user = $this->login();

        $other = Post::factory()->create();
        $mypost = Post::factory()->create(['user_id' => $user->id]);

        $this->get('mypage/posts')
            ->assertOk()
            ->assertDontSee($other->title)
            ->assertSee($mypost->title);
    }

    /** @test */
    function マイページ、ブログの新規登録画面を開ける()
    {
        $this->login();

        $this->get('mypage/posts/create')
            ->assertOk();
    }

    /** @test */
    function マイページ、ブログを新規登録できる、公開の場合()
    {
        [$taro, $me, $jiro] = User::factory(3)->create();

        $this->login($me);

        $validData = [
            'title' => '私のブログタイトル',
            'body' => '私のブログ本文',
            'status' => '1',
        ];

        // $this->post('mypage/posts/create', $validData)
        //     ->assertRedirect('mypage/posts/edit/1'); // SQLiteのインメモリ

        $response = $this->post('mypage/posts/create', $validData);

        $post = Post::first();

        $response->assertRedirect('mypage/posts/edit/'.$post->id);

        $this->assertDatabaseHas('posts', array_merge($validData, ['user_id' => $me->id]));
    }

    /** @test */
    function マイページ、ブログを新規登録できる、非公開の場合()
    {
        // $this->markTestIncomplete();
        [$taro, $me, $jiro] = User::factory(3)->create();

        $this->login($me);

        $validData = [
            'title' => '私のブログタイトル',
            'body' => '私のブログ本文',
            // 'status' => '1',
        ];

        $this->post('mypage/posts/create', $validData);

        $this->assertDatabaseHas('posts', array_merge($validData, [
            'user_id' => $me->id,
            'status' => 0,
        ]));
    }

    /** @test */
    function マイページ、ブログの登録時の入力チェック()
    {
        $url = 'mypage/posts/create';

        $this->login();

        $this->from($url)->post($url, [])
            ->assertRedirect($url);

        app()->setLocale('testing');

        $this->post($url, ['title' => ''])->assertInvalid(['title' => 'required']);
        $this->post($url, ['title' => str_repeat('a', 256)])->assertInvalid(['title' => 'max']);
        $this->post($url, ['title' => str_repeat('a', 255)])->assertValid('title');
        $this->post($url, ['body' => ''])->assertInvalid(['body' => 'required']);
    }

    /** @test */
    function 自分のブログの編集画面は開ける()
    {
        $post = Post::factory()->create();

        $this->login($post->user);

        $this->get('mypage/posts/edit/'.$post->id)
            ->assertOk();
    }

    /** @test */
    function 他人様のブログの編集画面は開けない()
    {
        $post = Post::factory()->create();

        $this->login();

        $this->get('mypage/posts/edit/'.$post->id)
            ->assertForbidden();
    }

    /** @test */
    function 自分のブログは更新できる()
    {
        $validData = [
            'title' => '新タイトル',
            'body' => '新本文',
            'status' => '1',
        ];

        $post = Post::factory()->create();

        $this->login($post->user);

        $this->post('mypage/posts/edit/'.$post->id, $validData)
            ->assertRedirect('mypage/posts/edit/'.$post->id);

        $this->get('mypage/posts/edit/'.$post->id)
            ->assertSee('ブログを更新しました');

        // DBに登録されている事は確認したが、新規で追加されたかも知れない。なので不完全と言えば、不完全
        $this->assertDatabaseHas('posts', $validData);

        $this->assertCount(1, Post::all());
        $this->assertSame(1, Post::count());

        // 項目が少ない時は、fresh()を使って
        $this->assertSame('新タイトル', $post->fresh()->title);
        $this->assertSame('新本文', $post->fresh()->body);

        // 項目が多い時は、refresh()を使って
        $post->refresh();
        $this->assertSame('新本文', $post->body);
        $this->assertSame('新本文', $post->body);
        $this->assertSame('新本文', $post->body);
        $this->assertSame('新本文', $post->body);
        $this->assertSame('新本文', $post->body);
        $this->assertSame('新本文', $post->body);
    }

    /** @test */
    function 他人様のブログは更新できない()
    {
        $validData = [
            'title' => '新タイトル',
            'body' => '新本文',
            'status' => '1',
        ];

        $post = Post::factory()->create(['title' => '元のブログタイトル']);

        $this->login();

        $this->post('mypage/posts/edit/'.$post->id, $validData)
            ->assertForbidden();

        $this->assertSame('元のブログタイトル', $post->fresh()->title);
    }

    /** @test */
    function 自分のブログは削除できる、且つ付随するコメントも削除される()
    {
        $post = Post::factory()->create();

        $myPostComment = Comment::factory()->create(['post_id' => $post->id]);
        $otherPostComment = Comment::factory()->create();

        $this->login($post->user);

        $this->delete('mypage/posts/delete/'.$post->id)
            ->assertRedirect('mypage/posts');

        // assertDeletedは、Ver.9で削除（Delete）された。
        // Ver.8.61～以降は、assertModelMissing() を使いましょう。
        $this->assertModelMissing($post);

        $this->assertModelMissing($myPostComment);
        $this->assertModelExists($otherPostComment);
    }

    /** @test */
    function 他人様のブログを削除はできない()
    {
        $post = Post::factory()->create();

        $this->login();

        $this->delete('mypage/posts/delete/'.$post->id)
            ->assertForbidden();

        $this->assertModelExists($post);
    }
}
