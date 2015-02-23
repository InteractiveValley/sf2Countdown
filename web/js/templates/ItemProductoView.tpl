<!--article class="producto imagen_grande o imagen_chica"-->
        <div class="contenido">
            <figure class="imagen-producto">
                <img src="{{imagen}}" alt="imagen de producto"/>
                <figcaption>
                    <span class="precio-producto">
                        ${{precio}} MXN
                    </span>
                    <span class="inventario-producto">
                        Countdown {{existencia}}
                    </span>
                    <span class="agregar-carrito" data-id="{{id}}">
                        +<i class="fa fa-shopping-cart"></i>
                    </span>
                    <span class="ver-producto" data-slug="{{slug}}">
                        <i class="fa fa-plus-square"></i>
                    </span>
                </figcaption>
            </figure>
        </div>
        <!--/article-->