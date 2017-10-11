<nav class="navbar" role="navigation">
    <ul class="nav sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/estadisticacimeros') }}">Cimas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/estadisticacimas') }}">Cimeros</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/estadisticaprovincias') }}">Provincias</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/estadisticacommunidads') }}">Communidades autonomos</a>
        </li>
    </ul>
</nav>

<script>
    window.onload = function(){
        $('.nav-link').each(function(index,item){
           if ($(item).attr('href') === window.location.href)
              $(item).css('background-color','#5bc0de').removeAttr("href");
        });
    }
</script>


