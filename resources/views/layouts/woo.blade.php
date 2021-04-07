<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    @php do_action('get_header') @endphp
    @include('partials.header')
    <div class="wrap container" role="document">
    @php
    if(!is_front_page()) {
    	yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
    }
    @endphp
      <div class="content row mt-md-3 mb-3">
        <main class="main col-md-12 pe-md-4">
          <div class="row">
            <div class="col-md-12 bg-white">
              @yield('content')
            </div>
          </div>
        </main>
      </div>
    </div>
    @php do_action('get_footer') @endphp
    @include('partials.footer')
    @php wp_footer() @endphp
  </body>
</html>
