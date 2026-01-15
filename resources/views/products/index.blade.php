@extends('layouts.app')

@section('title', 'Product Inventory')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Product Inventory</h4>
        <p class="text-muted small">Manage your business products and pricing.</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-primary d-flex align-items-center px-4 py-2 rounded-3 shadow-sm">
        <i class="bi bi-plus-lg me-2"></i> Add New Product
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 border-0 text-muted small fw-bold text-uppercase">Product Details</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">SKU</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Price</th>
                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Status</th>
                        <th class="pe-4 py-3 border-0 text-end text-muted small fw-bold text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box bg-primary-soft rounded-3" style="width: 40px; height: 40px; font-size: 1rem;">
                                    <i class="bi bi-box"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $product->name }}</div>
                                    <div class="extra-small text-muted">{{ Str::limit($product->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <code class="small text-primary fw-bold">{{ $product->sku ?? 'N/A' }}</code>
                        </td>
                        <td>
                            <div class="fw-bold">${{ number_format($product->price, 2) }}</div>
                        </td>
                        <td>
                            @if($product->status == 'active')
                                <span class="badge bg-success-soft text-success p-2 px-3 rounded-pill extra-small fw-bold border-0">Available</span>
                            @else
                                <span class="badge bg-danger-soft text-danger p-2 px-3 rounded-pill extra-small fw-bold border-0">Inactive</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-white btn-sm border-end" title="Edit">
                                    <i class="bi bi-pencil text-primary"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm" title="Delete">
                                        <i class="bi bi-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted mb-3">
                                <i class="bi bi-box-seam display-1 opacity-25"></i>
                            </div>
                            <h5 class="fw-bold">No Products Found</h5>
                            <p class="text-muted small">Start adding products to your inventory.</p>
                            <a href="{{ route('products.create') }}" class="btn btn-primary rounded-3 px-4 mt-2">Create Product</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
