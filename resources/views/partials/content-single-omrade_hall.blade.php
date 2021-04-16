<article @php post_class() @endphp>
  <div class="entry-content">
    {!! do_shortcode( '[visa_general_info_hallar]') !!}

    {!! do_shortcode( '[nyheter_med_etikett etiketter="flemingsberg" limit="3"]' ) !!}

    @php the_content() @endphp
  </div>
</article>
