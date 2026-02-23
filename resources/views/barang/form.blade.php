<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($barang) ? __('Edit Barang') : __('Tambah Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ isset($barang) ? route('barang.update', $barang) : route('barang.store') }}"
                        method="POST" class="space-y-6">
                        @csrf
                        @if(isset($barang))
                            @method('PUT')
                        @endif

                        <!-- Nama Barang -->
                        <div>
                            <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                            <x-text-input id="nama_barang" name="nama_barang" type="text" class="mt-1 block w-full"
                                :value="old('nama_barang', $barang->nama_barang ?? '')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_barang')" />
                        </div>

                        <!-- Kategori Barang -->
                        <div>
                            <x-input-label for="kategori" :value="__('Kategori Barang')" />
                            <select id="kategori" name="kategori"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="" disabled {{ !isset($barang) ? 'selected' : '' }}>Pilih Kategori
                                </option>
                                @foreach(['Smartphone', 'Notebook', 'Keyboard', 'Mouse', 'Hardisk'] as $cat)
                                    <option value="{{ $cat }}" {{ old('kategori', $barang->kategori ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('kategori')" />
                        </div>

                        <!-- Harga -->
                        <div>
                            <x-input-label for="harga" :value="__('Harga')" />
                            <x-text-input id="harga" name="harga" type="number" step="0.01" class="mt-1 block w-full"
                                :value="old('harga', $barang->harga ?? '')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                        </div>

                        <!-- Tanggal Pembelian -->
                        <div>
                            <x-input-label for="tanggal_pembelian" :value="__('Tanggal Pembelian')" />
                            <x-text-input id="tanggal_pembelian" name="tanggal_pembelian" type="date"
                                class="mt-1 block w-full" :value="old('tanggal_pembelian', isset($barang) ? $barang->tanggal_pembelian->format('Y-m-d') : '')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tanggal_pembelian')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            <a href="{{ route('barang.index') }}"
                                class="text-gray-600 hover:text-gray-900 transition transition-all text-sm">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>