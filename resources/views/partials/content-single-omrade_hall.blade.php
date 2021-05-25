@php
  $short_title = get_post_meta(get_the_ID(), 'short_title', true);
  $extra_hall_text = get_post_meta(get_the_ID(), 'extra_hall_text', true);
@endphp
<article @php post_class() @endphp>
  <div class="entry-content">
    @if (get_post_meta(get_the_ID(), 'hall_sida', true))
      {!! do_shortcode( '[visa_general_info_hallar]') !!}
    @endif

    <div class="container alignfull pu-darkblue-bg pt-4 pb-4">
      <div class="pt-4 pb-4">
        @if($get_children_pages->have_posts())
          @if($short_title)
            <h2 class="pt-4 pb-4 text-white text-center fw-bold">Våra Hallar i {!! $short_title !!}</h2>
          @else
            <h2 class="pt-4 pb-4 text-white text-center fw-bold">Våra Hallar i {!! the_title() !!}</h2>
          @endif
          <div class="container ps-0 pe-0 pt-4 pb-4">
            <div class="row justify-content-md-center">
              @while ($get_children_pages->have_posts())
              @php $get_children_pages->the_post() @endphp
                <div class="col-3 text-center mb-4">
                  <a href="<?php echo(get_the_permalink()) ?>" class="btn btn-large btn-huge text-uppercase w-290 text-decoration-light-blue text-white pu-orange-bg"><?php the_title() ?> <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                @endwhile
              @php wp_reset_postdata() @endphp
            </div>
          </div>
          @php
            $nav_items = wp_get_nav_menu_items($short_title);
          @endphp
          @if($nav_items)
            <p class="text-center text-white">{!! $extra_hall_text !!}</p>
            <div class="container ps-0 pe-0 pt-4 pb-4">
              <div class="row justify-content-md-center">
                @foreach ( $nav_items as $nav_item )
                  <div class="col-3 text-center mb-4">
                    <a href="<?php echo($nav_item->url) ?>" target="_blank" class="btn btn-large btn-huge text-uppercase w-290 text-decoration-light-blue text-white pu-orange-bg"><?php echo($nav_item->title) ?> <i class="fas fa-arrow-circle-right"></i></a>
                  </div>
                @endforeach
                @php wp_reset_postdata() @endphp
              </div>
            </div>
          @endif
        @endif
      </div>
    </div>
    

    @php the_content() @endphp
  </div>
</article>
