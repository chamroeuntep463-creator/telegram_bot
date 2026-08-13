<?php

namespace App\Livewire\Frontend;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductList extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public int $perPage = 10;

    // Modals control
    public bool $showModal = false;
    public bool $showImportModal = false;
    public bool $showDeleteModal = false;
    public bool $isEditMode = false;

    // Product Form Fields
    public ?int $editingProductId = null;
    public ?int $deletingProductId = null;

    public string $no = '';
    public string $group = '';
    public string $product = '';
    public string $name = '';
    public mixed $picture = null; // Uploaded File or existing path
    public ?string $existingPicture = null;

    // Excel Import Fields
    public mixed $excelFile = null;
    public string $importSuccessMessage = '';
    public array $importErrors = [];

    protected function rules()
    {
        return [
            'no' => 'nullable|string|max:255',
            'group' => 'nullable|string|max:255',
            'product' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'picture' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,bmp,svg,jfif|max:10240',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Product name is required.',
            'picture.file' => 'The uploaded picture must be a file.',
            'picture.mimes' => 'The picture must be an image file (jpg, jpeg, png, gif, webp, svg, jfif).',
            'picture.max' => 'The picture file size must not exceed 10MB.',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $productModel = Product::findOrFail($id);
        $this->editingProductId = $productModel->id;
        $this->no = $productModel->no ?? '';
        $this->group = $productModel->group ?? '';
        $this->product = $productModel->product ?? '';
        $this->name = $productModel->name ?? '';
        $this->existingPicture = $productModel->pictures;
        $this->picture = null;
        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function removeImage()
    {
        $this->picture = null;
        $this->existingPicture = null;
    }

    public function resetForm()
    {
        $this->editingProductId = null;
        $this->no = '';
        $this->group = '';
        $this->product = '';
        $this->name = '';
        $this->picture = null;
        $this->existingPicture = null;
        $this->resetErrorBag();
    }

    public function saveProduct()
    {
        $this->validate();

        $picturePath = $this->existingPicture;

        if ($this->picture) {
            if (is_object($this->picture) && method_exists($this->picture, 'store')) {
                Storage::disk('public')->makeDirectory('products');

                // Delete old picture if updating
                if ($this->existingPicture && Storage::disk('public')->exists($this->existingPicture)) {
                    Storage::disk('public')->delete($this->existingPicture);
                }
                
                $picturePath = $this->picture->store('products', 'public');
            } elseif (is_string($this->picture)) {
                $picturePath = $this->picture;
            }
        }

        if ($this->isEditMode && $this->editingProductId) {
            $productModel = Product::findOrFail($this->editingProductId);
            $productModel->update([
                'no' => $this->no,
                'group' => $this->group,
                'product' => $this->product,
                'name' => $this->name,
                'pictures' => $picturePath,
            ]);
            session()->flash('message', 'Product updated successfully!');
        } else {
            Product::create([
                'no' => $this->no,
                'group' => $this->group,
                'product' => $this->product,
                'name' => $this->name,
                'pictures' => $picturePath,
            ]);
            session()->flash('message', 'Product added successfully!');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->deletingProductId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteProduct()
    {
        if ($this->deletingProductId) {
            $productModel = Product::find($this->deletingProductId);
            if ($productModel) {
                if ($productModel->pictures && Storage::disk('public')->exists($productModel->pictures)) {
                    Storage::disk('public')->delete($productModel->pictures);
                }
                $productModel->delete();
                session()->flash('message', 'Product deleted successfully!');
            }
        }

        $this->showDeleteModal = false;
        $this->deletingProductId = null;
    }

    public function openImportModal()
    {
        $this->excelFile = null;
        $this->importSuccessMessage = '';
        $this->importErrors = [];
        $this->showImportModal = true;
    }

    public function closeImportModal()
    {
        $this->showImportModal = false;
        $this->excelFile = null;
        $this->importSuccessMessage = '';
        $this->importErrors = [];
    }

    public function importExcel()
    {
        $this->importErrors = [];
        $this->importSuccessMessage = '';

        try {
            $this->validate([
                'excelFile' => 'required|file|max:10240', // 10MB max
            ], [
                'excelFile.required' => 'Please select an Excel file (.xlsx, .xls, .csv) to upload.',
                'excelFile.file' => 'The uploaded item must be a valid file.',
                'excelFile.max' => 'The Excel file size must not exceed 10MB.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            foreach ($e->validator->errors()->all() as $errorMsg) {
                $this->importErrors[] = $errorMsg;
            }
            return;
        }

        try {
            $filePath = $this->excelFile->getRealPath();
            
            // Check file extension manually to ensure valid excel/csv
            $extension = strtolower($this->excelFile->getClientOriginalExtension());
            if (!in_array($extension, ['xlsx', 'xls', 'csv'])) {
                $this->importErrors[] = "Invalid file type (.$extension). Please upload an Excel file (.xlsx, .xls) or CSV file (.csv).";
                return;
            }

            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray(null, true, true, true);

            if (empty($rows)) {
                $this->importErrors[] = 'The uploaded Excel file is empty.';
                return;
            }

            // Determine if row 1 is header or data
            $firstRow = reset($rows);
            $colMap = [
                'no' => null,
                'group' => null,
                'product' => null,
                'name' => null,
                'pictures' => null,
            ];

            $isHeader = false;
            foreach ($firstRow as $colLetter => $cellVal) {
                $clean = strtolower(trim((string)$cellVal));
                if (in_array($clean, ['no', 'no.', 'number', '#', 'id'])) {
                    $colMap['no'] = $colLetter;
                    $isHeader = true;
                } elseif (in_array($clean, ['group', 'category', 'group_name', 'group name'])) {
                    $colMap['group'] = $colLetter;
                    $isHeader = true;
                } elseif (in_array($clean, ['product', 'code', 'product_code', 'product code', 'sku'])) {
                    $colMap['product'] = $colLetter;
                    $isHeader = true;
                } elseif (in_array($clean, ['name', 'product_name', 'product name', 'title'])) {
                    $colMap['name'] = $colLetter;
                    $isHeader = true;
                } elseif (in_array($clean, ['pictures', 'picture', 'image', 'images', 'photo', 'photos'])) {
                    $colMap['pictures'] = $colLetter;
                    $isHeader = true;
                }
            }

            // Remove header row if row 1 was recognized as a header
            if ($isHeader) {
                array_shift($rows);
            }

            // Fallback column mapping A -> No, B -> Group, C -> Product, D -> Name, E -> pictures
            if (is_null($colMap['no'])) $colMap['no'] = 'A';
            if (is_null($colMap['group'])) $colMap['group'] = 'B';
            if (is_null($colMap['product'])) $colMap['product'] = 'C';
            if (is_null($colMap['name'])) $colMap['name'] = 'D';
            if (is_null($colMap['pictures'])) $colMap['pictures'] = 'E';

            $importedCount = 0;

            foreach ($rows as $rowIndex => $row) {
                $noVal = isset($colMap['no']) && isset($row[$colMap['no']]) ? trim((string)$row[$colMap['no']]) : '';
                $groupVal = isset($colMap['group']) && isset($row[$colMap['group']]) ? trim((string)$row[$colMap['group']]) : '';
                $productVal = isset($colMap['product']) && isset($row[$colMap['product']]) ? trim((string)$row[$colMap['product']]) : '';
                $nameVal = isset($colMap['name']) && isset($row[$colMap['name']]) ? trim((string)$row[$colMap['name']]) : '';
                $picturesVal = isset($colMap['pictures']) && isset($row[$colMap['pictures']]) ? trim((string)$row[$colMap['pictures']]) : '';

                // Skip completely empty rows
                if ($noVal === '' && $groupVal === '' && $productVal === '' && $nameVal === '' && $picturesVal === '') {
                    continue;
                }

                if (!empty($productVal)) {
                    Product::updateOrCreate(
                        ['product' => $productVal],
                        [
                            'no' => $noVal,
                            'group' => $groupVal,
                            'name' => $nameVal ?: $productVal,
                            'pictures' => $picturesVal ?: null,
                        ]
                    );
                } else {
                    Product::create([
                        'no' => $noVal,
                        'group' => $groupVal,
                        'product' => $productVal,
                        'name' => $nameVal ?: ('Product ' . ($importedCount + 1)),
                        'pictures' => $picturesVal ?: null,
                    ]);
                }

                $importedCount++;
            }

            if ($importedCount === 0) {
                $this->importErrors[] = 'No valid data rows found in the uploaded file.';
                return;
            }

            $this->importSuccessMessage = "Successfully imported {$importedCount} products!";
            session()->flash('message', $this->importSuccessMessage);
            $this->closeImportModal();
        } catch (\Exception $e) {
            $this->importErrors[] = 'Failed to process Excel file: ' . $e->getMessage();
        }
    }

    public function downloadSampleTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header Row
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Group');
        $sheet->setCellValue('C1', 'Product');
        $sheet->setCellValue('D1', 'Name');
        $sheet->setCellValue('E1', 'pictures');

        // Styling header
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        // Sample Data Rows
        $samples = [
            ['1', 'CBC', 'cbc', 'Cambodia Beer Can', ''],
            ['2', 'EXPREZ', '300ml', 'Exprez Taste 300ml', ''],
            ['3', 'EXPREZ', 'STR', 'Exprez Strawberry', ''],
            ['4', 'CB Cola', '250ml', 'CB Cola 250ml', ''],
            ['5', 'WATER', '500ml', 'Kulara Water 500ml', ''],
        ];

        $rowNum = 2;
        foreach ($samples as $sample) {
            $sheet->setCellValue('A' . $rowNum, $sample[0]);
            $sheet->setCellValue('B' . $rowNum, $sample[1]);
            $sheet->setCellValue('C' . $rowNum, $sample[2]);
            $sheet->setCellValue('D' . $rowNum, $sample[3]);
            $sheet->setCellValue('E' . $rowNum, $sample[4]);
            $rowNum++;
        }

        $writer = new Xlsx($spreadsheet);
        $tempPath = tempnam(sys_get_temp_dir(), 'sample_products_') . '.xlsx';
        $writer->save($tempPath);

        return response()->download($tempPath, 'sample_products.xlsx')->deleteFileAfterSend(true);
    }

    public function render()
    {
        $products = Product::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('group', 'like', '%' . $this->search . '%')
                    ->orWhere('product', 'like', '%' . $this->search . '%')
                    ->orWhere('no', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);

        return view('livewire.frontend.product-list', [
            'products' => $products,
        ])->layout('backend.app');
    }
}
