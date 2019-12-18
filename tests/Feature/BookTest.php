<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Article;
use App\User;
use App\Author;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->author = factory(Author::class)->create();
        $this->Article = factory(Article::class)->create();
        $this->actingAs($this->user);
    }

    /**  @test */
    public function it_shows_a_collection_of_Articles()
    {
        $this->json('GET', "/api/Articles?api_token={$this->user->api_token}")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $this->Article->id , 
                        'slug' => $this->Article->slug,
                        'attributes' => [
                            'title' => $this->Article->title,
                            'content' => Str::limit($this->Article->content, 50),
                            'picture' => $this->Article->thumbnail,
                            'created_at' => $this->Article->created_at->diffForHumans()
                        ],
                        'relationships' => [
                            'author' => [
                                'name' => $this->author->name
                            ]
                        ]
                    ]
                ]
            ]);
    }

    /**  @test */
    public function it_shows_a_single_Article()
    {
        $this->json('GET', "/api/Articles/{$this->Article->slug}?api_token={$this->user->api_token}")
            ->assertStatus(200)
            ->assertJson([
                'id' => $this->Article->id , 
                'attributes' => [
                    'title' => $this->Article->title,
                    'content' => Str::limit($this->Article->content, 50),
                    'picture' => $this->Article->thumbnail,
                    'created_at' => $this->Article->created_at->diffForHumans()
                ],
                'relationships' => [
                    'author' => [
                        'name' => $this->author->name
                    ]
                ]
            ]);
    }

    /**  @test */
    public function it_creates_a_single_Article()
    {
        $this->assertEquals(1, Article::count());
        
        $data = [
            'title' => 'lorem insu dolor',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and',
            'author_id' => $this->author->id,
            'thumbnail' => 'https://picsum.photos/250/500',
            'api_token' => $this->user->api_token
        ];
        
        $this->json('POST', "/api/Articles", $data)
            ->assertStatus(201);
        $this->assertEquals(2, Article::count());
    }

    /**  @test */
    public function it_creates_a_single_Article_fails()
    {
        $this->json('POST', "/api/Articles", ['api_token' => $this->user->api_token])
                ->assertStatus(422)
                ->assertJson([
                    "message" => "The given data was invalid.",
                    "errors" => []
                ]);
    }

    /**  @test */
    public function it_updates_a_single_Article()
    {
        $data = [
            'title' => 'Nuevo titulo',
            'content' => 'Lorem insu dolor',
            'api_token' => $this->user->api_token
        ];

        $this->json('PUT', "/api/Articles/{$this->Article->slug}", $data);
        $Article = Article::find($this->Article->id);
        $this->assertEquals($data['title'], $Article->title);
        $this->assertEquals($data['content'], $Article->content);
    }
    
    /**  @test */
    public function the_owner_can_delete_the_Article()
    {
        $this->json('DELETE', "/api/Articles/{$this->Article->slug}",['api_token' => $this->user->api_token])
            ->assertStatus(204);
        $this->assertNull(Article::find($this->Article->id));
    }

    /**  @test */
    public function the_owner_can_delete_the_Article_fails()
    {
        $user = factory(User::class)->create();
        $this->json('DELETE', "/api/Articles/{$this->Article->slug}",['api_token' => $user->api_token])
            ->assertStatus(403);
    }
    
    /**  @test */
    public function user_can_add_a_comment_on_a_Article()
    {
        $this->assertEquals(0, $this->Article->comments()->count());

        $data = [
            'title' => 'Lorem Ipsum is simply dummy text',
            'content' => 'Lorem Ipsum is simply dummy text Lorem Ipsum is simply dummy text',
            'score' => 4,
            'api_token' => $this->user->api_token
        ];

        $response = $this->json('POST', "/api/Articles/{$this->Article->slug}/comment", $data);
        $response->assertStatus(201);

        $this->assertEquals(1, $this->Article->comments()->count());
    }
}
