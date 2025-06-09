const CartService = {
  init: function () {
    const token = localStorage.getItem("user_token");
    if (!token) {
      if (confirm("You must be logged in to view your cart. Log in now?")) {
        window.location.href = "#login";
      } else {
        window.location.href = "#homepage";
      }
      return;
    }
    RestClient.get("cart", function (cartItems) {
      let $cartBody = $("#cart-body");
      $cartBody.empty();
      if (!cartItems || cartItems.length === 0) {
        $cartBody.append('<div class="alert alert-info">Your cart is empty.</div>');
        return;
      }
      cartItems.forEach(function (item) {
        $cartBody.append(`
          <div class="d-flex align-items-start border-bottom pb-3">
            <div class="me-4">
              <img src="${item.image_url || 'assets/img/not_found.jpg'}" alt="" class="card-img-mod-top mb-3 mb-md-0">
            </div>
            <div class="flex-grow-1 align-self-center overflow-hidden">
              <div>
                <h5 class="text-truncate font-size-18"><a href="?id=${item.product_id}#items" class="text-dark">${item.name}</a></h5>
                <p class="mb-0 mt-1">${item.description}</p>
              </div>
            </div>
            <div class="flex-shrink-0 ms-2">
              <ul class="list-inline mb-0 font-size-16">
                <li class="list-inline-item">
                  <a href="#" class="text-muted px-1" onclick="CartService.removeItem(${item.id})">
                    <i class="mdi mdi-trash-can-outline"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        `);
      });
    });
  },
  removeItem: function(cartId) {
  RestClient.delete(`cart/${cartId}`, function() {
    CartService.init();
  });
}
};