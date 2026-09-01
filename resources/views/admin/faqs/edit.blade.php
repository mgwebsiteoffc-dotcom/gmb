@extends('layouts.admin')

@section('title', 'Edit FAQ — Untab SaaS Admin')
@section('page_title', 'Edit FAQ')
@section('page_subtitle', $faq->question)

@section('content')
@include('admin.faqs._form')
@endsection
