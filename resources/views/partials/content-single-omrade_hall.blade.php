<article @php post_class() @endphp>
  <div class="entry-content">
    @if (get_post_meta(get_the_ID(), 'hall_sida', true)))
      {!! do_shortcode( '[visa_general_info_hallar]') !!}
    @endif

    @if (!get_post_meta(get_the_ID(), 'hall_sida', true))
    <div class="container alignfull pu-darkblue-bg pt-4 pb-4">
      <h2 class="text-white text-center text-uppercase"><strong>VÅRA HALLAR I {!! the_title() !!}</strong></h2>
      <div class="container ps-0 pe-0">
        <div class="scrolling-wrapper row flex-row flex-nowrap ps-0 pe-0 pe-md-4">
        @if($get_children_pages)
          @while ($get_children_pages->have_posts())
            @php $get_children_pages->the_post() @endphp
            <div class="col-md-4 col-10 pe-md-1 mb-4">
                <div class="pu-warmyellow-bg pt-2 pb-2"></div>
                <div class="pu-lightblue-bg mt-2 p-4 clearfix text-white">
                    <div class="container d-flex h-100 p-0">
                      <div class="row">
                          <div class="col-12 justify-content-center align-self-center">
                              <h4><?php the_title() ?></h4>
                          </div>
                      </div>
                    </div>
                    <p><?= get_the_excerpt() ?></p>
                    <a href="<?php echo(get_the_permalink()) ?>" class="btn btn-primary float-end">Gå till hallen <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
          @endwhile
          @php wp_reset_postdata() @endphp
          @endif
        </div>
      </div>
    </div>
    @endif

    @php the_content() @endphp
  </div>
</article>
