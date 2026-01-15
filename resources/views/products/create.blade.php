@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none text-muted small">Inventory</a></li>
                        <li class="breadcrumb-item active small" aria-current="page">New Product</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Create Product</h3>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3 fw-bold small">
                <i class="bi bi-x-lg me-2"></i> Cancel
            </a>
        </div>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="form-section-title mb-4">
                        <div class="icon-box bg-primary-soft rounded-3" style="width: 32px; height: 32px; font-size: 0.9rem;">
                            <i class="bi bi-box"></i>
                        </div>
                        <h6 class="fw-bold">General Information</h6>
                        <div class="form-section-sep"></div>
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-12">
                            <label class="form-label-refined">Product Name</label>
                            <input type="text" name="name" class="form-control-refined w-100 @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter product name" required>
                            @error('name') <div class="invalid-feedback mt-2">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">Selling Price</label>
                            <div class="input-group-refined">
                                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                <input type="number" step="0.01" name="price" class="form-control w-100" value="{{ old('price') }}" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">SKU / Stock ID</label>
                            <div class="input-group-refined">
                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                <input type="text" name="sku" class="form-control w-100" value="{{ old('sku') }}" placeholder="e.g. SKU-12345">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label-refined">Detailed Description</label>
                            <textarea name="description" class="form-control-refined w-100" rows="4" placeholder="Briefly describe the product features...">{{ old('description') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-refined">Initial Status</label>
                            <select name="status" class="form-control-refined w-100">
                                <option value="active">Active / In Stock</option>
                                <option value="inactive">Inactive / Out of Stock</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-plus-circle"></i>
                            <span>Register Product</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
