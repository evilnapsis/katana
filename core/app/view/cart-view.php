<?php
$coin_symbol = ConfigurationData::getByPreffix("general_coin")?ConfigurationData::getByPreffix("general_coin")->val:"$";
$iva = ConfigurationData::getByPreffix("general_iva")?ConfigurationData::getByPreffix("general_iva")->val:0;
$ivatxt = ConfigurationData::getByPreffix("general_iva_txt")?ConfigurationData::getByPreffix("general_iva_txt")->val:"IVA";

if(isset($_GET["opt"]) && $_GET["opt"]=="all"):
$total = 0;
?>
<div class="page-body">
  <div class="container-xl">
    <div class="row g-4">
      <div class="col-md-12">
        <h2 class="h1 mb-3"><i class="bi bi-cart"></i> Mi Carrito</h2>
        <?php if(!isset($_SESSION["client_id"])):?>
          <div class="alert alert-important alert-danger shadow-sm">
            Debes <a href="./?view=client&opt=login" class="alert-link">iniciar sesión</a> para proceder con la compra.
          </div>
        <?php endif; ?>

        <?php if(isset($_SESSION["cart"]) && count($_SESSION["cart"])>0):?>
        <div class="card shadow-sm">
          <div class="table-responsive">
            <table class="table table-vcenter card-table">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-end">Precio</th>
                  <th class="text-end">Total</th>
                  <th class="w-1"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($_SESSION["cart"] as $s):
                $p = ProductData::getById($s["product_id"]); ?>
                <tr>
                  <td>
                    <div class="d-flex py-1 align-items-center">
                      <div class="flex-fill">
                        <div class="font-weight-medium"><?php echo htmlspecialchars($p->name); ?></div>
                        <div class="text-muted small">Código: <?php echo $p->code; ?></div>
                      </div>
                    </div>
                  </td>
                  <td class="text-center" style="width: 120px;">
                    <form action="./?action=cart&opt=edit" method="post" class="d-flex align-items-center">
                      <input type="hidden" name="product_id" value="<?php echo $p->id; ?>">
                      <input type="number" name="q" value="<?php echo $s["q"]; ?>" class="form-control form-control-sm text-center me-2" onchange="this.form.submit()">
                    </form>
                  </td>
                  <td class="text-end text-muted"><?php echo $coin_symbol." ".number_format($p->price,2); ?></td>
                  <td class="text-end font-weight-bold"><?php echo $coin_symbol." ".number_format($p->price*$s["q"],2); ?></td>
                  <td>
                    <a href="./?action=cart&opt=del&product_id=<?php echo $p->id; ?>" class="btn btn-link link-danger" title="Eliminar"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
                <?php $total += $s["q"]*$p->price; endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="row mt-4 justify-content-end">
          <div class="col-md-4">
            <div class="card shadow-sm border-0 border-top border-primary border-3">
              <div class="card-body">
                <div class="d-flex mb-2">
                  <span>Subtotal</span>
                  <div class="ms-auto font-weight-bold"><?php echo $coin_symbol." ".number_format($total-($total*($iva/100)),2); ?></div>
                </div>
                <div class="d-flex mb-2">
                  <span><?php echo $ivatxt; ?> (<?php echo $iva; ?>%)</span>
                  <div class="ms-auto font-weight-bold"><?php echo $coin_symbol." ".number_format($total*($iva/100),2); ?></div>
                </div>
                <hr class="my-2">
                <div class="d-flex mb-4 h2">
                  <span>Total</span>
                  <div class="ms-auto font-weight-bold text-primary"><?php echo $coin_symbol." ".number_format($total,2); ?></div>
                </div>

                <?php if(isset($_SESSION["client_id"])):?>
                <form action="./?view=cart&opt=checkout" method="post">
                  <div class="mb-3">
                    <label class="form-label">Método de pago</label>
                    <select class="form-select" required name="paymethod_id">
                      <?php foreach(PaymethodData::getActives() as $pay):?>
                        <option value="<?php echo $pay->id; ?>"><?php echo $pay->name; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <button class="btn btn-primary w-100 btn-lg">Confirmar Compra</button>
                </form>
                <?php else: ?>
                  <button class="btn btn-primary w-100 btn-lg disabled">Inicia sesión para pagar</button>
                <?php endif; ?>
                <div class="mt-3 text-center">
                  <a href="./?action=cart&opt=clear" class="text-danger small"><i class="bi bi-x-circle"></i> Vaciar Carrito</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php else: ?>
        <div class="card card-md">
          <div class="card-body text-center py-5">
            <div class="mb-3">
              <i class="bi bi-cart-x" style="font-size: 4rem; color: #ccc;"></i>
            </div>
            <h2>Tu carrito está vacío</h2>
            <p class="text-muted">Parece que aún no has agregado nada a tu carrito.</p>
            <a href="./?view=products&opt=all" class="btn btn-primary mt-3">Seguir Comprando</a>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="checkout"):
$total = 0;
$pm  = PaymethodData::getById($_POST["paymethod_id"]);
?>
<div class="page-body">
  <div class="container-xl">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <h2 class="h1 mb-4 text-center">Revisión de tu Pedido</h2>
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-light">
            <h3 class="card-title"><i class="bi bi-credit-card me-2"></i> Método de Pago: <strong><?php echo $pm->name; ?></strong></h3>
          </div>
          <div class="table-responsive">
            <table class="table table-vcenter card-table">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-end">Precio</th>
                  <th class="text-end">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($_SESSION["cart"] as $s):
                $p = ProductData::getById($s["product_id"]); ?>
                <tr>
                  <td><?php echo htmlspecialchars($p->name); ?></td>
                  <td class="text-center"><?php echo $s["q"]; ?></td>
                  <td class="text-end text-muted"><?php echo $coin_symbol." ".number_format($p->price,2); ?></td>
                  <td class="text-end font-weight-bold"><?php echo $coin_symbol." ".number_format($p->price*$s["q"],2); ?></td>
                </tr>
                <?php $total += $s["q"]*$p->price; endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3" class="text-end h4 py-3">Gran Total:</td>
                  <td class="text-end h3 font-weight-bold text-primary py-3"><?php echo $coin_symbol." ".number_format($total,2); ?></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-6">
            <a href="./?view=cart&opt=all" class="btn btn-outline-secondary w-100">Regresar al Carrito</a>
          </div>
          <div class="col-6">
            <form action="./?action=cart&opt=buy" method="post">
              <input type="hidden" name="paymethod_id" value="<?php echo $_POST["paymethod_id"];?>">
              <button class="btn btn-success w-100">Finalizar Compra <i class="bi bi-chevron-right"></i></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="details"):
$buy = null;
if(isset($_GET["id"])){ $buy = BuyData::getById($_GET["id"]); }
else if(isset($_GET["code"])){ $buy = BuyData::getByCode($_GET["code"]); }

if($buy):
$products = BuyProductData::getAllByBuyId($buy->id);
?>
<div class="page-body">
  <div class="container-xl">
    <div class="card shadow-sm mb-4">
      <div class="card-header d-flex align-items-center">
        <h3 class="card-title">Detalles de la Compra #<?php echo $buy->id; ?></h3>
        <span class="badge ms-auto <?php echo $buy->status_id==1?'bg-warning':'bg-success'; ?>"><?php echo $buy->getStatus()->name; ?></span>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-6">
            <div class="text-muted small">Fecha:</div>
            <div class="font-weight-medium h4"><?php echo $buy->created_at; ?></div>
          </div>
          <div class="col-md-6 text-md-end">
            <div class="text-muted small">Método de pago:</div>
            <div class="font-weight-medium h4"><?php echo $buy->getPaymethod()->name; ?></div>
          </div>
        </div>
        
        <div class="table-responsive">
          <table class="table table-vcenter">
            <thead>
              <tr>
                <th>Producto</th>
                <th class="text-center">Cant.</th>
                <th class="text-end">Precio</th>
                <th class="text-end">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($products as $bp):
              $p = $bp->getProduct(); ?>
              <tr>
                <td><?php echo htmlspecialchars($p->name); ?></td>
                <td class="text-center"><?php echo $bp->q; ?></td>
                <td class="text-end"><?php echo $coin_symbol." ".number_format($p->price,2); ?></td>
                <td class="text-end font-weight-bold"><?php echo $coin_symbol." ".number_format($bp->q*$p->price,2); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr class="h3">
                <td colspan="3" class="text-end py-3">Total:</td>
                <td class="text-end text-primary py-3"><?php echo $coin_symbol." ".number_format($buy->getTotal(),2); ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    <div class="text-center">
      <a href="./?view=client&opt=all" class="btn btn-outline-primary">Ver Historial de Compras</a>
    </div>
  </div>
</div>
<?php endif; ?>
<?php endif; ?>
