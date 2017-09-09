<nav class="navbar navbar-inverse" role="navigation">
    <ul class="nav sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/cimerocuenta') }}">Mi Cuenta</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/cimerologros') }}">Mis Logros</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/anadirlogros') }}">Anadir Logro</a>
        </li>
    </ul>
</nav>

<script>
    window.onload = function(){
        $('.nav-link').each(function(index,item){
           if ($(item).attr('href') === window.location.href)
              $(item).css('background-color','white').removeAttr("href");
        });
    }
</script>


