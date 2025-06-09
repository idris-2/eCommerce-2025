const RegisterService = {
  init: function () {
    $("button[type=submit]").on("click", function (e) {
      e.preventDefault();
      const user = {
        email: $("#typeEmailX-2").val(),
        username: $("#typeUsernameX-2").val(),
        password: $("#typePasswordX-2").val()
      };
      RestClient.post("auth/register", user, function (response) {
        alert("Registration successful! Please log in.");
        window.location.href = "#login";
      });
    });
  }
};