@php
    $produk = $produk ?? null;
@endphp

<div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $produk->nama ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="kategori_produk_id" class="form-select" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach ($kategoriList as $kategori)
            <option value="{{ $kategori->id }}"
                {{ old('kategori_produk_id', $produk->kategori_produk_id ?? '') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Harga</label>
    <input type="number" name="harga" class="form-control" value="{{ old('harga', $produk->harga ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Stok</label>
    <input type="number" name="stok" class="form-control" value="{{ old('stok', $produk->stok ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Gambar Produk</label>
    <input type="file" name="gambar" class="form-control">
    @if (isset($produk) && $produk->gambar)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" width="120">
        </div>
    @endif
</div>
