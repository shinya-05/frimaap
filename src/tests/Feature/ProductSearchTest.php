<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    /** 商品名で部分一致検索ができる */
    public function test_can_search_by_product_name()
    {
        Item::factory()->create(['title' => 'スマホ']);
        Item::factory()->create(['title' => 'パソコン']);

        $response = $this->get('/?search=スマホ');

        $response->assertStatus(200)
                 ->assertSee('スマホ')
                 ->assertDontSee('パソコン');
    }

    /** 検索状態がマイリストでも保持される */
    public function test_search_keyword_is_retained_in_mylist()
    {
        $response = $this->get('/mylist?search=スマホ');

        $response->assertStatus(200)
                 ->assertSee('スマホ');
    }
}
