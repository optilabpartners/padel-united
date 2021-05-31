@php
  $short_title = get_post_meta(get_the_ID(), 'short_title', true);
  $extra_hall_text = get_post_meta(get_the_ID(), 'extra_hall_text', true);
  $nav_items = wp_get_nav_menu_items($short_title);
@endphp
<article @php post_class() @endphp>
  <div class="entry-content">
    @if (get_post_meta(get_the_ID(), 'hall_sida', true))
      {!! do_shortcode( '[visa_general_info_hallar]') !!}
    @endif

    @if($get_children_pages->have_posts() || $nav_items)
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
                <div class="col-12 col-md-4 text-center mb-4">
                  <a href="<?php echo(get_the_permalink()) ?>" class="btn btn-large btn-huge text-uppercase w-100 text-decoration-light-blue text-white pu-orange-bg"><?php the_title() ?> <img src="@asset('images/padel-united.png')" class="w-23 float-end" /></a>
                </div>
                @endwhile
                @if($nav_items)
                  @foreach ( $nav_items as $nav_item )
                  <div class="ccol-12 col-md-4 text-center mb-4">
                    <a href="<?php echo($nav_item->url) ?>" target="_blank" class="btn btn-large btn-huge text-uppercase w-100 text-decoration-light-blue text-white pu-orange-bg">
                      <?php if($nav_item->classes[0] == 'padelverket') { ?>
                        <?php echo($nav_item->title) ?> <img src="@asset('images/padelverket.png')" class="w-23 float-end" />
                      <?php } elseif($nav_item->classes[0] == 'padelcrew') { ?>
                        <?php echo($nav_item->title) ?> <img src="@asset('images/padel-crew.png')" class="w-23 float-end" />
                      <?php } else { ?>
                        <?php echo($nav_item->title) ?> <i class="fas fa-arrow-circle-right"></i>
                      <?php } ?>
                    </a>
                  </div>
                  @endforeach
                  @php wp_reset_postdata() @endphp
                @endif
            </div>
          </div>
        @endif
        @if($nav_items)
          <p class="text-center text-white">{!! $extra_hall_text !!}</p>
        @endif
      </div>
    </div>
    @endif
    

    @php the_content() @endphp
  </div>
</article>
