<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-stone-800 leading-tight tracking-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-stone-200 overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-8 text-stone-800">

                    <form method="POST" action="{{ route('products.update', $product->id) }}" class="space-y-6 max-w-2xl">
                        @csrf
                        @method('PUT')

                        <!-- SKU -->
                        <div>
                            <x-input-label for="sku" value="SKU (Kode Produk)" />
                            <x-text-input id="sku" class="block mt-1 w-full" type="text" name="sku" :value="old('sku', $product->sku)" required autofocus />
                            <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                        </div>

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" value="Nama Produk" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Price -->
                        <div>
                            <x-input-label for="price" value="Harga (Rp)" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $product->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <!-- Stock -->
                        <div>
                            <x-input-label for="stock" value="Stok" />
                            <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock', $product->stock)" required />
                            <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4 pt-4 border-t border-stone-100">
                            <x-primary-button class="py-3 px-6 shadow-sm">Update Data</x-primary-button>
                            <a href="{{ route('products.index') }}" class="text-stone-600 hover:text-stone-900 border border-stone-300 hover:bg-stone-50 px-5 py-2.5 rounded-lg transition-colors font-medium text-sm">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
