<article @php post_class() @endphp>
  <div class="entry-content">
    @if (get_post_meta(get_the_ID(), 'hall_sida', true)))
      {!! do_shortcode( '[visa_general_info_hallar]') !!}
    @endif

    @php the_content() @endphp
  </div>
</article>
