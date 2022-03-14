<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function TOPページで、ブログ一覧が表される()
    {
        // Ver.8.51未満の場合で、500エラーが出た場合のエラー確認方法
        //
        // $this->withoutExceptionHandling();
        // ブラウザで確認できる場合は、ブラウザで確認する方法もある
        // エラーログを確認する

        // $this->withoutExceptionHandling();

        // $post1 = Post::factory()->create();
        // $post2 = Post::factory()->create();

        // $this->get('/')
        //     ->assertOk()
        //     ->assertSee($post1->title)
        //     ->assertSee($post2->title);

        $post1 = Post::factory()->hasComments(3)->create(['title' => 'ブログのタイトル1']);
        $post2 = Post::factory()->hasComments(5)->create(['title' => 'ブログのタイトル2']);
        Post::factory()->hasComments(1)->create();

        $this->get('/')
            ->assertOk()
            ->assertSee('ブログのタイトル1')
            ->assertSee('ブログのタイトル2')
            ->assertSee($post1->user->name)
            ->assertSee($post2->user->name)
            ->assertSee('（3件のコメント）')
            ->assertSee('（5件のコメント）')
            ->assertSeeInOrder([
                '（5件のコメント）',
                '（3件のコメント）',
                '（1件のコメント）',
            ]);
    }

    /** @test */
    function ブログの一覧で、非公開のブログは表示されない()
    {
        $post1 = Post::factory()->closed()->create([
            'title' => 'これは非公開のブログです',
        ]);
        $post2 = Post::factory()->create([
            'title' => 'これは公開済みのブログです',
        ]);

        $this->get('/')
            ->assertDontSee('これは非公開のブログです')
            ->assertSee('これは公開済みのブログです');
    }

    /** @test */
    function ブログの詳細画面が表示できる()
    {
        $post = Post::factory()->create();

        $this->get('posts/'.$post->id)
            ->assertOk()
            ->assertSee($post->title)
            ->assertSee($post->user->name);
    }

    /** @test */
    function ブログで非公開のものは、詳細画面は表示できない()
    {

    }

    /** @test */
    function factoryの観察()
    {
        // $post = Post::factory()->make(['user_id' => null]);
        // dump($post);
        // dump(Post::get()->toArray()); // 0

        // dump(User::get()->toArray());

        $this->assertTrue(true);
    }
}
