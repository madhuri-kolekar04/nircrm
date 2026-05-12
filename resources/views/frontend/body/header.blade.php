
<div class="topnav" style="background-color: #000;">
<div class="row">
		<div style="margin:0;"class="col-md-2">
	         <img src="{{ asset('images/ecs.png') }}" height="110px">
		</div>
		<div  class="col-md-4 pt-5 pl-5">
		<!-- 	<a class="active" href="#home">HOME</a>
		<a class="active" href="#aboutus">ABOUT US</a>
		<a class="active" href="#service">SERVICE </a>
		<a class="active" href="#blog">BLOG </a> -->
		<ul> 
			<li><a class="active" href="#home">HOME</a></li>
			<li><a class="active" href="#aboutus">ABOUT US</a></li>
			<li><a class="active" href="#service">SERVICE</a></li>
			<li><a class="active" href="#blog">BLOG</a></li>
			<li><a class="active" href="#career">CAREER</a></li>
			<li><a class="active" href="#contact">CONTACT US</a></li>
		</ul> 				
  		</div>

		<div class="col-md-4 fa-fas text-left">
				<ul class="social">
					<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
					<li><a href="#"><i class="fab fa-twitter"></i></a></li>
					<li><a href="#"><i class="fab fa-instagram"></i></a></li>
					<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
					<li><a href="#"><i class="fa fa-youtube-play" style="font-size:18px"></i></a></li>

				</ul>

		</div>
		
		<div class="col-md-2 fa-fas logdiv text-left"> 
        @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="dashboardbutton text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
						   <!-- Authentication -->
   <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a class="dashboardbutton" href="#"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="dashboardbutton text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                       
                    @endauth
                </div>
            @endif
        </div>
</div>

</div>