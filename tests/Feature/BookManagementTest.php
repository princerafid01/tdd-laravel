<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => 'Cool Book',
            'author' => 'Rafid Khan',
        ]);

        $book = Book::first();

        $this->assertCount(1,Book::all());
        $response->assertRedirect('/books/' . $book->id);
    }

    /** @test */
    public function a_title_is_required()
    {
        $response = $this->post('/books',[
            'title' => '',
            'author' => 'Rafid Khan',
        ]);

        $response->assertSessionHasErrors('title');
    }


    /** @test */
    public function a_author_is_required()
    {
        $response = $this->post('/books',[
            'title' => 'Good Book',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->post('/books',[
            'title' => 'Good Book',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(),[
            'title' => 'new Book',
            'author' => 'Victor Dey',
        ]);

        $this->assertEquals('new Book' , Book::first()->title);
        $this->assertEquals('Victor Dey' , Book::first()->author);
        $response->assertRedirect('/books/' . $book->id);

    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withExceptionHandling();
        $this->post('/books',[
            'title' => 'Good Book',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        $this->assertCount(1 , Book::all());

        $response = $this->delete($book->path());

        $this->assertCount(0 , Book::all());
        $response->assertRedirect('/books');
    }





}
