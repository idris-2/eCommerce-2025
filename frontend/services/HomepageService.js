const HomepageService = {
  init: function () {
    $("body").removeClass("bg-dark").addClass("bg-light");
    $("footer").show();
    $("nav").show();

    this.loadProducts();
  },

  loadProducts: function () {
    RestClient.get("products", function (data) {
      let $productCardsRow = $("#product-cards-row");
      $productCardsRow.empty();
      data.forEach(function (product) {
        HomepageService.createCard(product).appendTo($productCardsRow);
      });
    });
  },

  createCard: function (product) {
    let imagePath =
      product.image_url && product.image_url !== "0"
        ? product.image_url
        : "https://dummyimage.com/450x300/dee2e6/6c757d.jpg";
    let cardHtml = `
      <div class="col mb-5">
        <div class="card h-100">
          <img class="card-img-top" src="${imagePath}" alt="..." />
          <div class="card-body p-3 position-relative">
            <div class="text-center">
              <h5 class="fw-bolder">${product.name}</h5>
              <div>${product.category}</div>
              <div>${product.description}</div>
              <div>
                <span class="text-muted text-decoration-line-through">$${product.price_old ?? ""}</span>
                $${product.price}
              </div>
            </div>
          </div>
          <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center">
              <div class="d-grid gap-2">
                <a class="btn btn-outline-dark mt-auto" href="?id=${product.id}#items">View</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
    return $(cardHtml);
  },
};