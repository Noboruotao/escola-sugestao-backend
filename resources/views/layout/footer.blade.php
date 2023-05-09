<footer class="footer bg-dark  fixed-bottom">
    <div class="container text-center">
        @if(Auth::check())
            <span class="text-light">{{ ucfirst(Auth::user()->getRoleNames()[0]) }}</span>        
        @else
            <span class="text-light">Laravel Sugestão</span>
        @endif
    </div>
</footer>