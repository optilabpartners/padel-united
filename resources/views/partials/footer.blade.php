<footer class="content-info text-white pt-4 pb-4">
	<div class="container">
		<div class="row">
			<nav class="nav-footer col-md-4 mb-4 mb-md-0">
				<h3 class="text-red"><strong>Våra Hallar</strong></h3>
				@if (has_nav_menu('footer_navigation'))
					{!! wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'nav flex-column']) !!}
        		@endif
			</nav>
			<div class="col-md-3 mt-2 mt-md-0 mb-4 mb-md-0">
				<h3><strong>Kontakt</strong></h3>
				<div class="row">
					<div class="col-2 col-md-3">
						<img src="@asset('images/icons/pin.png')" class="img-fluid" alt="Pin" />
					</div>
					<div class="col-10 col-md-9">
						<p>Padel United AB<br />
						Västeråsgatan 5<br />
						113 43 Stockholm
					</div>
				</div>
			</div>
			<div class="col-md-5 mb-4 mb-md-0">
				<div class="row">
					<div class="col-4">
						<img class="img-fluid" src="@asset('images/footer-logo.png')" alt="Padel United Footer Logga" />
					</div>
					<div class="col-8">
						@if (has_nav_menu('footer_second_navigation'))
							{!! wp_nav_menu(['theme_location' => 'footer_second_navigation', 'menu_class' => 'nav flex-column']) !!}
						@endif
						<br />
						<div>
							<p>&copy; {{ date('Y') }} Padel United AB</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>                        
</footer>