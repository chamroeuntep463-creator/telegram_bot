<div class="p-4 sm:p-6 bg-slate-50 dark:bg-gray-900 min-h-screen">
    <!-- Top Action Bar -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Product Assessment
            </h1>
        </div>
    </div>
    <!-- Spreadsheet Sheet Document Container -->
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden font-sans print:shadow-none print:border-none">
        <!-- Main Assessment Data Sheet Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-center border-collapse border border-gray-300 dark:border-gray-700 min-w-[1400px]">
                <!-- Category Headers -->
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                        <th rowspan="2" class="border border-gray-300 dark:border-gray-700 px-2 py-3 w-10 font-bold">លរ</th>
                        <th rowspan="2" class="border border-gray-300 dark:border-gray-700 px-3 py-3 w-48 font-bold text-left">ឈ្មោះអតិថិជន</th>
                        <th rowspan="2" class="border border-gray-300 dark:border-gray-700 px-3 py-3 w-48 font-bold text-left">អាសយដ្ឋាន</th>
                        
                        <!-- Single product headers -->
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">CBC</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">LITE</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">CBB</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">CBP</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">CBSP</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">CBPL</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">WKZ</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">WKZ ICE</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">ICY</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">DAZZ</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">ED</th>
                        <th class="border border-gray-300 dark:border-gray-700 p-1 w-14">SPORT</th>

                        <!-- Multi product sub-groups -->
                        <th colspan="3" class="border border-gray-300 dark:border-gray-700 py-1 bg-gray-200 dark:bg-gray-700 font-bold">EXPREZ</th>
                        <th colspan="2" class="border border-gray-300 dark:border-gray-700 py-1 bg-gray-200 dark:bg-gray-700 font-bold">CB Cola</th>
                        <th colspan="2" class="border border-gray-300 dark:border-gray-700 py-1 bg-gray-200 dark:bg-gray-700 font-bold">IZE CAN ( All )</th>
                        <th colspan="3" class="border border-gray-300 dark:border-gray-700 py-1 bg-gray-200 dark:bg-gray-700 font-bold">IZE PET ( All )</th>
                        <th colspan="3" class="border border-gray-300 dark:border-gray-700 py-1 bg-gray-200 dark:bg-gray-700 font-bold">WATER</th>

                        <th rowspan="2" class="border border-gray-300 dark:border-gray-700 px-3 py-3 w-40 font-bold">Remark</th>
                        <th rowspan="2" class="border border-gray-300 dark:border-gray-700 px-2 py-3 w-10 print:hidden">Action</th>
                    </tr>

                    <tr class="bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-200 font-bold">
                        <!-- Bottom row sub-headers for single products -->
                        <td class="border border-gray-300 dark:border-gray-700 p-1">CBC</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1">LITE</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1">CBB</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1">CBP</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1">CBSP</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1">CBPL</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1">WKZ</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1">WKZ ICE</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1">ICY</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1">DAZZ</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1">ED</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1">SPORT</td>

                        <!-- EXPREZ -->
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">300ml</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">STR</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">MEL</td>

                        <!-- CB Cola -->
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">250ml</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">330ml</td>

                        <!-- IZE CAN -->
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">250ml</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">330ml</td>

                        <!-- IZE PET -->
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">300ml</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">500ml</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">1.5L</td>

                        <!-- WATER -->
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">350ml</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">500ml</td>
                        <td class="border border-gray-300 dark:border-gray-700 p-1 w-12">1.5L</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
