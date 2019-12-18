<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Article;
use App\User;
use App\Author;
use App\Comment;

class articleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->article = factory(Article::class)->create();
        $this->actingAs($this->user);
    }

    /**  @test */
    public function it_shows_a_collection_of_article()
    {
        $this->json('GET', "/api/articles?api_token={$this->user->api_token}")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $this->article->id , 
                        'slug' => $this->article->slug,
                        'attributes' => [
                            'title' => $this->article->title,
                            'content' => Str::limit($this->article->content, 50),
                            'picture' => $this->article->thumbnail,
                            'created_at' => $this->article->created_at->diffForHumans()
                        ],
                    ]
                ]
            ]);
    }

    /**  @test */
    public function it_shows_a_single_article()
    {
        $this->json('GET', "/api/articles/{$this->article->slug}?api_token={$this->user->api_token}")
            ->assertStatus(200)
            ->assertJson([
                'id' => $this->article->id , 
                'user_id' => $this->article->user_id,
                'slug' => $this->article->slug,
                'attributes' => [
                    'title' => $this->article->title,
                    'content' => $this->article->content,
                    'picture' => $this->article->thumbnail,
                    'created_at' => $this->article->created_at->diffForHumans()
                ],
            ]);
    }

    /**  @test */
    public function it_creates_a_single_article()
    {
        $this->assertEquals(1, article::count());
        
        $data = [
            'title' => 'lorem insu dolor',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and',
            'thumbnail' => 'https://picsum.photos/250/500',
            'api_token' => $this->user->api_token
        ];
        
        $this->json('POST', "/api/articles", $data)
            ->assertStatus(201);
        $this->assertEquals(2, article::count());
    }

    /**  @test */
    public function it_creates_a_single_article_fails()
    {
        $this->json('POST', "/api/articles", ['api_token' => $this->user->api_token])
                ->assertStatus(422)
                ->assertJson([
                    "message" => "The given data was invalid.",
                    "errors" => []
                ]);
    }

    /**  @test */
    public function it_updates_a_single_article()
    {
        $data = [
            'title' => 'Nuevo titulo',
            'content' => 'Lorem insu dolor',
            'thumbnail' => 'heregoesanrul',
            'api_token' => $this->user->api_token
        ];

        $this->json('PUT', "/api/articles/{$this->article->slug}", $data);
        $article = article::find($this->article->id);
        $this->assertEquals($data['title'], $article->title);
        $this->assertEquals($data['content'], $article->content);
    }
    
    /**  @test */
    public function the_owner_can_delete_the_article()
    {
        $this->json('DELETE', "/api/articles/{$this->article->slug}",['api_token' => $this->user->api_token])
            ->assertStatus(204);
        $this->assertNull(article::find($this->article->id));
    }

    /**  @test */
    public function the_owner_can_delete_the_article_fails()
    {
        $user = factory(User::class)->create();
        $this->json('DELETE', "/api/articles/{$this->article->slug}",['api_token' => $user->api_token])
            ->assertStatus(403);
    }
    
    /**  @test */
    public function user_can_add_a_comment_on_a_article()
    {
        $this->withoutExceptionHandling();

        $this->assertEquals(0, Comment::count());

        $data = [
            'title' => 'Lorem Ipsum is simply dummy text',
            'content' => 'Lorem Ipsum is simply dummy text Lorem Ipsum is simply dummy text',
            'score' => 4,
            'article_id' => $this->user->id,
            'api_token' => $this->user->api_token
        ];

        $response = $this->json('POST', "/api/articles/{$this->article->slug}/comment", $data);
        $response->assertStatus(201);

        $this->assertEquals(1, Comment::count());
    }
}
