<div class="p-4 bg-white block border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <!-- Header & Action Toolbar -->
    <div class="mb-4">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div class="sm:flex-1">
                <h1 class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white flex items-center gap-2">
                    <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Product List
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage products, import excel data, edit, and delete items.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-2 mt-3 sm:mt-0">
                <!-- Download Sample Template Button -->
                <button wire:click="downloadSampleTemplate" type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Sample Template
                </button>

                <!-- Excel Import Button -->
                <button wire:click="openImportModal" type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Import Excel
                </button>

                <!-- Add New Product Button -->
                <button wire:click="openCreateModal" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Product
                </button>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session()->has('message'))
            <div class="p-4 my-3 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800 flex items-center justify-between" role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <!-- Search Bar -->
        <div class="mt-4 flex items-center justify-between">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search product name, group, code..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            </div>
            <div class="text-xs text-gray-500 dark:text-gray-400">
                Total Products: <span class="font-bold text-gray-900 dark:text-white">{{ $products->total() }}</span>
            </div>
        </div>
    </div>

    <!-- Product Table -->
    <div class="overflow-x-auto relative rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-600">
                <tr>
                    <th scope="col" class="py-3.5 px-4 w-16 text-center">No</th>
                    <th scope="col" class="py-3.5 px-4 w-20 text-center">Picture</th>
                    <th scope="col" class="py-3.5 px-4">Group</th>
                    <th scope="col" class="py-3.5 px-4">Product</th>
                    <th scope="col" class="py-3.5 px-4">Name</th>
                    <th scope="col" class="py-3.5 px-4 text-center w-32">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($products as $index => $item)
                    <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="py-3 px-4 text-center font-medium text-gray-900 dark:text-white">
                            {{ $item->no ?: ($products->firstItem() + $index) }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if ($item->pictures)
                                @if(str_starts_with($item->pictures, 'http://') || str_starts_with($item->pictures, 'https://'))
                                    <img src="{{ $item->pictures }}" alt="{{ $item->name }}" class="w-10 h-10 object-cover rounded-lg mx-auto border border-gray-200 dark:border-gray-600">
                                @elseif(\Illuminate\Support\Facades\Storage::disk('public')->exists($item->pictures))
                                    <img src="{{ asset('storage/' . $item->pictures) }}" alt="{{ $item->name }}" class="w-10 h-10 object-cover rounded-lg mx-auto border border-gray-200 dark:border-gray-600">
                                @else
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center mx-auto text-gray-400 text-xs border border-gray-200 dark:border-gray-600">
                                        No Image
                                    </div>
                                @endif
                            @else
                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center mx-auto text-gray-400 border border-gray-200 dark:border-gray-600">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($item->group)
                                <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                                    {{ $item->group }}
                                </span>
                            @else
                                <span class="text-gray-400 italic text-xs">-</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 font-mono text-sm text-gray-800 dark:text-gray-200">
                            {{ $item->product ?: '-' }}
                        </td>
                        <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">
                            {{ $item->name }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Edit Button -->
                                <button wire:click="openEditModal({{ $item->id }})" type="button" class="p-1.5 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg dark:text-blue-400 dark:hover:bg-gray-700 transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <!-- Delete Button -->
                                <button wire:click="confirmDelete({{ $item->id }})" type="button" class="p-1.5 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-gray-700 transition-colors" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-base font-medium">No products found</p>
                                <p class="text-xs mt-1">Try importing an Excel file or click "Add Product" to add your first product.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $products->links() }}
    </div>

    <!-- Create / Edit Product Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-gray-900/60 backdrop-blur-sm p-4">
            <div class="relative w-full max-w-lg bg-white rounded-xl shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $isEditMode ? 'Edit Product' : 'Add New Product' }}
                    </h3>
                    <button wire:click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>

                <!-- Modal body -->
                <form wire:submit.prevent="saveProduct" class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-900 dark:text-white">No</label>
                            <input wire:model="no" type="text" placeholder="e.g. 1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('no') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-900 dark:text-white">Group</label>
                            <input wire:model="group" type="text" placeholder="e.g. CBC, EXPREZ" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('group') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-900 dark:text-white">Product Code</label>
                            <input wire:model="product" type="text" placeholder="e.g. cbc, 300ml" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('product') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-900 dark:text-white">Name <span class="text-red-500">*</span></label>
                            <input wire:model="name" type="text" placeholder="e.g. Cambodia Beer" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Picture Upload & Image URL -->
                    <div class="space-y-3">
                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-900 dark:text-white">Product Picture File</label>
                            <input wire:model="picture" type="file" accept="image/*" wire:key="picture-file-input-{{ $editingProductId ?? 'create' }}" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                            <div wire:loading wire:target="picture" class="text-xs text-blue-600 dark:text-blue-400 font-medium mt-1 flex items-center gap-1">
                                <span class="animate-spin inline-block w-3.5 h-3.5 border-2 border-blue-600 border-t-transparent rounded-full"></span>
                                Uploading image...
                            </div>
                            @error('picture') <span class="text-xs text-red-500 block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-1 text-xs font-medium text-gray-700 dark:text-gray-300">Or Image URL / Path</label>
                            <input wire:model="existingPicture" type="text" placeholder="e.g. https://example.com/photo.jpg or products/sample.jpg" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <!-- Image Preview -->
                        <div class="mt-2">
                            @if ($picture)
                                <div class="flex items-center gap-3 bg-gray-50 dark:bg-gray-700/50 p-2 rounded-lg border border-gray-200 dark:border-gray-600">
                                    <img src="{{ $picture->temporaryUrl() }}" class="w-14 h-14 object-cover rounded-lg border border-gray-300">
                                    <div>
                                        <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold block">New Image Selected</span>
                                        <button wire:click="$set('picture', null)" type="button" class="text-xs text-red-500 hover:underline mt-0.5">Remove Selected File</button>
                                    </div>
                                </div>
                            @elseif ($existingPicture)
                                <div class="flex items-center gap-3 bg-gray-50 dark:bg-gray-700/50 p-2 rounded-lg border border-gray-200 dark:border-gray-600">
                                    @if(str_starts_with($existingPicture, 'http'))
                                        <img src="{{ $existingPicture }}" class="w-14 h-14 object-cover rounded-lg border border-gray-300">
                                    @elseif(\Illuminate\Support\Facades\Storage::disk('public')->exists($existingPicture))
                                        <img src="{{ asset('storage/' . $existingPicture) }}" class="w-14 h-14 object-cover rounded-lg border border-gray-300">
                                    @else
                                        <img src="{{ asset($existingPicture) }}" class="w-14 h-14 object-cover rounded-lg border border-gray-300" onerror="this.onerror=null; this.src='https://via.placeholder.com/56?text=No+Image';">
                                    @endif
                                    <div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 block">Current Picture</span>
                                        <button wire:click="removeImage" type="button" class="text-xs text-red-500 hover:underline mt-0.5">Remove Picture</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer buttons -->
                    <div class="flex items-center justify-end space-x-2 border-t pt-4 dark:border-gray-700">
                        <button wire:click="closeModal" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">Cancel</button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="picture" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 flex items-center gap-1.5">
                            <span wire:loading wire:target="saveProduct" class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
                            <span>{{ $isEditMode ? 'Save Changes' : 'Create Product' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Import Excel Modal -->
    @if ($showImportModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-gray-900/60 backdrop-blur-sm p-4">
            <div class="relative w-full max-w-md bg-white rounded-xl shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Import Products from Excel
                    </h3>
                    <button wire:click="closeImportModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>

                <!-- Modal body -->
                <form wire:submit.prevent="importExcel" class="p-6 space-y-4">
                    <div class="text-xs text-gray-600 dark:text-gray-300 space-y-1 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                        <p class="font-semibold text-gray-900 dark:text-white">Excel format requirement:</p>
                        <p>Columns should be named: <span class="font-mono bg-gray-200 dark:bg-gray-600 px-1 rounded">No</span>, <span class="font-mono bg-gray-200 dark:bg-gray-600 px-1 rounded">Group</span>, <span class="font-mono bg-gray-200 dark:bg-gray-600 px-1 rounded">Product</span>, <span class="font-mono bg-gray-200 dark:bg-gray-600 px-1 rounded">Name</span>, <span class="font-mono bg-gray-200 dark:bg-gray-600 px-1 rounded">pictures</span>.</p>
                        <p class="mt-1 text-blue-600 dark:text-blue-400 hover:underline cursor-pointer flex items-center gap-1" wire:click="downloadSampleTemplate">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download Sample Excel File
                        </p>
                    </div>

                    @if (!empty($importErrors))
                        <div class="p-3 text-xs text-red-800 bg-red-50 rounded-lg dark:bg-gray-800 dark:text-red-400 border border-red-200">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach ($importErrors as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choose Excel File (.xlsx, .xls, .csv)</label>
                        <input wire:model="excelFile" type="file" accept=".xlsx,.xls,.csv" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600">
                        @error('excelFile') <span class="text-xs text-red-500 block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-2 border-t pt-4 dark:border-gray-700">
                        <button wire:click="closeImportModal" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">Cancel</button>
                        <button type="submit" wire:loading.attr="disabled" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 flex items-center gap-1.5">
                            <span wire:loading wire:target="importExcel" class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></span>
                            <span>Upload & Import</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-gray-900/60 backdrop-blur-sm p-4">
            <div class="relative w-full max-w-md bg-white rounded-xl shadow-xl dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 text-center">
                <svg class="mx-auto mb-4 w-12 h-12 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <h3 class="mb-2 text-lg font-normal text-gray-800 dark:text-gray-200">Are you sure you want to delete this product?</h3>
                <p class="mb-6 text-xs text-gray-500 dark:text-gray-400">This action cannot be undone.</p>

                <div class="flex justify-center gap-3">
                    <button wire:click="$set('showDeleteModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                        No, cancel
                    </button>
                    <button wire:click="deleteProduct" type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                        Yes, delete
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
