<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    @php do_action('get_header') @endphp
    @include('partials.header')
    <div class="wrap container" role="document">
      <div class="content row">
        <main class="main col-md-12">
          <div class="row">
            <div class="col-md-12 bg-white ps-4 pe-4 ps-md-0 pe-md-0 pt-4 pb-4">
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
