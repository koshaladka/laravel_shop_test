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

class ProductRentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentServiceMock = Mockery::mock(PaymentServiceInterface::class);
        $this->paymentServiceMock->shouldReceive('processPayment')->andReturn(true);

        $this->app->instance(PaymentServiceInterface::class, $this->paymentServiceMock);
    }

    public function test_rent_method_returns_correct_response()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create(['rental_price_per_hour' => 10]);

        $this->actingAs($user);

        $response = $this->postJson('/api/product/rent', [
            'id' => $product->id,
            'duration' => 4,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message',
            'success',
        ]);

        $response->assertJson([
            'message' => 'Product rent successfully',
            'success' => true,
        ]);

        $order = Order::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        $this->assertNotNull($order);
        $this->assertEquals('rent', $order->status);
        $this->assertNotNull($order->rented_at);
        $this->assertNotNull($order->return_at);
    }

    public function test_rent_method_returns_error_if_product_does_not_exist()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/product/rent', [
            'id' => 999999,
            'duration' => 4,
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'id',
            ],
        ]);
    }

    public function test_rent_method_returns_error_if_duration_is_invalid()
    {
        $user = User::factory()->create();

        $product = Product::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/product/rent', [
            'id' => $product->id,
            'duration' => 10, // Недопустимое значение
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'duration',
            ],
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
