/* eslint-disable camelcase */

(function ($) {
  "use strict";

  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  var $sidebar = $(".control-sidebar");
  var $container = $("<div />", {
    class: "p-3 control-sidebar-content",
  });

  $sidebar.append($container);

  // Checkboxes

  $container.append('<h5>Configuraciones</h5><hr class="mb-2"/>');

  var $dark_mode_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "dark",
    checked: $("body").hasClass("dark-mode"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $("body").addClass("dark-mode");
      window.localStorage.setItem("isDarkActive", true);
    } else {
      $("body").removeClass("dark-mode");
      window.localStorage.setItem("isDarkActive", false);
    }
  });
  var $dark_mode_container = $("<div />", { class: "mb-4" })
    .append($dark_mode_checkbox)
    .append("<span>Modo oscuro</span>");
  $container.append($dark_mode_container);

  $container.append("<h6>Opciones del menú</h6>");
  var $header_fixed_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "menuFixed",
    checked: $("body").hasClass("layout-navbar-fixed"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $("body").addClass("layout-navbar-fixed");
      window.localStorage.setItem("menuFixed", true);
    } else {
      $("body").removeClass("layout-navbar-fixed");
      window.localStorage.setItem("menuFixed", false);
    }
  });
  var $header_fixed_container = $("<div />", { class: "mb-1" })
    .append($header_fixed_checkbox)
    .append("<span>Fijo</span>");
  $container.append($header_fixed_container);

  var $no_border_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "menuBorder",
    checked: $(".main-header").hasClass("border-bottom-0"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".main-header").addClass("border-bottom-0");
      window.localStorage.setItem("menuBorder", false);
    } else {
      $(".main-header").removeClass("border-bottom-0");
      window.localStorage.setItem("menuBorder", true);
    }
  });
  var $no_border_container = $("<div />", { class: "mb-4" })
    .append($no_border_checkbox)
    .append("<span>Sin bordes</span>");
  $container.append($no_border_container);

  $container.append("<h6>Opciones del menú lateral</h6>");

  var $sidebar_collapsed_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "onlyIcons",
    checked: $("body").hasClass("sidebar-collapse"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $("body").addClass("sidebar-collapse");
      window.localStorage.setItem("onlyIcons", true);
      $(window).trigger("resize");
    } else {
      $("body").removeClass("sidebar-collapse");
      window.localStorage.setItem("onlyIcons", false);
      $(window).trigger("resize");
    }
  });
  var $sidebar_collapsed_container = $("<div />", { class: "mb-1" })
    .append($sidebar_collapsed_checkbox)
    .append("<span>Solo iconos</span>");
  $container.append($sidebar_collapsed_container);

  $(document).on(
    "collapsed.lte.pushmenu",
    '[data-widget="pushmenu"]',
    function () {
      $sidebar_collapsed_checkbox.prop("checked", true);
    }
  );
  $(document).on("shown.lte.pushmenu", '[data-widget="pushmenu"]', function () {
    $sidebar_collapsed_checkbox.prop("checked", false);
  });

  var $flat_sidebar_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "fullWidth",
    checked: $(".nav-sidebar").hasClass("nav-flat"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".nav-sidebar").addClass("nav-flat");
      window.localStorage.setItem("fullWidth", true);
    } else {
      $(".nav-sidebar").removeClass("nav-flat");
      window.localStorage.setItem("fullWidth", false);
    }
  });
  var $flat_sidebar_container = $("<div />", { class: "mb-1" })
    .append($flat_sidebar_checkbox)
    .append("<span>Ancho completo</span>");
  $container.append($flat_sidebar_container);

  var $legacy_sidebar_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: 'navLegacy',
    checked: $(".nav-sidebar").hasClass("nav-legacy"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".nav-sidebar").addClass("nav-legacy");
      window.localStorage.setItem("navLegacy", true);
    } else {
      $(".nav-sidebar").removeClass("nav-legacy");
      window.localStorage.setItem("navLegacy", false);
    }
  });
  var $legacy_sidebar_container = $("<div />", { class: "mb-1" })
    .append($legacy_sidebar_checkbox)
    .append("<span>Estilo sencillo</span>");
  $container.append($legacy_sidebar_container);

  var $compact_sidebar_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "navCompact",
    checked: $(".nav-sidebar").hasClass("nav-compact"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".nav-sidebar").addClass("nav-compact");
      window.localStorage.setItem("navCompact", true);
    } else {
      $(".nav-sidebar").removeClass("nav-compact");
      window.localStorage.setItem("navCompact", false);
    }
  });
  var $compact_sidebar_container = $("<div />", { class: "mb-1" })
    .append($compact_sidebar_checkbox)
    .append("<span>Menú compacto</span>");
  $container.append($compact_sidebar_container);

  var $child_indent_sidebar_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "navChildIndent",
    checked: $(".nav-sidebar").hasClass("nav-child-indent"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".nav-sidebar").addClass("nav-child-indent");
      window.localStorage.setItem("navChildIndent", true);
    } else {
      $(".nav-sidebar").removeClass("nav-child-indent");
      window.localStorage.setItem("navChildIndent", false);
    }
  });
  var $child_indent_sidebar_container = $("<div />", { class: "mb-1" })
    .append($child_indent_sidebar_checkbox)
    .append("<span>Submenu con sangría</span>");
  $container.append($child_indent_sidebar_container);

  var $child_hide_sidebar_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "navCollapseHideChild",
    checked: $(".nav-sidebar").hasClass("nav-collapse-hide-child"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".nav-sidebar").addClass("nav-collapse-hide-child");
      window.localStorage.setItem("navCollapseHideChild", true);
    } else {
      $(".nav-sidebar").removeClass("nav-collapse-hide-child");
      window.localStorage.setItem("navCollapseHideChild", false);
    }
  });
  var $child_hide_sidebar_container = $("<div />", { class: "mb-1" })
    .append($child_hide_sidebar_checkbox)
    .append("<span>Ocultar los subelementos cuando este contraído</span>");
  $container.append($child_hide_sidebar_container);

  var $no_expand_sidebar_checkbox = $("<input />", {
    type: "checkbox",
    value: 1,
    id: "sidebarNoExpand",
    checked: $(".main-sidebar").hasClass("sidebar-no-expand"),
    class: "mr-1",
  }).on("click", function () {
    if ($(this).is(":checked")) {
      $(".main-sidebar").addClass("sidebar-no-expand");
      window.localStorage.setItem("sidebarNoExpand", true);
    } else {
      $(".main-sidebar").removeClass("sidebar-no-expand");
      window.localStorage.setItem("sidebarNoExpand", false);
    }
  });
  var $no_expand_sidebar_container = $("<div />", { class: "mb-4" })
    .append($no_expand_sidebar_checkbox)
    .append("<span>No expandir al pasar el cursor por encima</span>");
  $container.append($no_expand_sidebar_container);
})(jQuery);

window.addEventListener("load", () => {
  window.localStorage.getItem("isDarkActive") === null &&
    window.localStorage.setItem("isDarkActive", false);
  window.localStorage.getItem("menuFixed") === null &&
    window.localStorage.setItem("menuFixed", false);
  window.localStorage.getItem("menuBorder") === null &&
    window.localStorage.setItem("menuBorder", true);
  window.localStorage.getItem("onlyIcons") === null &&
    window.localStorage.setItem("onlyIcons", false);
  window.localStorage.getItem("fullWidth") === null &&
    window.localStorage.setItem("fullWidth", false);
  window.localStorage.getItem("navLegacy") === null &&
    window.localStorage.setItem("navLegacy", false);
  window.localStorage.getItem("navCompact") === null &&
    window.localStorage.setItem("navCompact", false);
  window.localStorage.getItem("navChildIndent") === null &&
    window.localStorage.setItem("navChildIndent", false);
  window.localStorage.getItem("navCollapseHideChild") === null &&
    window.localStorage.setItem("navCollapseHideChild", false);
  window.localStorage.getItem("sidebarNoExpand") === null &&
    window.localStorage.setItem("sidebarNoExpand", false);

  //OPCIONES DEL MODO OSCURO
  if (window.localStorage.getItem("isDarkActive") === "true") {
    document.querySelector("body").classList.add("dark-mode");
    document.getElementById("dark").checked = true;
  }else{
    document.querySelector("body").classList.remove("dark-mode");
    document.getElementById("dark").checked = false;
  }
  //OPCIONES DEL MENU FIJO
  if (window.localStorage.getItem("menuFixed") === "true") {
    document.querySelector("body").classList.add("layout-navbar-fixed");
    document.getElementById("menuFixed").checked = true;
  }else{
    document.querySelector("body").classList.remove("layout-navbar-fixed");
    document.getElementById("menuFixed").checked = false;
  }
  //OPCIONES DEL MENU FIJO
  if (window.localStorage.getItem("menuBorder") === "false") {
    document.querySelector(".main-header").classList.add("border-bottom-0");
    document.getElementById("menuBorder").checked = true;
  }else{
    document.querySelector(".main-header").classList.remove("border-bottom-0");
    document.getElementById("menuBorder").checked = false;
  }
  //OPCIONES DE VISTA SOLO ICONOS
  if (window.localStorage.getItem("onlyIcons") === "true") {
    document.querySelector("body").classList.add("sidebar-collapse");
    document.getElementById("onlyIcons").checked = true;
  }else{
    document.querySelector("body").classList.remove("sidebar-collapse");
    document.getElementById("onlyIcons").checked = false;
  }
  //OPCIONES DE VISTA ANCHO COMPLETO
  if (window.localStorage.getItem("fullWidth") === "true") {
    document.querySelector("body").classList.add("layout-fixed");
    document.getElementById("fullWidth").checked = true;
  }else{
    document.querySelector("body").classList.remove("layout-fixed");
    document.getElementById("fullWidth").checked = false;
  }
  //OPCIONES DE VISTA ESTILOS SENCILLOS
  if (window.localStorage.getItem("navLegacy") === "true") {
    document.querySelector(".nav-sidebar").classList.add("nav-legacy");
    document.getElementById("navLegacy").checked = true;
  }else{
    document.querySelector(".nav-sidebar").classList.remove("nav-legacy");
    document.getElementById("navLegacy").checked = false;
  }
  //OPCIONES DE VISTA MENU COMPACTO
  if (window.localStorage.getItem("navCompact") === "true") {
    document.querySelector(".nav-sidebar").classList.add("nav-compact");
    document.getElementById("navCompact").checked = true;
  }else{
    document.querySelector(".nav-sidebar").classList.remove("nav-compact");
    document.getElementById("navCompact").checked = false;
  }
  //OPCIONES DE VISTA SUBMENU CON SANGRIA
  if (window.localStorage.getItem("navChildIndent") === "true") {
    document.querySelector(".nav-sidebar").classList.add("nav-child-indent");
    document.getElementById("navChildIndent").checked = true;
  }else{
    document.querySelector(".nav-sidebar").classList.remove("nav-child-indent");
    document.getElementById("navChildIndent").checked = false;
  }
  //OPCIONES DE VISTA SUBMENU CON SANGRIA
  if (window.localStorage.getItem("navCollapseHideChild") === "true") {
    document.querySelector(".nav-sidebar").classList.add("nav-collapse-hide-child");
    document.getElementById("navCollapseHideChild").checked = true;
  }else{
    document.querySelector(".nav-sidebar").classList.remove("nav-collapse-hide-child");
    document.getElementById("navCollapseHideChild").checked = false;
  }
  //OPCIONES DE VISTA NO EXPANDIR CON HOVER
  if (window.localStorage.getItem("sidebarNoExpand") === "true") {
    document.querySelector(".main-sidebar").classList.add("sidebar-no-expand");
    document.getElementById("sidebarNoExpand").checked = true;
  }else{
    document.querySelector(".main-sidebar").classList.remove("sidebar-no-expand");
    document.getElementById("sidebarNoExpand").checked = false;
  }


});
