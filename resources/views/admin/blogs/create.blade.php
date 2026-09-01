@extends('layouts.admin')

@section('title', 'New Blog Post — Untab SaaS Admin')
@section('page_title', 'New Blog Post')
@section('page_subtitle', 'Create a new post for the Untab blog.')

@section('content')
@include('admin.blogs._form')
@endsection
