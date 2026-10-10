@extends('layouts.dashboard')

@section('title', $announcement->title)
@section('page-title', 'Announcement')

@section('content')
    <article class="announcement-detail-page">
        <a href="{{ route('patient.announcements.index') }}" class="announcement-back-link">
            <span aria-hidden="true">←</span>
            All announcements
        </a>

        <header class="announcement-detail-header">
            <span class="announcement-detail-label">Announcement</span>
            <h2>{{ $announcement->title }}</h2>
            <div class="announcement-detail-meta">
                <span class="announcement-source">
                    {{ $announcement->healthCenter?->name ?? 'City Health Office' }}
                </span>
                <span class="announcement-meta-separator" aria-hidden="true"></span>
                <time datetime="{{ $announcement->published_at?->toIso8601String() }}">
                    {{ $announcement->published_at?->format('F j, Y \a\t g:i A') ?? 'Recently published' }}
                </time>
            </div>
        </header>

        @if($announcement->image_path)
            <figure class="announcement-detail-image">
                <button
                    type="button"
                    class="announcement-image-preview-trigger"
                    data-image-preview="{{ asset('storage/' . $announcement->image_path) }}"
                    data-image-alt="{{ $announcement->title }}"
                    aria-label="Preview image for {{ $announcement->title }}"
                >
                    <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="{{ $announcement->title }}">
                    <span class="announcement-image-preview-hint">Click to enlarge</span>
                </button>
            </figure>
        @endif

        <div class="announcement-detail-body" aria-label="Announcement content">
            {!! nl2br(e($announcement->content)) !!}
        </div>

        <footer class="announcement-detail-footer">
            <div>
                <strong>That’s the full announcement</strong>
                <p>Return to the list to read other updates.</p>
            </div>
            <a href="{{ route('patient.announcements.index') }}" class="secondary-button">
                <span aria-hidden="true">←</span> All announcements
            </a>
        </footer>
    </article>
@endsection
