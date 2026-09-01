@extends('layouts.admin')

@section('title', 'Edit SEO Guideline — Untab SaaS Admin')
@section('page_title', 'Edit SEO Guideline')
@section('page_subtitle', $guideline->title)

@section('content')
@include('admin.seo._form')
@endsection
