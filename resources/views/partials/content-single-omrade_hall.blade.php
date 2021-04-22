<article @php post_class() @endphp>
  <div class="entry-content">
    @if (get_post_meta(get_the_ID(), 'hall_sida', true))
      {!! do_shortcode( '[visa_general_info_hallar]') !!}
    @endif

    @if($get_children_pages->have_posts())
    <div class="container alignfull pu-darkblue-bg pt-4 pb-4">
      <h2 class="pt-4 pb-4 text-white text-center text-uppercase"><strong>VÅRA HALLAR I {!! the_title() !!}</strong></h2>
      <div class="container ps-0 pe-0">
        <div class="row">
          @while ($get_children_pages->have_posts())
          @php $get_children_pages->the_post() @endphp
            <div class="col text-center mb-4">
              <a href="<?php echo(get_the_permalink()) ?>" class="btn btn-large btn-huge btn-primary text-uppercase w-280 no-hover"><?php the_title() ?> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            @endwhile
          @php wp_reset_postdata() @endphp
        </div>
      </div>
    </div>
    @endif

    @php the_content() @endphp
  </div>
</article>
