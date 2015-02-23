    <!--section id="secundario"-->
        <article  class="filtro-categorias container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row filtro">
                        <div class="col-md-4 filtro-titulo">
                            <div class="filtro-por-precio">
                                filtrar por precio
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input id="sliderPrecio" type="text" class="span2" value="" data-slider-min="50" data-slider-max="2000" data-slider-step="50" data-slider-value="2000" data-slider-orientation="horizontal" data-slider-selection="after" data-slider-tooltip="hide">
                        </div>
                        <div class="col-md-2">
                            <span id="valor-precio"></span>
                        </div>
                    </div>
                    <div class="row filtro">
                        <div class="col-md-4 filtro-titulo">
                            <div class=" filtro-por-color">
                                filtrar por color
                            </div>
                        </div>
                        <div class="col-md-8 filtro-colores text-center">
                            <span class="color color-carmesi fa fa-square"></span>
                            <span class="color color-amarillo fa fa-square"></span>
                            <span class="color color-cafe fa fa-square"></span>
                            <span class="color color-azul fa fa-square"></span>
                            <span class="color color-azul-marino fa fa-square"></span>
                            <span class="color color-verde fa fa-square"></span>
                            <span class="color color-fiusa fa fa-square"></span>
                            <span class="color color-gris fa fa-square"></span>
                            <span class="color color-blanco fa fa-square-o"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 filtro-ordenar" style="padding-right: 0px;">
                    <div class="filtro-ordenar-por-precio">
                        <div class="btn-group">
                            <button type="button" class="btn" style="background-color: #DF2E72; color: white; border-color: #DF2E72;">Mayor a menor precio</button>
                            <button type="button" class="btn dropdown-toggle" style="background-color: #DF2E72; color: white; border-color: #DF2E72;" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="mayor-a-menor" href="#">Mayor a menor precio</a></li>
                                <li><a class="menor-a-mayor" href="#">Menor a mayor precio</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="filtro-filtrar filtrar-color">
                        <span class="filtrar active">Filtrar</span>
                    </div>
                    <div class="filtro-ver-todos filtrar-color">
                        <span class="todos"> Ver todos</span>
                    </div>
                </div>
            </div>
        </article>
        <article id="lista-de-productos">
            <section class="productos">
                <!-- template de backbone -->
            </section>
        </article>    
    <!--/section-->