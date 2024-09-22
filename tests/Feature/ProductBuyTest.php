<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Contracts\PaymentServiceInterface;
use Mockery;

class ProductBuyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the PaymentServiceInterface
        $this->paymentServiceMock = Mockery::mock(PaymentServiceInterface::class);
        $this->paymentServiceMock->shouldReceive('processPayment')->andReturn(true);

        $this->app->instance(PaymentServiceInterface::class, $this->paymentServiceMock);
    }

    public function test_buy_method_returns_correct_response()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create(['price' => 100]);

        $this->actingAs($user);

        $response = $this->postJson('api/product/buy', [
            'id' => $product->id,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message',
            'success',
        ]);

        $response->assertJson([
            'message' => 'Product purchased successfully',
            'success' => true,
        ]);

        $order = Order::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        $this->assertNotNull($order);
        $this->assertEquals('sale', $order->status);
    }

    public function test_buy_method_returns_error_if_product_does_not_exist()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('api/product/buy', [
            'id' => 999999,
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'id',
            ],
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
