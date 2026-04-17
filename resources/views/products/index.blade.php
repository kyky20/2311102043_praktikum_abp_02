<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-stone-800 leading-tight tracking-tight">
                {{ __('Katalog Produk') }}
            </h2>
            <a href="{{ route('products.create') }}" class="inline-flex items-center bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white font-semibold py-2.5 px-5 rounded-lg shadow hover:shadow-md transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Produk
            </a>
        </div>
    </x-slot>

    <!-- DataTables CSS and jQuery -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* Modern DataTables styling overrides */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.4rem 0.8rem;
            margin-left: 0.5rem;
            outline: none;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #f59e0b; /* amber-500 */
            box-shadow: 0 0 0 1px #f59e0b;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.25rem 2rem 0.25rem 0.5rem;
            margin: 0 0.25rem;
        }
        table.dataTable.no-footer { border-bottom: 0; }
        table.dataTable thead th, table.dataTable thead td { border-bottom: 2px solid #e7e5e4; }
    </style>

    <div class="py-12" x-data="productDelete()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-4 rounded-xl shadow-sm relative flex items-center" role="alert">
                    <svg class="w-6 h-6 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white border border-stone-200 overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-6 text-stone-800 overflow-x-auto">
                    
                    <table id="productsTable" class="w-full whitespace-no-wrap table-auto border-collapse">
                        <thead>
                            <tr class="text-left bg-stone-50 text-stone-500 uppercase text-xs tracking-wider">
                                <th class="px-6 py-4 font-semibold">ID</th>
                                <th class="px-6 py-4 font-semibold">SKU</th>
                                <th class="px-6 py-4 font-semibold">Nama Produk</th>
                                <th class="px-6 py-4 font-semibold">Harga</th>
                                <th class="px-6 py-4 font-semibold text-center">Stok</th>
                                <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @foreach($products as $product)
                            <tr class="hover:bg-amber-50/30 transition-colors duration-150">
                                <td class="px-6 py-4 text-stone-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-medium text-stone-700">{{ $product->sku }}</td>
                                <td class="px-6 py-4 text-stone-900 font-semibold">{{ $product->name }}</td>
                                <td class="px-6 py-4 text-amber-700 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->stock > 10 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center flex justify-center space-x-2">
                                    <a href="{{ route('products.edit', $product->id) }}" class="px-4 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 font-medium rounded-lg text-sm transition-colors">Edit</a>
                                    <button @click="confirmDelete('{{ route('products.destroy', $product->id) }}', '{{ $product->name }}')" class="px-4 py-1.5 bg-white border border-red-200 hover:bg-red-50 hover:border-red-300 text-red-600 font-medium rounded-lg text-sm transition-colors shadow-sm">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal (Alpine.js) -->
        <div x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <div x-show="isOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 bg-stone-900 bg-opacity-40 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="isOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-stone-100">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-12 sm:w-12">
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-stone-900" id="modal-title">
                                    Konfirmasi Penghapusan
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-stone-500">
                                        Data produk <span x-text="productName" class="font-bold text-stone-800"></span> akan dihapus secara permanen dari sistem. Aksi ini tidak dapat dibatalkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-stone-50 border-t border-stone-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form x-bind:action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                                Hapus Permanen
                            </button>
                        </form>
                        <button @click="isOpen = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-stone-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-stone-700 hover:bg-stone-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                "dom": '<"flex flex-col sm:flex-row justify-between pt-2 pb-4 border-b border-stone-100 mb-4"lf>rt<"flex flex-col sm:flex-row justify-between pt-4 mt-4 text-sm text-stone-500"ip>',
            });
        });

        function productDelete() {
            return {
                isOpen: false,
                deleteUrl: '',
                productName: '',
                confirmDelete(url, name) {
                    this.deleteUrl = url;
                    this.productName = name;
                    this.isOpen = true;
                }
            }
        }
    </script>
</x-app-layout>
