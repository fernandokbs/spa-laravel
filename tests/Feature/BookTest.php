<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Book;
use App\User;
use App\Author;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->author = factory(Author::class)->create();
        $this->book = factory(Book::class)->create();
        $this->actingAs($this->user);
    }

    /**  @test */
    public function it_shows_a_collection_of_books()
    {
        $this->json('GET', "/api/books?api_token={$this->user->api_token}")
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $this->book->id , 
                        'slug' => $this->book->slug,
                        'attributes' => [
                            'title' => $this->book->title,
                            'description' => Str::limit($this->book->content, 50),
                            'picture' => $this->book->thumbnail,
                            'created_at' => $this->book->created_at->diffForHumans()
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
    public function it_shows_a_single_book()
    {
        $this->json('GET', "/api/books/{$this->book->slug}?api_token={$this->user->api_token}")
            ->assertStatus(200)
            ->assertJson([
                'id' => $this->book->id , 
                'attributes' => [
                    'title' => $this->book->title,
                    'description' => Str::limit($this->book->content, 50),
                    'picture' => $this->book->thumbnail,
                    'created_at' => $this->book->created_at->diffForHumans()
                ],
                'relationships' => [
                    'author' => [
                        'name' => $this->author->name
                    ]
                ]
            ]);
    }

    /**  @test */
    public function it_creates_a_single_book()
    {
        $this->assertEquals(1, Book::count());
        
        $data = [
            'title' => 'lorem insu dolor',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and',
            'author_id' => $this->author->id,
            'thumbnail' => 'https://picsum.photos/250/500',
            'api_token' => $this->user->api_token
        ];
        
        $this->json('POST', "/api/books", $data)
            ->assertStatus(201);
        $this->assertEquals(2, Book::count());
    }

    /**  @test */
    public function it_creates_a_single_book_fails()
    {
        $this->json('POST', "/api/books", ['api_token' => $this->user->api_token])
                ->assertStatus(422)
                ->assertJson([
                    "message" => "The given data was invalid.",
                    "errors" => []
                ]);
    }

    /**  @test */
    public function it_updates_a_single_book()
    {
        $data = [
            'title' => 'Nuevo titulo',
            'content' => 'Lorem insu dolor',
            'api_token' => $this->user->api_token
        ];

        $this->json('PUT', "/api/books/{$this->book->slug}", $data);
        $book = Book::find($this->book->id);
        $this->assertEquals($data['title'], $book->title);
        $this->assertEquals($data['content'], $book->content);
    }
    
    /**  @test */
    public function the_owner_can_delete_the_book()
    {
        $this->json('DELETE', "/api/books/{$this->book->slug}",['api_token' => $this->user->api_token])
            ->assertStatus(204);
        $this->assertNull(Book::find($this->book->id));
    }

    /**  @test */
    public function the_owner_can_delete_the_book_fails()
    {
        $user = factory(User::class)->create();
        $this->json('DELETE', "/api/books/{$this->book->slug}",['api_token' => $user->api_token])
            ->assertStatus(403);
    }
    
    /**  @test */
    public function user_can_add_a_comment_on_a_book()
    {
        $this->assertEquals(0, $this->book->comments()->count());

        $data = [
            'title' => 'Lorem Ipsum is simply dummy text',
            'content' => 'Lorem Ipsum is simply dummy text Lorem Ipsum is simply dummy text',
            'score' => 4,
            'api_token' => $this->user->api_token
        ];

        $response = $this->json('POST', "/api/books/{$this->book->slug}/comment", $data);
        $response->assertStatus(201);

        $this->assertEquals(1, $this->book->comments()->count());
    }
}
