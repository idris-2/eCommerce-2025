const AdminService = {
  init: function () {
    // Load products
    RestClient.get("products", function (products) {
      let $tbody = $(".table tbody");
      $tbody.empty();
      products.forEach(function (product) {
        $tbody.append(`
          <tr>
            <th scope="row">${product.id}</th>
            <td>${product.name}</td>
            <td>${product.description}</td>
            <td>${product.category}</td>
            <td>${product.rating || ""}</td>
            <td>${product.image_url || ""}</td>
            <td class="text-nowrap">
              <div class="d-flex gap-1">
                <button class="btn btn-primary" onclick="AdminService.editProduct(${product.id})">Edit</button>
                <button class="btn btn-danger" onclick="AdminService.deleteProduct(${product.id})">Delete</button>
              </div>
            </td>
          </tr>
        `);
      });
    });

    // Add product event
    $("#addProductModal .btn-success[type=submit]").off("click").on("click", function (e) {
      e.preventDefault();

      // Collect form data
      const name = $("#productName").val();
      const description = $("#description").val();
      const category = $("#category").val();
      const price = $("#productPrice").val();
      const price_old = $("#productOldPrice").val();
      const image_url = $("#productImageUrl").val();

      // Basic validation
      if (!name || !price) {
        alert("Name and price are required.");
        return;
      }

      // Send to backend
      RestClient.post("products", {
        name,
        description,
        category,
        price,
        price_old,
        image_url
      }, function () {
        // Hide modal, reset form, reload products
        $("#addProductModal").modal("hide");
        $("#addProductModal form")[0].reset();
        AdminService.init();
      });
    });
  },
  editProduct: function (id) {
    // Load product data, fill modal, and update on submit
  },
  deleteProduct: function (id) {
    if (confirm("Are you sure you want to delete this product?")) {
      RestClient.delete(`products/${id}`, function () {
        AdminService.init();
      });
    }
  }
};