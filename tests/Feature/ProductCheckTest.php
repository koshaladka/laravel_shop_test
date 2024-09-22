<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Str;

class ProductCheckTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_check_method_returns_correct_response()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/product/check', ['id' => $product->id]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'unique_code',
            'available',
        ]);

        $order = Order::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        $this->assertNotNull($order);
        $this->assertEquals($response->json('unique_code'), $order->unique_code);
    }

    /** @test */
    public function it_check_method_returns_error_if_product_does_not_exist()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/product/check', ['id' => 999999]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'id',
            ],
        ]);
    }
}
