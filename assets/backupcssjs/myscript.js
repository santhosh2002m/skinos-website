(function ($) {
  "use strict";

  // Configure toastr to display at the bottom-right
  toastr.options = {
    positionClass: "toast-bottom-right",
    closeButton: true,
    progressBar: true,
    timeOut: 3000,
    extendedTimeOut: 1000,
  };

  // Function to force bottom-right position
  function ensureToastPosition() {
    toastr.options.positionClass = "toast-bottom-right";
    $("#toast-container")
      .removeClass(
        "toast-top-right toast-top-left toast-bottom-left toast-top-center toast-bottom-center"
      )
      .addClass("toast-bottom-right");
  }

  // Wishlist
  $(document).on("click", ".wishlist", function (e) {
    e.preventDefault();
    const $this = $(this);
    if ($(this).data("href")) {
      $.get($(this).data("href"), function (data) {
        ensureToastPosition();
        if (data[0] == 1) {
          toastr.success(data["success"]);
          $this.children().addClass("active");
        } else {
          toastr.error(data["error"]);
        }
      });
    }
  });

  // Compare
  $(document).on("click", ".compare_product", function (e) {
    e.preventDefault();
    $.get($(this).data("href"), function (data) {
      ensureToastPosition();
      if (data[0] == 0) {
        toastr.success(data["success"]);
      } else {
        toastr.error(data["error"]);
      }
    });
  });

  // Product Add Qty
  $(document).on("click", ".qtplus", function () {
    var $tselector = $("#order-qty");
    var stock = $("#stock").val();
    var total = $($tselector).val();
    if (stock != "") {
      var stk = parseInt(stock);
      if (total < stk) {
        total++;
        $($tselector).val(total);
      }
    } else {
      total++;
    }
    $($tselector).val(total);
  });

  // Product Minus Qty
  $(document).on("click", ".qtminus", function () {
    var $tselector = $("#order-qty");
    var total = $($tselector).val();
    if (total > 1) {
      total--;
    }
    $($tselector).val(total);
  });

  $(".qttotal").keypress(function (e) {
    if (this.value.length == 0 && e.which == 48) {
      return false;
    }
    if (e.which != 8 && e.which != 32) {
      if (isNaN(String.fromCharCode(e.which))) {
        e.preventDefault();
      }
    }
  });

  $(document).on("click", ".stars", function () {
    $(".stars").removeClass("active");
    $(this).addClass("active");
    $("#rating").val($(this).data("val"));
  });

  // Add to cart
  $(document).on("click", ".add_cart_click", function (e) {
    e.preventDefault();
    $.get($(this).attr("data-href"), function (data) {
      ensureToastPosition();
      if (data == "digital") {
        toastr.error(lang.cart_already);
      } else if (data[0] == 0) {
        toastr.error(lang.cart_out);
      } else {
        $("#cart-count").html(data[0]);
        $("#cart-count1").html(data[0]);
        $("#total-cost").html(data[1]);
        $(".cart-popup").load(mainurl + "/carts/view");
        toastr.success(lang.cart_success);
      }
    });
    return true;
  });

  $(document).on("click", ".quantity-up", function () {
    var pid = $(this).parent().find(".prodid").val();
    var itemid = $(this).parent().find(".itemid").val();
    var size_qty = $(this).parent().find(".size_qty").val();
    var size_price = $(this)
      .parent()
      .parent()
      .parent()
      .find(".size_price")
      .val();
    var stck = $("#stock" + itemid).val();
    var qty = parseInt($("#qty" + itemid).val());
    if (stck != "") {
      var stk = parseInt(stck);
      if (qty < stk) {
        qty++;
        $("#qty" + itemid).html(qty);
      }
    } else {
      qty++;
      $("#qty" + itemid).html(qty);
    }
    $.ajax({
      type: "GET",
      url: mainurl + "/addbyone",
      data: {
        id: pid,
        itemid: itemid,
        size_qty: size_qty,
        size_price: size_price,
      },
      success: function (data) {
        $(".gocover").hide();
        ensureToastPosition();
        if (data == 0) {
          toastr.error(lang.cart_out);
        } else {
          $.get(mainurl + "/carts", function (response) {
            $(".load_cart").html(response);
          });
        }
      },
    });
  });

  $(document).on("click", ".quantity-down", function () {
    var pid = $(this).siblings(".prodid").val();
    var itemid = $(this).siblings(".itemid").val();
    var size_qty = $(this).siblings(".size_qty").val();
    var size_price = $(this).siblings(".size_price").val();
    var qty = parseInt($("#qty" + itemid).val());
    var minimum_qty = $(this).siblings(".minimum_qty").val();
    $(".gocover").show();
    if (qty <= 1) {
      $("#qty" + itemid).val("1");
      $(".gocover").hide();
      return false;
    } else if (qty < minimum_qty) {
      return false;
    } else {
      $(".gocover").show();
      $("#qty" + itemid).val(qty);
      $.ajax({
        type: "GET",
        url: mainurl + "/reducebyone",
        data: {
          id: pid,
          itemid: itemid,
          size_qty: size_qty,
          size_price: size_price,
        },
        success: function (data) {
          if (data.qty >= 1) {
            $.get(mainurl + "/carts", function (response) {
              $(".load_cart").html(response);
            });
          } else {
            return false;
          }
        },
      });
    }
  });

  $(document).on("click", ".cart_size", function () {
    let qty = $(this).data("qty");
    $("#stock").val(qty);
    updateProductPrice();
  });

  $(document).on("click", ".cart_color", function () {
    updateProductPrice();
  });

  $(document).on("click", ".cart_attr", function () {
    updateProductPrice();
  });

  function updateProductPrice() {
    let size_price = $(".cart_size input:checked").attr("data-price");
    let color_price = $(".cart_color input:checked").attr("data-price");
    let attr_price = $(".cart_attr:checked")
      .map(function () {
        return $(this).data("price");
      })
      .get()
      .reduce((a, b) => a + b, 0);
    let main_price = $("#product_price").val();
    if (size_price == undefined) {
      size_price = 0;
    }
    if (color_price == undefined) {
      color_price = 0;
    }
    let total =
      parseFloat(size_price) +
      parseFloat(color_price) +
      parseFloat(attr_price) +
      parseFloat(main_price);
    var pos = $("#curr_pos").val();
    var sign = $("#curr_sign").val();
    if (pos == "0") {
      $("#sizeprice").html(sign + total);
    } else {
      $("#sizeprice").html(total + sign);
    }
  }

  $(document).on("click", "#addtodetailscart", function (e) {
    let pid = "";
    let qty = "";
    let size_key = "";
    let size = "";
    let size_qty = "";
    let size_price = "";
    let color = "";
    let color_price = "";
    let values = "";
    let keys = "";
    let prices = "";
    pid = $("#product_id").val();
    qty = $("#order-qty").val();
    size_key = $(".cart_size input:checked").val();
    size = $(".cart_size input:checked").attr("data-key");
    size_qty = $(".cart_size input:checked").attr("data-qty");
    size_price = $(".cart_size input:checked").attr("data-price");
    color = $(".cart_color input:checked").attr("data-color");
    color_price = $(".cart_color input:checked").attr("data-price");
    values = $(".cart_attr:checked")
      .map(function () {
        return $(this).val();
      })
      .get();
    keys = $(".cart_attr:checked")
      .map(function () {
        return $(this).attr("data-key");
      })
      .get();
    prices = $(".cart_attr:checked")
      .map(function () {
        return $(this).attr("data-price");
      })
      .get();
    $.ajax({
      type: "GET",
      url: mainurl + "/addnumcart",
      data: {
        id: pid,
        qty: qty,
        size: size,
        color: color,
        color_price: color_price,
        size_qty: size_qty,
        size_price: size_price,
        size_key: size_key,
        keys: keys,
        values: values,
        prices: prices,
      },
      success: function (data) {
        ensureToastPosition();
        if (data == "digital") {
          toastr.error("Already Added To Cart");
        } else if (data == 0) {
          toastr.error("Out Of Stock");
        } else if (data[3]) {
          toastr.error(lang.minimum_qty_error + " " + data[4]);
        } else {
          $("#cart-count").html(data[0]);
          $("#cart-count1").html(data[0]);
          $(".cart-popup").load(mainurl + "/carts/view");
          $("#cart-items").load(mainurl + "/carts/view");
          toastr.success("Successfully Added To Cart");
        }
      },
    });
  });

  $(document).on("click", "#addtobycard", function () {
    let pid = "";
    let qty = "";
    let size_key = "";
    let size = "";
    let size_qty = "";
    let size_price = "";
    let color = "";
    let color_price = "";
    let values = "";
    let keys = "";
    let prices = "";
    pid = $("#product_id").val();
    qty = $("#order-qty").val();
    size_key = $(".cart_size input:checked").val();
    size = $(".cart_size input:checked").attr("data-key");
    size_qty = $(".cart_size input:checked").attr("data-qty");
    size_price = $(".cart_size input:checked").attr("data-price");
    color = $(".cart_color input:checked").attr("data-color");
    if (color != undefined) {
      color = color.replace("#", "");
    }
    color_price = $(".cart_color input:checked").attr("data-price");
    values = $(".cart_attr:checked")
      .map(function () {
        return $(this).val();
      })
      .get();
    keys = $(".cart_attr:checked")
      .map(function () {
        return $(this).attr("data-key");
      })
      .get();
    prices = $(".cart_attr:checked")
      .map(function () {
        return $(this).attr("data-price");
      })
      .get();
    window.location =
      mainurl +
      "/addtonumcart?id=" +
      pid +
      "&qty=" +
      qty +
      "&size=" +
      size +
      "&color=" +
      color +
      "&color_price=" +
      color_price +
      "&size_qty=" +
      size_qty +
      "&size_price=" +
      size_price +
      "&size_key=" +
      size_key +
      "&keys=" +
      keys +
      "&values=" +
      values +
      "&prices=" +
      prices;
  });
})(jQuery);
