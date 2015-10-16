<?php 
if(isset($_GET["cat"])){
$cat = CategoryData::getByPreffix($_GET["cat"]);
$products = ProductData::getPublicsByCategoryId($cat->id);
}else if(isset($_GET["opt"])){
if($_GET["opt"]=="news"){
$products = ProductData::getNews();
}
else if($_GET["opt"]=="offers"){
$products = ProductData::getOffers();
}

}else if(isset($_GET["act"]) && $_GET["act"]=="search"){
$products = ProductData::getLike($_GET["q"]);

}


 ?>
<section>
  <div class="container">

  <div class="row">

  <div class="col-md-12">
    <div style="background:#333;font-size:25px;color:white;padding:5px;"><?php 
    if(isset($_GET["act"]) && $_GET["act"]!=""){ echo "Busqueda: ".$_GET["q"]; }else { echo $cat->name; } ?></div>
<br>
<?php

$nproducts = count($products);
$filas = $nproducts/3;
$extra = $nproducts%3;
if($filas>1&& $extra>0){ $filas++; }
$n=0;
?>
<?php for($i=0;$i<$filas;$i++):?>
  <div class="row">
<?php for($j=0;$j<3;$j++):
$p=null;
if($n<$nproducts){
$p = $products[$n];
}
?>
<?php if($p!=null):
$img = "admin/storage/products/".$p->image;
?>
  <div class="col-md-4">
 <center>   <img src="<?php echo $img; ?>"  style="width:120px;height:120px;"></center>
  <h4 class="text-center"><?php echo $p->name; ?></h4>
<h3 class="text-center text-primary">$ <?php echo number_format($p->price,2,".",","); ?></h3>
<?php 
$in_cart=false;
if(isset($_SESSION["cart"])){
  foreach ($_SESSION["cart"] as $pc) {
    if($pc["product_id"]==$p->id){ $in_cart=true;  }
  }
  }

  ?>
<center>

<?php
 if(!$p->in_existence):?>

<a href="javascript:void()" class="btn btn-labeled btn-sm btn-warning tip" title="No disponible">
                <span class="btn-label"><i class="glyphicon glyphicon-shopping-cart"></i></span>No Disponible</a>
<br>

<?php elseif(!$in_cart):?>

<a href="index.php?action=addtocart&product_id=<?php echo $p->id; ?>&href=cat" class="btn btn-labeled btn-sm btn-primary tip" title="A&ntilde;adir al carrito">
                <span class="btn-label"><i class="glyphicon glyphicon-shopping-cart"></i></span>Comprar</a>
<br>
<?php else:?>
<center><a href="javascript:void()" class="btn btn-labeled btn-sm btn-success tip" title="Ya esta en el carrito">
                <span class="btn-label"><i class="glyphicon glyphicon-shopping-cart"></i></span>Ya esta agregado</a>
<br>
<?php endif; ?>
<a href="index.php?view=producto&product_id=<?php echo $p->id; ?>">Detalles</a>
                </center>

  </div>
<?php endif; ?>
<?php $n++; endfor; ?>
  </div>
<?php endfor; ?>



  </div>
  </div>


  </div>
  </section>
