@extends('layouts.app')

@section('title', 'Edit Plan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold">Edit Plan</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('plans.update', $plan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Plan Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $plan->name) }}" required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label fw-semibold">Price ($)</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $plan->price) }}" required>
                        @error('price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $plan->description) }}</textarea>
                        @error('description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('plans.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Update Plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
