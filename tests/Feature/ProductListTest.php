<?php

use App\Livewire\Frontend\ProductList;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


it('renders product list page successfully', function () {
    Livewire::test(ProductList::class)
        ->assertStatus(200)
        ->assertSee('Product List');
});

it('can create a product with picture upload', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('product.jpg');

    Livewire::test(ProductList::class)
        ->set('no', '1')
        ->set('group', 'CBC')
        ->set('product', 'cbc')
        ->set('name', 'Cambodia Beer Can')
        ->set('picture', $file)
        ->call('saveProduct')
        ->assertHasNoErrors();

    $product = Product::where('name', 'Cambodia Beer Can')->first();
    expect($product)->not->toBeNull();
    expect($product->pictures)->not->toBeEmpty();
    Storage::disk('public')->assertExists($product->pictures);
});

it('can edit a product and update picture', function () {
    Storage::fake('public');

    $product = Product::create([
        'no' => '2',
        'group' => 'EXPREZ',
        'product' => '300ml',
        'name' => 'Exprez 300ml',
        'pictures' => null,
    ]);

    $newFile = UploadedFile::fake()->image('updated_product.png');

    Livewire::test(ProductList::class)
        ->call('openEditModal', $product->id)
        ->set('name', 'Exprez Taste 300ml Updated')
        ->set('picture', $newFile)
        ->call('saveProduct');

    $freshProduct = $product->fresh();
    expect($freshProduct->name)->toBe('Exprez Taste 300ml Updated');
    expect($freshProduct->pictures)->not->toBeNull();
    Storage::disk('public')->assertExists($freshProduct->pictures);
});

it('can delete a product', function () {
    $product = Product::create([
        'no' => '3',
        'group' => 'WATER',
        'product' => '500ml',
        'name' => 'Kulara Water 500ml',
    ]);

    Livewire::test(ProductList::class)
        ->call('confirmDelete', $product->id)
        ->call('deleteProduct');

    expect(Product::find($product->id))->toBeNull();
});

it('can import products from excel file', function () {
    Storage::fake('local');

    // Create a temporary Excel file
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Group');
    $sheet->setCellValue('C1', 'Product');
    $sheet->setCellValue('D1', 'Name');
    $sheet->setCellValue('E1', 'pictures');

    $sheet->setCellValue('A2', '10');
    $sheet->setCellValue('B2', 'JUICE');
    $sheet->setCellValue('C2', 'ize_pet_300');
    $sheet->setCellValue('D2', 'Ize PET Orange 300ml');
    $sheet->setCellValue('E2', 'orange.jpg');

    $writer = new Xlsx($spreadsheet);
    $tempPath = tempnam(sys_get_temp_dir(), 'test_excel_') . '.xlsx';
    $writer->save($tempPath);

    $content = file_get_contents($tempPath);
    $file = UploadedFile::fake()->createWithContent('test_products.xlsx', $content);

    Livewire::test(ProductList::class)
        ->set('excelFile', $file)
        ->call('importExcel');

    expect(Product::where('name', 'Ize PET Orange 300ml')->exists())->toBeTrue();
    @unlink($tempPath);
});
