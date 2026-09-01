@extends('layouts.admin')

@section('title', 'New FAQ — Untab SaaS Admin')
@section('page_title', 'New FAQ')
@section('page_subtitle', 'Add a question and answer to the public FAQ page.')

@section('content')
@include('admin.faqs._form')
@endsection
