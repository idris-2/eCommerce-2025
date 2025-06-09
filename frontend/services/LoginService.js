const LoginService = {
  init: function () {
    $("button[type=submit]").on("click", function (e) {
      e.preventDefault();
      const credentials = {
        email: $("#typeEmailX-2").val(),
        password: $("#typePasswordX-2").val()
      };
      RestClient.post("auth/login", credentials, function (response) {
        console.log(response);
        if (response && response.data && response.data.token) {
          localStorage.setItem("user_token", response.data.token);
          localStorage.setItem("user_id", response.data.id);
          alert("Login successful!");
          window.location.href = "#homepage";
        } else {
          alert("Login failed!");
        }
      });
    });
  }
};