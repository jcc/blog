<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomTest extends TestCase
{
    /**
     * test index page
     *
     * @return void
     */
    public function testIndexPage()
    {
        $this->visit('/')
            ->see('Blog')
            ->see('links');
    }
}
