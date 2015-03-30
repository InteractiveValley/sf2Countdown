    <!--div id="carrito" class="flotar"-->
        <!--h6 class="titulo-logo-carrito">
            Carrito <span id="logo-carrito"><img src="/images/carrito.png" alt="" height="50"></span>
        </h6-->
        <div class="carrito">
            <span class="triangulo-carrito"></span>
            <h3 class="titulo-carrito">Mis productos</h3>
            <ul class="list-carrito">
                <!-- templates backbone -->
            </ul>
            <div class="row">
                <div class="total-carrito rubro col-md-4">Total: </div>
                <div class="total-carrito total col-md-8"><%= carrito.total %> MXN</div>
                <div class="total-carrito rubro col-md-4">Desc.: </div>
                <div class="descuento-carrito col-md-8"><%= carrito.descuento %> MXN</div>
            </div>
            <button id="hacerPedido">
                hacer pedido
            </button>
            <p class="letrero-carrito">
                Obten $ 100.00 pesos <br/>de descuento por <br/>cada 3 productos agregados!
            </p>
        </div>
    <!--/div-->