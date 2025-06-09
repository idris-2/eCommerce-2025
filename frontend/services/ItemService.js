const ItemService = {
  init: function () {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');
    if (!productId) return;

    RestClient.get(`products/${productId}`, function (product) {
      if (!product) {
        $("#item-details-row").html('<div class="col-12 text-center text-danger">Product not found.</div>');
        return;
      }
      ItemService.renderProduct(product);
      // Attach event after rendering
      $("#add-to-cart-btn").on("click", function () {
        const quantity = parseInt($("#inputQuantity").val()) || 1;
        // Get or create pending order for user
        RestClient.post("orders/get-or-create-cart", {}, function(order) {
          // Now add to cart
          RestClient.post("cart", {
            order_id: order.id,
            product_id: product.id,
            quantity: quantity
          }, function() {
            alert("Added to cart!");
          });
        });
      });
    });
  },

  renderProduct: function (product) {
    let imagePath =
      product.image_url && product.image_url !== "0"
        ? product.image_url
        : "https://dummyimage.com/450x300/dee2e6/6c757d.jpg";
    let html = `
      <div class="col-md-6">
        <img class="card-img-top mb-5 mb-md-0" src="${imagePath}" alt="Product image" />
      </div>
      <div class="col-md-6">
        <div class="small mb-1">${product.category ?? ""}</div>
        <h1 class="display-5 fw-bolder">${product.name}</h1>
        <div class="fs-5 mb-5">
          <span class="text-decoration-line-through">${product.price_old ? `$${product.price_old}` : ""}</span>
          <span>$${product.price}</span>
        </div>
        <p class="lead">${product.description ?? ""}</p>
        <div class="d-flex">
          <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" style="max-width: 3rem" min="1" />
          <button class="btn btn-outline-dark flex-shrink-0" type="button" id="add-to-cart-btn">
            <i class="bi-cart-fill me-1"></i>
            Add to cart
          </button>
        </div>
      </div>
    `;
    $("#item-details-row").html(html);
  }
};