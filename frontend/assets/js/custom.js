$(document).ready(function() {
  console.log("Hello from main index file flowers!")

  var app = $.spapp({
    defaultView  : "#homepage",
    templateDir  : "./pages/",
    pageNotFound : "blank"
  });

  
  app.route({
    view : "homepage",
    load : "homepage.html",
    onCreate: function() {  },
    onReady: function() { HomepageService.init(); }
  });

  app.route({
    view : "aboutus",
    load : "aboutus.html",
    onCreate: function() {  },
    onReady: function() {  }
  });

  app.route({
    view : "items",
    load : "items.html",
    onCreate: function() {  },
    onReady: function() { ItemService.init(); }
  });

  app.route({
    view : "cart",
    load : "cart.html",
    onCreate: function() {  },
    onReady: function() { CartService.init(); }
  });

  app.route({
    view : "checkout",
    load : "checkout.html",
    onCreate: function() {  },
    onReady: function() { CheckoutService.init(); }
  });

  app.route({
    view : "login",
    load : "login.html",
    onCreate: function() {  },
    onReady: function() { LoginService.init(); }
  });

  app.route({
    view : "register",
    load : "register.html",
    onCreate: function() {  },
    onReady: function() { RegisterService.init(); }
  });

  app.route({
    view : "admin",
    load : "admin.html",
    onCreate: function() {  },
    onReady: function() { AdminService.init(); }
  });

  app.route({
    view : "blank",
    load : "blank.html",
    onCreate: function() {  },
    onReady: function() {  }
  });

  app.run();
});
/*
// ORIGINAL SPAPP CODE
$(document).ready(function() {

  $("main#spapp > section").height($(document).height() - 60);

  var app = $.spapp({pageNotFound : 'error_404'}); // initialize

  // define routes
  app.route({
    view: 'view_1',
    onCreate: function() { $("#view_1").append($.now()+': Written on create<br/>'); },
    onReady: function() { $("#view_1").append($.now()+': Written when ready<br/>'); }
  });
  app.route({view: 'view_2', load: 'view_2.html' });
  app.route({
    view: 'view_3', 
    onCreate: function() { $("#view_3").append("I'm the third view"); }
  });

  // run app
  app.run();

});
*/