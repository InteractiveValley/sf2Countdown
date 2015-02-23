<!--div id="modalProducto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 modal-producto-galeria">
                            <ul class="bxslider">
                                {% for galeria in galerias %}
                                <li><img src="{{ galeria.imagen }}" /></li>
                                {% endfor %}    
                            </ul>
                        </div>
                        <div class="col-md-6 modal-producto-contenido">
                            <h3 class="modal-producto-titulo">{{nombre}}</h3>
                            <div class="modal-producto-clave-producto">ID: {{}}</div>
                            <div class="modal-producto-descripcion">
                                {{descripcion|raw}} 
                            </div>
                            <div class="modal-producto-precio">
                                ${{precio|number_format(2, '.', ',') }} MXN
                            </div>
                            <span class="modal-producto-inventario">
                                Countdown:  {{existencia}}
                            </span>
                            <form class="form-inline modal-producto-cantidad">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad: </label>
                                    <input type="text" class="form-control" id="cantidad" placeholder="" style="width:100px;">
                                    <button class="btn btn-default"><i class="fa fa-plus-square"></i></button>
                                    <button class="btn btn-default"><i class="fa fa-minus-square"></i></button>
                                </div>
                            </form>
                            <button class="modal-producto-agrergar-carrito" data-id="{{id}}">agregar a carrito</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--/div-->