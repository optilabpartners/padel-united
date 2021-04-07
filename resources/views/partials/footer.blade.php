<footer class="content-info text-white pt-4 pb-4">
	<div class="container">
		<div class="row">
			<nav class="nav-footer col-md-4">
				<h3 class="text-red">Våra Hallar</h3>
				@if (has_nav_menu('footer_navigation'))
					{!! wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'nav flex-column']) !!}
        		@endif
			</nav>
			<div class="col-md-4 mt-2 mt-md-0">
				<h3>Kontakt</h3>
				@php dynamic_sidebar('sidebar-footer') @endphp
			</div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-6">
						<img class="img-fluid" src="@asset('images/footer-logo.png')" alt="Padel United Footer Logga" />
					</div>
					<div class="col-6">
					@if (has_nav_menu('footer_second_navigation'))
						{!! wp_nav_menu(['theme_location' => 'footer_second_navigation', 'menu_class' => 'nav flex-column']) !!}
        			@endif
					<br />
					<p>&copy; {{ date('Y') }} {{ get_bloginfo('name', 'display') }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>                        
</footer>