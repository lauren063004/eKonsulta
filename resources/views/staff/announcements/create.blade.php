@extends('layouts.dashboard')

@section('title', 'Create Announcement')
@section('page-title', 'Create Announcement')

@section('content')
    <div class="dashboard-card admin-form-card announcement-form-page">
        <div class="card-header">
            <div>
                <h3>Create Health Center Announcement</h3>
                <p>Share updates for your assigned health center.</p>
            </div>
            <a href="{{ route('staff.announcements.index') }}" class="secondary-button">Back</a>
        </div>

        <form method="POST" action="{{ route('staff.announcements.store') }}" enctype="multipart/form-data" class="stacked-form">
            @csrf

            @if($errors->any())
                <div class="form-error-box">
                    <strong>Please correct the following:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-grid">
                <div class="form-field full-width">
                    <label for="title">Title</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" required>
                </div>

                <div class="form-field">
                    <label for="image">Announcement Image</label>
                    <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp">
                    <div class="announcement-upload-preview" data-upload-preview hidden>
                        <button type="button" class="announcement-image-preview-trigger" data-image-preview="" data-image-alt="" aria-label="Preview selected image">
                            <img alt="">
                        </button>
                        <span>Image preview</span>
                    </div>
                </div>

                <div class="form-field full-width">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" rows="8" required>{{ old('content') }}</textarea>
                </div>

                <div class="form-field checkbox-field">
                    <label>
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                        Publish immediately
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('staff.announcements.index') }}" class="secondary-button">Cancel</a>
                <button type="submit" class="primary-button">Save Announcement</button>
            </div>
        </form>
    </div>
@endsection
