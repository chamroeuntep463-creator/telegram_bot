<?php

namespace App\Livewire\Frontend;

use Livewire\Component;

class ProductAssessment extends Component
{
    public $code = 'PPT3';
    public $dealer = 'Leang Srun';
    public $subject = 'Product Assessment';
    public $sale_rep = '';
    public $date = '';

    public array $products = [
        ['id' => 'cbc', 'name' => 'CBC', 'category' => 'CBC', 'sub' => ''],
        ['id' => 'lite', 'name' => 'LITE', 'category' => 'LITE', 'sub' => ''],
        ['id' => 'cbb', 'name' => 'CBB', 'category' => 'CBB', 'sub' => ''],
        ['id' => 'cbp', 'name' => 'CBP', 'category' => 'CBP', 'sub' => ''],
        ['id' => 'cbsp', 'name' => 'CBSP', 'category' => 'CBSP', 'sub' => ''],
        ['id' => 'cbpl', 'name' => 'CBPL', 'category' => 'CBPL', 'sub' => ''],
        ['id' => 'wkz', 'name' => 'WKZ', 'category' => 'WKZ', 'sub' => ''],
        ['id' => 'wkz_ice', 'name' => 'WKZ ICE', 'category' => 'WKZ ICE', 'sub' => ''],
        ['id' => 'icy', 'name' => 'ICY', 'category' => 'ICY', 'sub' => ''],
        ['id' => 'dazz', 'name' => 'DAZZ', 'category' => 'DAZZ', 'sub' => ''],
        ['id' => 'ed', 'name' => 'ED', 'category' => 'ED', 'sub' => ''],
        ['id' => 'sport', 'name' => 'SPORT', 'category' => 'SPORT', 'sub' => ''],
        
        ['id' => 'exprez_300', 'name' => '300ml', 'category' => 'EXPREZ', 'sub' => '300ml'],
        ['id' => 'exprez_str', 'name' => 'STR', 'category' => 'EXPREZ', 'sub' => 'STR'],
        ['id' => 'exprez_mel', 'name' => 'MEL', 'category' => 'EXPREZ', 'sub' => 'MEL'],
        
        ['id' => 'cb_250', 'name' => '250ml', 'category' => 'CB Cola', 'sub' => '250ml'],
        ['id' => 'cb_330', 'name' => '330ml', 'category' => 'CB Cola', 'sub' => '330ml'],
        
        ['id' => 'ize_can_250', 'name' => '250ml', 'category' => 'IZE CAN ( All )', 'sub' => '250ml'],
        ['id' => 'ize_can_330', 'name' => '330ml', 'category' => 'IZE CAN ( All )', 'sub' => '330ml'],
        
        ['id' => 'ize_pet_300', 'name' => '300ml', 'category' => 'IZE PET ( All )', 'sub' => '300ml'],
        ['id' => 'ize_pet_500', 'name' => '500ml', 'category' => 'IZE PET ( All )', 'sub' => '500ml'],
        ['id' => 'ize_pet_15', 'name' => '1.5L', 'category' => 'IZE PET ( All )', 'sub' => '1.5L'],
        
        ['id' => 'water_350', 'name' => '350ml', 'category' => 'WATER', 'sub' => '350ml'],
        ['id' => 'water_500', 'name' => '500ml', 'category' => 'WATER', 'sub' => '500ml'],
        ['id' => 'water_15', 'name' => '1.5L', 'category' => 'WATER', 'sub' => '1.5L'],
    ];

    public array $rows = [];

    public function mount()
    {
        $this->date = date('Y-m-d');
        
        // Initialize with 10 empty rows
        for ($i = 1; $i <= 10; $i++) {
            $this->addRow();
        }

        // Prefill row 1 & row 2 for visual demonstration matching reference image
        $this->rows[0]['customer_name'] = '';
        $this->rows[0]['values']['cbc'] = 'មាន';
        
        $this->rows[1]['customer_name'] = '';
        $this->rows[1]['values']['cbc'] = 'លក់';
    }

    public function addRow()
    {
        $newRow = [
            'customer_name' => '',
            'address' => '',
            'values' => [],
            'remark' => '',
        ];

        foreach ($this->products as $prod) {
            $newRow['values'][$prod['id']] = '';
        }

        $this->rows[] = $newRow;
    }

    public function removeRow($index)
    {
        if (count($this->rows) > 1) {
            unset($this->rows[$index]);
            $this->rows = array_values($this->rows);
        }
    }

    public function clearAll()
    {
        foreach ($this->rows as &$row) {
            $row['customer_name'] = '';
            $row['address'] = '';
            $row['remark'] = '';
            foreach ($this->products as $prod) {
                $row['values'][$prod['id']] = '';
            }
        }
    }

    public function printAssessment()
    {
        $this->js('window.print()');
    }

    public function render()
    {
        return view('livewire.frontend.product-assessment')
            ->layout('backend.app');
    }
}
