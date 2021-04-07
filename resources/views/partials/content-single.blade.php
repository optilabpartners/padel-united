<article @php post_class() @endphp>
  <header>
    <h1 class="entry-title pt-2 text-break">{!! get_the_title() !!}</h1>
  </header>
  <div class="entry-content">
    @php the_content() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
  @include('partials/entry-meta')
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
