<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
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

        $response->assertOk();

        $this->assertCount(1,Book::all());
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
        $this->withoutExceptionHandling();
        $this->post('/books',[
            'title' => 'Good Book',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id,[
            'title' => 'new Book',
            'author' => 'Victor Dey',
        ]);

        $this->assertEquals('new Book' , Book::first()->title);
        $this->assertEquals('Victor Dey' , Book::first()->author);

    }




}
