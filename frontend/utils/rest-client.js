let RestClient = {
  get: function (url, callback, error_callback) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + url,
      type: "GET",
      beforeSend: function (xhr) {
        const token = localStorage.getItem("user_token");
        if (token) xhr.setRequestHeader("Authentication", "Bearer " + token);
      },
      success: function (response) {
        if (callback) callback(response);
      },
      error: function (jqXHR) {
        if (error_callback) error_callback(jqXHR);
      },
    });
  },
  request: function (url, method, data, callback, error_callback) {
    $.ajax({
      url: Constants.PROJECT_BASE_URL + url,
      type: method,
      contentType: "application/json",
      data: data ? JSON.stringify(data) : undefined,
      beforeSend: function (xhr) {
        const token = localStorage.getItem("user_token");
        if (token) xhr.setRequestHeader("Authentication", "Bearer " + token);
      },
    })
      .done(function (response) {
        if (callback) callback(response);
      })
      .fail(function (jqXHR) {
        if (error_callback) {
          error_callback(jqXHR);
        } else if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
          toastr.error(jqXHR.responseJSON.message);
        }
      });
  },
  post: function (url, data, callback, error_callback) {
    RestClient.request(url, "POST", data, callback, error_callback);
  },
  delete: function (url, data, callback, error_callback) {
    RestClient.request(url, "DELETE", data, callback, error_callback);
  },
  patch: function (url, data, callback, error_callback) {
    RestClient.request(url, "PATCH", data, callback, error_callback);
  },
  put: function (url, data, callback, error_callback) {
    RestClient.request(url, "PUT", data, callback, error_callback);
  },
};