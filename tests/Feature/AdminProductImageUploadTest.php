<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductImageUploadTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;
    private Brand $brand;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->category = Category::create(['name' => 'Shoes', 'is_active' => true]);
        $this->brand = Brand::create(['name' => 'Test Brand', 'is_active' => true]);
    }

    public function test_admin_can_create_a_product_with_main_and_gallery_images(): void
    {
        $response = $this->post(route('admin.products.store'), $this->validProductData([
            'image' => $this->validImage('main.jpg'),
            'extra_images' => [$this->validImage('gallery.jpg')],
        ]));

        $response->assertRedirect(route('admin.products.index'));
        $product = Product::firstOrFail();
        $this->assertNotEmpty($product->image);
        $this->assertCount(1, $product->extra_images);
        Storage::disk('public')->assertExists($product->image);
        Storage::disk('public')->assertExists($product->extra_images[0]);
        $response->assertSessionHas('success', fn (string $message) => str_contains($message, '2 images uploaded successfully'));
    }

    public function test_invalid_main_image_shows_a_field_error_and_saves_nothing(): void
    {
        $response = $this->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $this->validProductData([
                'image' => UploadedFile::fake()->createWithContent('not-an-image.txt', 'not an image'),
            ]));

        $response->assertRedirect(route('admin.products.create'));
        $response->assertSessionHasErrors('image');
        $this->assertDatabaseCount('products', 0);
        $this->assertSame([], Storage::disk('public')->allFiles('products'));
    }

    public function test_image_dimensions_are_validated_and_admin_forms_render_upload_feedback(): void
    {
        $this->get(route('admin.products.create'))
            ->assertOk()
            ->assertSee('No product image selected.')
            ->assertSee('image-upload-status');

        $product = Product::create($this->validProductData(['name' => 'Existing Product']));
        $this->get(route('admin.products.edit', $product))
            ->assertOk()
            ->assertSee('No product image selected.')
            ->assertSee('extra-upload-status');

        $tooSmall = UploadedFile::fake()->createWithContent(
            'small.png',
            file_get_contents(base_path('public/favicon.png'))
        );

        $response = $this->from(route('admin.products.create'))
            ->post(route('admin.products.store'), $this->validProductData(['image' => $tooSmall]));

        $response->assertRedirect(route('admin.products.create'));
        $response->assertSessionHasErrors('image');
        $this->assertDatabaseCount('products', 1);
    }

    public function test_admin_can_replace_main_image_and_remove_a_saved_gallery_image(): void
    {
        $oldMain = 'products/old-main.jpg';
        $oldGallery = 'products/old-gallery.jpg';
        Storage::disk('public')->put($oldMain, 'old main');
        Storage::disk('public')->put($oldGallery, 'old gallery');
        $product = Product::create($this->validProductData([
            'sku' => 'TEST-UPLOAD-1',
            'image' => $oldMain,
            'extra_images' => [$oldGallery],
        ]));

        $response = $this->put(route('admin.products.update', $product), $this->validProductData([
            'sku' => $product->sku,
            'image' => $this->validImage('replacement.jpg'),
            'extra_images' => [],
            'keep_extra_images' => [],
        ]));

        $response->assertRedirect(route('admin.products.index'));
        $product->refresh();
        $this->assertNotSame($oldMain, $product->image);
        $this->assertNull($product->extra_images);
        Storage::disk('public')->assertExists($product->image);
        Storage::disk('public')->assertMissing($oldMain);
        Storage::disk('public')->assertMissing($oldGallery);
        $response->assertSessionHas('success', fn (string $message) => str_contains($message, '1 image uploaded successfully'));
    }

    public function test_edit_without_a_new_main_image_keeps_the_current_image(): void
    {
        $existingImage = 'products/current-main.jpg';
        Storage::disk('public')->put($existingImage, 'current image');
        $product = Product::create($this->validProductData([
            'sku' => 'TEST-UPLOAD-2',
            'image' => $existingImage,
        ]));

        $response = $this->put(route('admin.products.update', $product), $this->validProductData([
            'name' => 'Updated Product',
            'sku' => $product->sku,
            'keep_extra_images' => [],
        ]));

        $response->assertRedirect(route('admin.products.index'));
        $this->assertSame($existingImage, $product->fresh()->image);
        Storage::disk('public')->assertExists($existingImage);
    }

    private function validProductData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Test Product',
            'description' => 'A test product description.',
            'price' => 1500,
            'original_price' => null,
            'category_id' => $this->category->id,
            'brand_id' => $this->brand->id,
            'stock_quantity' => 5,
            'is_active' => '1',
            'is_featured' => '0',
            'is_trending' => '0',
        ], $overrides);
    }

    private function validImage(string $name): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($name, file_get_contents(base_path('public/images/boots.jpg')));
    }
}
