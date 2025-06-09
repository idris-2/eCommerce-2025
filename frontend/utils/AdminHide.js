function updateAdminLinkVisibility() {
  const token = localStorage.getItem("user_token");
  if (!token) {
    $(".admin-link").hide();
    return;
  }
  // Decode JWT payload
  const payload = JSON.parse(atob(token.split('.')[1]));
  if (payload.user && payload.user.role === "admin") {
    $(".admin-link").show();
  } else {
    $(".admin-link").hide();
  }
}

// Call this on page load and after login
$(document).ready(updateAdminLinkVisibility);
window.addEventListener("storage", updateAdminLinkVisibility); // In case of logout/login in another tab