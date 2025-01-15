<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    /** 商品詳細ページで必要な情報が表示される */
    public function test_product_detail_displays_correct_information()
    {
        $item = Item::factory()->create(['title' => 'スマホ']);

        $response = $this->get('/items/' . $item->id);

        $response->assertStatus(200)
                 ->assertSee($item->title)
                 ->assertSee($item->description);
    }
}
