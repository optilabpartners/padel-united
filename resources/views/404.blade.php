@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Förlåt, men sidan du försöker nå finns inte.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
    <br />
  @endif
@endsection
