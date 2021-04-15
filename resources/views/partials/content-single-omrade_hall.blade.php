<article @php post_class() @endphp>
  <div class="entry-content">
    {!! do_shortcode( '[visa_general_info_hallar]') !!}

    {!! do_shortcode( '[nyheter_med_etikett]' ) !!}

    @php the_content() @endphp
  </div>
</article>
