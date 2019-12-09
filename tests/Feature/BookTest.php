<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->actingAs($this->user);
    }

    /**  @test */
    public function it_shows_a_collection_of_books()
    {
        $author = factory(Author::class)->create();
        $book = factory(Book::class)->create();
        
        $response = $this->json('GET', '/api/books');
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $book->id , 
                        'attributes' => [
                            'title' => $book->title,
                            'description' => $book->content,
                            'picture' => $book->thumbnail,
                            'created_at' => $book->created_at->diffForHumans()
                        ],
                        'relationships' => [
                            'author' => [
                                'name' => $author->name
                            ]
                        ]
                    ]
                ]
            ]);
    }

    /**  @test */
    public function it_shows_a_single_book()
    {
        $author = factory(Author::class)->create();
        $book = factory(Book::class)->create();

        $response = $this->json('GET', "/api/books/{$book->id}");
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $book->id , 
                'attributes' => [
                    'title' => $book->title,
                    'description' => $book->content,
                    'picture' => $book->thumbnail,
                    'created_at' => $book->created_at->diffForHumans()
                ],
                'relationships' => [
                    'author' => [
                        'name' => $author->name
                    ]
                ]
            ]);
    }

    /**  @test */
    public function it_creates_a_single_book()
    {
        $this->withoutExceptionHandling();
        
        $author = factory(Author::class)->create();
        $this->assertEquals(0, Book::count());
        
        $data = [
            'title' => 'lorem insu dolor',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
            'author_id' => $author->id,
            'thumbnail' => 'https://picsum.photos/250/500'
        ];
        
        $response = $this->json('POST', "/api/books", $data);
        $response->assertStatus(201);

        $this->assertEquals(1, Book::count());
    }

    /**  @test */
    public function it_creates_a_single_book_fails()
    {
        $response = $this->json('POST', "/api/books", []);
        $response->assertStatus(422)
                ->assertJson([
                    "message" => "The given data was invalid.",
                    "errors" => []
                ]);
    }

    /**  @test */
    public function it_updates_a_single_book()
    {
        $author = factory(Author::class)->create();
        $book = factory(Book::class)->create();

        $data = [
            'title' => 'Nuevo titulo',
            'content' => 'Lorem insu dolor'
        ];

        $response = $this->json('PUT', "/api/books/{$book->id}", $data);
        $book = Book::find($book->id);

        $this->assertEquals($data['title'], $book->title);
        $this->assertEquals($data['content'], $book->content);
    }
    
    /**  @test */
    public function it_deletes_a_single_book()
    {
        $author = factory(Author::class)->create();
        $book = factory(Book::class)->create();

        $this->json('DELETE', "/api/books/{$book->id}")
            ->assertStatus(204);
        
        $this->assertNull(Book::find($book->id));
    }
}
