 <!-- <div class="product-action">
     <input type="hidden" id="product-id-{{ $product->id }}" value="{{ $product->id }}">
     <input type="hidden" id="quantity-{{ $product->id }}" value="1">
     @if($product->customize == 'yes')
     <button type="button" class="btn-product btn-cart" onclick="openCustomizeModal({{ $product->id }})">
         <span>Add to Cart</span>
     </button>
     @else
     <button type="button" class="btn-product btn-cart" onclick="addToCart({{ $product->id }})">
         <span>Add to Cart</span>
     </button>
     @endif
 </div>
  -->


 <a class="cart" onclick="addToCart({{ $product->id }})" style="background:#4CAF50;">

     <i class="fas fa-shopping-cart" style="color: white;"></i>

 </a>
