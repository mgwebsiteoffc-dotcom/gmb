@extends('layouts.admin')

@section('title', 'Edit Blog Post — Untab SaaS Admin')
@section('page_title', 'Edit Post')
@section('page_subtitle', $blog->title . ' — ' . $blog->statusLabel())

@section('content')
<div class="mb-4">
    <a href="{{ route('blog.show', $blog) }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-600 hover:text-brand-700">
        <i data-lucide="external-link" class="w-4 h-4"></i> View live post
    </a>
</div>
@include('admin.blogs._form')
@endsection
