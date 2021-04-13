@php
	//Get the contents of the FAQ page
 	$your_query = new WP_Query( 'pagename=faq' ); 
@endphp

@extends('layouts.app')

@section('content')
	@php
		the_content()
	@endphp
	<div class="container-fluid alignfull d-none d-md-block" style="background-color: red;">
		<div class="container pt-4 pb-4">
			<div class="row">
				<div class="d-flex align-items-start">
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Vårt Seriespel</button>
						<button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Abonnemang</button>
						<button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Ungdomar/Skola</button>
					</div>
					<div class="tab-content" id="v-pills-tabContent">
						<div class="tab-pane fade show active p-4" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
						Detta är en exempelsida. Den skiljer sig från ett blogginlägg genom att den finns kvar på samma plats och kommer att visas i din webbplatsnavigering (i de flesta teman). De flesta börjar med en Om-sida som presenterar dem för potentiella besökare. Den skulle t.ex kunna ha följande innehåll:

Hej där! Jag är cykelbud på dagen, blivande skådespelare på natten och detta är min blogg. Jag bor i Örebro, har en katt som heter Lurv och jag gillar Pina Coladas. (och att simma i Göta kanal).

… eller något liknande detta:

Företaget AB grundades 1971 och har sedan dess varit den största leverantören av grunk-manicker på den svenska marknaden. FAB finns i utkanten av Grönköping, har drygt 20 000 anställda och läser veckobladet varje år.
						</div>
						<div class="tab-pane fade p-4" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
						Detta är en exempelsida. Den skiljer sig från ett blogginlägg genom att den finns kvar på samma plats och kommer att visas i din webbplatsnavigering (i de flesta teman). De flesta börjar med en Om-sida som presenterar dem för potentiella besökare. Den skulle t.ex kunna ha följande innehåll:

Hej där! Jag är cykelbud på dagen, blivande skådespelare på natten och detta är min blogg. Jag bor i Örebro, har en katt som heter Lurv och jag gillar Pina Coladas. (och att simma i Göta kanal).

… eller något liknande detta:

Företaget AB grundades 1971 och har sedan dess varit den största leverantören av grunk-manicker på den svenska marknaden. FAB finns i utkanten av Grönköping, har drygt 20 000 anställda och läser veckobladet varje år.
						</div>
						<div class="tab-pane fade p-4" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
						Detta är en exempelsida. Den skiljer sig från ett blogginlägg genom att den finns kvar på samma plats och kommer att visas i din webbplatsnavigering (i de flesta teman). De flesta börjar med en Om-sida som presenterar dem för potentiella besökare. Den skulle t.ex kunna ha följande innehåll:

Hej där! Jag är cykelbud på dagen, blivande skådespelare på natten och detta är min blogg. Jag bor i Örebro, har en katt som heter Lurv och jag gillar Pina Coladas. (och att simma i Göta kanal).

… eller något liknande detta:

Företaget AB grundades 1971 och har sedan dess varit den största leverantören av grunk-manicker på den svenska marknaden. FAB finns i utkanten av Grönköping, har drygt 20 000 anställda och läser veckobladet varje år.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="d-block d-md-none" style="background-color: red;">
		<div class="accordion" id="accordionExample">
			<div class="accordion-item">
				<h2 class="accordion-header" id="headingOne">
					<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						Accordion Item #1
					</button>
				</h2>
				<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<strong>This is the first item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header" id="headingTwo">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					Accordion Item #2
				</button>
				</h2>
				<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
					<div class="accordion-body">
						<strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
					</div>
				</div>
			</div>
			<div class="accordion-item">
				<h2 class="accordion-header" id="headingThree">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
					Accordion Item #3
				</button>
				</h2>
				<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
				<div class="accordion-body">
					<strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
				</div>
				</div>
			</div>
		</div>
	</div>

	<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ App\asset_path('images/general-jumbotron.jpg') }}" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>First slide label</h5>
        <p>Some representative placeholder content for the first slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{ App\asset_path('images/general-jumbotron.jpg') }}" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Second slide label</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{ App\asset_path('images/general-jumbotron.jpg') }}" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    @php
      while ( $your_query->have_posts() ) : $your_query->the_post();
	the_content();
      endwhile;
      wp_reset_postdata();
    @endphp
@endsection
