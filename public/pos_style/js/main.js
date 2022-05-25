/*
  ===========================
  ===== Start Component =====
  ===========================
*/
$(function() {
  // ===== Start Time =====
  let dateDIv = $(".date-time .date");
  let timeDIv = $(".date-time .time");
  let date = new Date();
  let year = date.getFullYear();
  let day = ("0" + date.getDate()).slice(-2);
  let month = date.getMonth() + 1;
  month = checkTime(month);
  dateDIv.text(`${year}-${month}-${day}`);

  function startTime() {
    let today = new Date();
    let hour = today.getHours();
    let minutes = today.getMinutes();
    let seconds = today.getSeconds();
    let session = "AM";

    if (hour == 0) {
      hour = 12;
    }

    if (hour > 12) {
      hour = hour - 12;
      session = "PM";
    }
    minutes = checkTime(minutes);
    hour = checkTime(hour);
    seconds = checkTime(seconds);
    timeDIv.text(`${session}  ${hour} : ${minutes}`);
    setTimeout(startTime, 1000);
  }
  function checkTime(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }
  startTime();
  // ===== End Time =====

  // ===== Start Custom Select Box With Search =====
  $("select").each(function() {
    let options = $(this).children("option");
    options.each(function() {
      let myValue = $(this).val();
      $(this).val(
        myValue
          .trim()
          .split(" ")
          .join("-")
      );
    });
    $(this)
      .next(".search-select")
      .find("ul")
      .empty();

    for (let i = 1; i < options.length; i++) {
      let item = $(
        `<li class="search-item" data-value='${options[i].value
          .trim()
          .split(" ")
          .join("-")}'>${options[i].text} <span></span></li>`
      );
      item.appendTo(
        $(this)
          .next(".search-select")
          .find("ul")
      );
    }
    $(this).hide();
  });
  $(".label-Select").on("click", function(e) {
    e.stopPropagation();
    $("html").on("click", function(event) {
      if (!$(event.target).hasClass("search-input")) {
        $(".search-select").removeClass("opened");
      }
    });
    $(this)
      .parents(".search-select")
      .toggleClass("opened");
  });
  $(document).on("click", ".search-item", function() {
    let data = $(this).data("value");
    let SelectParent = $(this).parents(".search-select");

    let myOption = SelectParent.prev("select").find(`option[value="${data}"]`);

    myOption
      .prop("selected", true)
      .siblings()
      .prop("selected", false);

    SelectParent.addClass("choosed");

    SelectParent.find(".select-value").text($(this).text());
    SelectParent.prev("select")
      .val(myOption.val())
      .change();
    $(this)
      .addClass("active")
      .siblings()
      .removeClass("active");
  });
  function filterOptions() {
    const text = $(this)
      .val()
      .toLowerCase();

    let myArr = Array.from(
      $(this)
        .parents(".search-select")
        .find(".search-item")
    );

    myArr.forEach(task => {
      const item = task.textContent;

      if (item.toLowerCase().indexOf(text) != -1) {
        task.style.display = "block";
      } else {
        task.style.display = "none";
      }
    });
  }
  $(document).on("input", ".search-input", filterOptions);
  // ===== End Custom Select Box With Search =====

  // ===== Start Table =====
  $(document).on("click", ".update-table tbody tr", function() {
    let myModal = $(this)
      .parents("#wrapper")
      .find(".modal-info");

    let rowId = $(this).attr("row_id");
    $(".serial").val(rowId);

    myModal
      .attr("row_id", rowId)
      .removeClass("add-today-modal")
      .addClass("modal-update");

    $(this)
      .addClass("active")
      .siblings()
      .removeClass("active");

    let productProperties = Array.from(
      $(this)
        .children("td")
        .not(".check")
        .find("span[data-input]")
    );
    let productSelected = Array.from(
      $(this)
        .children("td")
        .not(".check")
        .find("span[data-select]")
    );

    productProperties.forEach(prop => {
      myModal
        .find(`input[data-value="${prop.dataset.input}"]`)
        .val(prop.textContent);
    });
    productSelected.forEach(prop => {
      let selectOptionText = prop.textContent
        .trim()
        .split(" ")
        .join("-");
      myModal
        .find(
          `.select-option[data-value="${
            prop.dataset.select
          }"] li[data-value='${prop.getAttribute("val")}']`
        )
        .click();
    });

    myModal.find(`.add-lost-form input[data-value='item_quant']`).val("1");
    myModal.modal("show");
  });
  // For Any Modal Remove Class Modal-Update For Remove Buttons Update And Delete
  $(".modal").on("hidden.bs.modal", function() {
    $(this).attr("row_id", "");
    $(".serial").val("");
    // Empty All SelectBox
    $(this)
      .find(".search-select")
      .each(function() {
        $(this).removeClass("choosed");
        $(this)
          .find("li")
          .removeClass("active");
      });
    $(this)
      .find("select")
      .each(function() {
        $(this)
          .children("option:selected")
          .prop("selected", false);
        $(this).val("");
      });

    $(this).removeClass("modal-update"); // hide Buttons Update And Delete & Show Add Button
    // Empty All inputs In Form
    $(this)
      .find(".main-input input")
      .each(function() {
        $(this).removeClass("error");
      });
    $("tr.active").removeClass("active");
    $(this)
      .find(".nav-link:first-child")
      .addClass("active")
      .siblings()
      .removeClass("active");
    $(this)
      .find(".tab-pane:first-child")
      .addClass("active show")
      .siblings()
      .removeClass("active show");
    if ($(this).hasClass("modal-info")) {
      $(this).addClass("add-today-modal");
    }
  });
  // Add Date Today TO Date Input When Add New Row
  $(".modal").on("show.bs.modal", function() {
    if ($(this).hasClass("add-today-modal")) {
      $(this)
        .find('input[type="date"]')
        .val(dateDIv.text());
    }
  });
  // ===== End Table =====
  $(".new-add").on("click", function(e) {
    e.preventDefault();
    let newRow = $(this)
      .parents(".page-title")
      .find("#new_serial")
      .attr("value");
    let model = $(this)
      .parents("#wrapper")
      .find(".modal-info");
    model.find(".serial").val(newRow);
  });
  // ===== Start Add New Row And Update Row And Remove Row =====
  function fillData(button, row) {
    let allInput = Array.from(button.parents(".row").find("input[data-value]"));
    let allSelect = Array.from(
      button.parents(".row").find("select[data-value]")
    );

    allInput.forEach(pro => {
      row
        .children("td")
        .not(".check")
        .find(`span[data-input="${pro.dataset.value}"]`)
        .text(pro.value);
    });
    allSelect.forEach(pro => {
      row
        .children("td")
        .not(".check")
        .find(`span[data-select="${pro.dataset.value}"]`)
        .text(pro.options[pro.selectedIndex].text);
    });
  }

  $(".add-button").on("click", function(e) {
    e.preventDefault();
    let table = $(this)
      .parents("#wrapper")
      .find(".view-table tbody");
    let newRow = table
      .siblings("tfoot")
      .children("tr")
      .clone();
    let rowLength = table.children("tr").length + 1;
    // newRow.attr("row_id", rowLength);
    // newRow.find(`span.row-id`).text(rowLength);
    fillData($(this), newRow);
    table.prepend(newRow);
    // $(this)
    //   .parents(".modal")
    //   .modal("hide");
    // cuteToast({
    //   type: "success",
    //   message: "تم الاضافة بنجاح",
    //   timer: 2000
    // });
  });
  $(".update-button").on("click", function(e) {
    e.preventDefault();
    let rowId = $(this)
      .parents(".modal")
      .attr("row_id");
    let myRow = $(`tr[row_id='${rowId}']`);
    fillData($(this), myRow);
  });
  $(".remove-button").on("click", function(e) {
    let myModal = $(this).parents(".modal");
    e.preventDefault();
    let rowId = $(this)
      .parents(".modal")
      .attr("row_id");
    // let myRow = $(`tr[row_id='${rowId}']`);
    // cuteAlert({
    //   type: "question",
    //   title: "حذف المنتج",
    //   message: "هل متأكد انك تريد حذف المنتج؟",
    //   confirmText: "موافق",
    //   cancelText: "إلغاء"
    // }).then(e => {
    //   if (e == "confirm") {
    //     myRow.remove();
    //     myModal.modal("hide");
    //     cuteToast({
    //       type: "success",
    //       message: "تم الحذف بنجاح",
    //       timer: 2000
    //     });
    //   } else {
    //   }
    // });
  });
  // ===== End Add New Row And Update Row And Remove Row =====

  /*
  =========================
  ===== End Component =====
  =========================
*/
  /*
  =============================
  ===== Start SideBar Nav =====
  =============================
*/
  $("#menu-toggle").on("click", function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
    $(this)
      .parents(".fixed-brand")
      .toggleClass("hide");
  });
  $("#menu-toggle-2").on("click", function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled-2");
    $(this)
      .parents(".fixed-brand")
      .toggleClass("hide");
    $("#menu ul").hide();
  });
  function initMenu() {
    $("#menu ul").hide();
  }
  $("#menu li a").on("click", function() {
    var checkElement = $(this).next();
    if (checkElement.is("ul") && checkElement.is(":visible")) {
      checkElement.slideUp("normal");
      return false;
    }
    if (checkElement.is("ul") && !checkElement.is(":visible")) {
      $("#menu ul:visible").slideUp("normal");
      checkElement.slideDown("normal");
      return false;
    }
    console.log(!checkElement.is(":visible"));
  });
  $(function() {
    initMenu();
  });
  /*
  ===========================
  ===== End SideBar Nav =====
  ===========================
  */
  /*
  ============================
  ===== Start Sales Page =====
  ============================
  */
  $("#product_unit")
    .next()
    .find("ul li:first-child")
    .click();
  $("#order-opration")
    .next()
    .find("ul li:first-child")
    .click();
    
  $("#order-opration").on("change", function() {
    transBtn = $("#btn-transfare");
    if ($(this).val() == "tsaer") {
      transBtn.prop("disabled", false);
    } else {
      transBtn.prop("disabled", true);
    }
    transBtnAggel = $("#btn-transfare-aggel");
    if ($(this).val() == "tsaer") {
      transBtnAggel.prop("disabled", false);
    } else {
      transBtnAggel.prop("disabled", true);
    }

    totalCheck = $(".total-check");
    if ($(this).val() == "aggel") {
      totalCheck.addClass("btn-enable");
    } else {
      totalCheck.removeClass("btn-enable");
      $(".total-content").fadeOut();
    }
  });

  $(".plus-minus-btn").on("click", function(e) {
    e.preventDefault();
    var button = $(this);
    var oldValue = button
      .parents(".counter-widget")
      .find("input")
      .val();

    if (button.hasClass("plus")) {
      if (oldValue == "") {
        var newVal = 1;
      } else {
        var newVal = parseFloat(oldValue) + 1;
      }
    } else {
      // Don't allow decrementing below zero
      if (oldValue > 0) {
        var newVal = parseFloat(oldValue) - 1;
      } else {
        newVal = 0;
      }
    }
    button
      .parents(".counter-widget")
      .find("input")
      .val(newVal);
  });
  // Create Discont Ratio On Total Item Price
  function careateDiscount(price, quantity, ratio) {
    let beforeDiscount = parseFloat(price) * parseFloat(quantity);
    let afterDiscount =
      parseFloat(beforeDiscount) -
      parseFloat(beforeDiscount) * parseFloat(ratio / 100);

    if (beforeDiscount == afterDiscount) {
      return [false, afterDiscount];
    } else {
      return [true, beforeDiscount, afterDiscount];
    }
  }
  // Create Check Item With Discont On it
  function createItemWithDiscount(
    productName,
    quantity,
    productUnit,
    productPrice,
    priceAfterDis,
    priceBeforeDis
  ) {
    let item = `
  <div class="check-item portlet">
    <div class='item-name'> <bdi> ${productName} </bdi> </div>
    <div class='item-Quantity'> ${quantity} </div>
    <div class='item-unit'> ${productUnit} </div>
    <div class='item-price'> <span>${productPrice}</span> ج.م </div>
    <div class='item-total-price'>
    <p class="new-price"> <span class='total'>${priceAfterDis}</span> ج.م </p>
    <p class="old-price"> <span class='total'>${priceBeforeDis}</span> ج.م </p>
    </div>
    <div class="trash-item"><i class="far fa-trash-alt"></i></div>
  </div>`;
    $(".check .check-body").prepend(item);
  }
  // Create Check Item WithOut Discont On it
  function createItemWithOutDiscount(
    productName,
    quantity,
    productUnit,
    productPrice,
    priceAfterDis
  ) {
    let item = `
  <div class="check-item portlet">
    <div class='item-name'> <bdi> ${productName} </bdi> </div>
    <div class='item-Quantity'> ${quantity} </div>
    <div class='item-unit'> ${productUnit} </div>
    <div class='item-price'> <span>${productPrice}</span> ج.م </div>
    <div class='item-total-price'>
    <p class="new-price"> <span class='total'>${priceAfterDis}</span> ج.م </p>
    </div>
    <div class="trash-item"><i class="far fa-trash-alt"></i></div>
  </div>`;
    $(".check .check-body").prepend(item);
  }
  function calcTotalCheckPrice() {
    let total = 0;
    let products = $(".check .check-body").children(".check-item");
    let totalDiv = $(".check .check-footer").find(".total-value span");

    products.each(function() {
      total += parseFloat(
        $(this)
          .find(".new-price .total")
          .text()
      );
    });
    totalDiv.text(total);
  }
  calcTotalCheckPrice();
  // When Clicked On Add Chart Button Create New Item IN Check
  $(".product-form #add-cart").on("click", function() {
    let productForm = $(this).parents(".product-form");
    let ProductName = productForm.find("#item_name").val();
    let quantity = productForm.find("#item_quant").val();
    let productUnit = productForm.find("#product_unit").val();
    let productPrice = productForm.find("#item_price").val();
    let discountRatio = productForm.find("#discount_ratio").val();

    let createDis = careateDiscount(productPrice, quantity, discountRatio); // make Discount

    if (createDis[0]) {
      createItemWithDiscount(
        ProductName,
        quantity,
        productUnit,
        productPrice,
        createDis[2],
        createDis[1]
      );
    } else {
      createItemWithOutDiscount(
        ProductName,
        quantity,
        productUnit,
        productPrice,
        createDis[1]
      );
    }

    createNewItemAnimation(); // New Item Animation
  });
  // Chart Icon Animation In Button And Check
  function createNewItemAnimation() {
    let iconBuuton = $("#add-cart").find("i");
    let firstItem = $(".check .check-body")
      .children()
      .first();
    iconBuuton.removeClass("in-place").addClass("go");
    $(".go").on("transitionend", function() {
      $(this).removeClass("go");
      firstItem.addClass("added");
    });
    firstItem.on("transitionend", function() {
      iconBuuton.addClass("in-place");
      calcTotalCheckPrice();
    });
  }

  // Chart Icon Animation In Button And Check
  function createDeleteItemAnimation(button) {
    let itemParent = button.parents(".check-item");
    button.animate(
      {
        height: "100%",
        "font-size": "1.5em"
      },
      500,
      function() {
        itemParent.addClass("delete");
      }
    );

    itemParent.on("transitionend", function() {
      $(this).remove();
      calcTotalCheckPrice();
    });
  }

  $(".discount-check").on("click", function(e) {
    e.stopPropagation();
    $(".discount-content").fadeToggle();
    $(".total-content").fadeOut();
  });

  $(document).on("click", ".btn-enable", function(e) {
    e.stopPropagation();
    $(".total-content").fadeToggle();
    $(".discount-content").fadeOut();
  });
  /*
  ==========================
  ===== End Sales Page =====
  ==========================
*/
  /*
  ===============================
  ===== Start Products Page =====
  ===============================
*/
  // ===== Start Form In Modal =====
  let productQuantity = $(`input[data-value='item_quant']`);
  let productPieces = $(`input[data-value='item_pieces']`);
  let wholeSalePrice = $(`input[data-value='wholesale_price_pieces']`);
  let retailSalePrice = $(`input[data-value='retail_price_pieces']`);
  let buyPrice = $(`input[data-value='buy_price_pieces']`);
  // Function To Create Multiply For Quantity With Pieces
  function Multiply(numPieces, numQuant, txt) {
    numPieces == "" ? (numPieces = 1) : (numPieces = numPieces);
    numQuant == "" ? (numQuant = 1) : (numQuant = numQuant);
    let multiply = parseFloat(numPieces) * parseFloat(numQuant);
    txt.val(multiply.toFixed(2));
  }
  // Function To Create Divition For Any Price By Pieces
  function division(numPieces, price, txt) {
    numPieces == "" ? (numPieces = 1) : (numPieces = numPieces);
    let div = parseFloat(price) / parseFloat(numPieces);
    txt.val(div.toFixed(2));
  }
  // Function To Change Price With Change Pieces Value
  function getPriceWithPieces() {
    let pieces = $("#pieces").val();
    let wholePrice = wholeSalePrice.val() || 0;
    let retailPrice = retailSalePrice.val() || 0;
    let buy = buyPrice.val() || 0;

    let wholesalePriceMessage = wholeSalePrice
      .siblings(".input-message")
      .find("input");
    let retailPriceMessage = retailSalePrice
      .siblings(".input-message")
      .find("input");
    let buyPriceMessage = buyPrice.siblings(".input-message").find("input");

    wholesalePriceMessage.val(
      (parseFloat(wholePrice) / parseFloat(pieces)).toFixed(2)
    );
    retailPriceMessage.val(
      (parseFloat(retailPrice) / parseFloat(pieces)).toFixed(2)
    );
    buyPriceMessage.val((parseFloat(buy) / parseFloat(pieces)).toFixed(2));
  }

  productQuantity.on("input", function() {
    let numberOfPieces = $(this)
      .parents(".row")
      .find(`input[data-value='item_pieces']`);
    Multiply(
      numberOfPieces.val(),
      $(this).val(),
      numberOfPieces.siblings(".input-message").find("input")
    );
  });
  productPieces.on("input", function() {
    let numberOfQuantity = $(this)
      .parents(".row")
      .find(`input[data-value='item_quant']`);
    Multiply(
      $(this).val(),
      numberOfQuantity.val(),
      $(this)
        .siblings(".input-message")
        .find("input")
    );
    getPriceWithPieces();
  });
  wholeSalePrice.on("input", function() {
    let numberOfPieces = $(this)
      .parents(".row")
      .find(`input[data-value='item_pieces']`);
    division(
      numberOfPieces.val(),
      $(this).val(),
      $(this)
        .siblings(".input-message")
        .find("input")
    );
  });
  retailSalePrice.on("input", function() {
    let numberOfPieces = $(this)
      .parents(".row")
      .find(`input[data-value='item_pieces']`);
    division(
      numberOfPieces.val(),
      $(this).val(),
      $(this)
        .siblings(".input-message")
        .find("input")
    );
  });
  buyPrice.on("input", function() {
    let numberOfPieces = $(this)
      .parents(".row")
      .find(`input[data-value='item_pieces']`);
    division(
      numberOfPieces.val(),
      $(this).val(),
      $(this)
        .siblings(".input-message")
        .find("input")
    );
  });
  // ===== End Form In Modal =====
  /*
  ===============================
  ===== End Products Page =====
  ===============================
*/
  /*
  ==============================
  ===== Start Expense Page =====
  ==============================
*/
  $("#expense-search").on("change", function() {
    let serachDate = $(this)
      .parents(".search-container")
      .find(".search-date");
    let searchNamePrice = $(this)
      .parents(".search-container")
      .find(".search-name");
    if ($(this).val() == "date") {
      serachDate.each(function() {
        $(this).removeClass("d-none");
      });
      searchNamePrice.each(function() {
        $(this).addClass("d-none");
      });
    } else {
      serachDate.each(function() {
        $(this).addClass("d-none");
      });
      searchNamePrice.each(function() {
        $(this).removeClass("d-none");
      });
    }
  });
  /*
  ============================
  ===== End Expense Page =====
  ============================
*/
  /*
  ===============================
  ===== Start Exchange Page =====
  ===============================
*/
  // Remove Row From Table
  // $(document).on("click", "td.remove-row button", function(e) {
  //   e.stopPropagation();
  //   cuteAlert({
  //     type: "question",
  //     title: "حذف اذن",
  //     message: "هل متأكد انك تريد حذف الأذن؟",
  //     confirmText: "موافق",
  //     cancelText: "إلغاء"
  //   }).then(e => {
  //     if (e == "confirm") {
  //       $(this)
  //         .parents("tr")
  //         .remove();

  //       cuteToast({
  //         type: "success",
  //         message: "تم الحذف بنجاح",
  //         timer: 2000
  //       });
  //     } else {
  //     }
  //   });
  // });

  /* =============== Exchange Page And Supply Page Component =============== */
  // ===== Start Change SelectBox =====
  $(".select-changed").on("change", function() {
    let myOption = $(this)
      .find("option:selected")
      .data("price");
    let myInput = $(this)
      .parents("form")
      .find("input:disabled");
    myInput.val(myOption);
    myInput.attr("price", myOption);
  });
  // ===== End Change SelectBox =====
  // Make Mathmatic To Return Money For Customer
  $("#paid_amount").on("input", function() {
    let forHimInput = $(this)
      .parents("form")
      .find("input:disabled");

    if ($(this).val() != "") {
      let rest =
        parseFloat(forHimInput.attr("price")) - parseFloat($(this).val());

      forHimInput.val(rest);
    } else {
      forHimInput.val(forHimInput.attr("price"));
    }
  });
  /* =============== Exchange Page And Supply Page Component =============== */
  /*
  =============================
  ===== End Exchange Page =====
  =============================
*/
  /*
  ============================
  ===== Start Staff Page =====
  ============================
*/
  // ================= Attend and leave Modal ====================
  let leaveButton = $(".leave-button");
  let attendStaffButton = $(".attend-staff-button");
  let attendEmployeeButton = $(".attend-employee-button");

  $("#employee-select").on("change", function() {
    let row_id = $(this)
      .find("option:selected")
      .data("code");
    let employeeRow = $(".employee-table").find(`tr[row_id='${row_id}']`);
    if (employeeRow.length == 0) {
      attendEmployeeButton.prop("disabled", false);
    } else {
      attendEmployeeButton.prop("disabled", true);
    }
  });
  function attendLeaveButtons(checkboxs, attendButton, leaveButton) {
    let attendCount = 0;
    let leaveCount = 0;

    checkboxs.each(function() {
      let attendCell = $(this)
        .parents("tr")
        .find(".attend");

      let leaveCell = $(this)
        .parents("tr")
        .find(".leave");

      if (attendCell.text() == "") {
        attendCount += 1;
        leaveCount = leaveCount;
      } else {
        attendCount = attendCount;
        leaveCell.text() == "" ? (leaveCount += 1) : (leaveCount = leaveCount);
      }

      attendCount == checkboxs.length
        ? attendButton.prop("disabled", false)
        : attendButton.prop("disabled", true);

      leaveCount == checkboxs.length
        ? leaveButton.prop("disabled", false)
        : leaveButton.prop("disabled", true);
    });

    attendCount === 0 ? attendButton.prop("disabled", true) : false;
    leaveCount === 0 ? leaveButton.prop("disabled", true) : false;
  }
  $(document).on("click", '.fl-table tbody input[type="checkbox"]', function() {
    checkedCkeckbox($(this));
    CalcCheckboxex($(this));
  });
  attendEmployeeButton.on("click", function() {
    let employeeCode = $(this)
      .parents(".modal")
      .find("#employee-select option:selected");
    let tamplateRow = `
        <tr row_id='${employeeCode.data("code")}'>
          <td><input type="checkbox" name='employee'></td>
          <td>${employeeCode.data("code")}</td>
          <td>${employeeCode.text()}</td>
          <td class='attend'>${timeDIv.text()}</td>
          <td class='leave'></td>
          <td class='hours'>12</td>
          <td class='today'>${dateDIv.text()}</td>
        </tr>
    `;
    let employeeTable = $(this)
      .parents(".modal")
      .find(".employee-table tbody");

    employeeTable.append(tamplateRow);

    // Empty All SelectBox
    $(this)
      .parents(".portlet-content-form")
      .find(".search-select")
      .each(function() {
        $(this).removeClass("choosed");
        $(this)
          .find("li")
          .removeClass("active");
      });
    $(this)
      .parents(".portlet-content-form")
      .find("#staff-select")
      .each(function() {
        $(this)
          .children("option:selected")
          .prop("selected", false);
        $(this).val("");
      });

    $(this).prop("disabled", true);
  });
  attendStaffButton.on("click", function() {
    let staffTable = $(".staff-table tbody").find("tr.active");
    staffTable.each(function() {
      $(this)
        .find(".attend")
        .text(timeDIv.text());
      $(this)
        .find('input[type="checkbox"]')
        .prop("checked", false);
      $(this).removeClass("active");
    });
    $(this)
      .parents(".tab-pane")
      .find(".fl-table .check-all")
      .prop("checked", false);
    $(this).prop("disabled", true);
  });
  leaveButton.on("click", function() {
    let employeeRow = $(this)
      .parents(".tab-pane")
      .find(".fl-table tr.active");

    employeeRow.each(function() {
      $(this)
        .find(".leave")
        .text(timeDIv.text());
      $(this)
        .prop("disabled", true)
        .css({
          cursor: "not-allowed",
          background: "#efefef",
          color: "#6c6b6b"
        })
        .removeClass("active");
      $(this)
        .find('input[type="checkbox"]')
        .prop("disabled", true);
    });
    $(this)
      .parents(".tab-pane")
      .find(".fl-table .check-all")
      .prop("checked", false);
    $(this).prop("disabled", true);
  });
  function checkedCkeckbox(checkbox) {
    if (checkbox.is(":checked")) {
      checkbox.parents("tr").addClass("active");
    } else {
      checkbox.parents("tr").removeClass("active");
    }
  }
  function CalcCheckboxex(checkbox) {
    let name = checkbox.attr("name");

    let leaveButton = checkbox.parents(".tab-pane").find(".leave-button");
    let attendButton = checkbox.parents(".tab-pane").find(".attend-button");

    let allCheckboxes = checkbox
      .parents("tbody")
      .find('input[type="checkbox"]')
      .not(":disabled");

    let checkboxChecked = checkbox
      .parents("tbody")
      .find('input[type="checkbox"]:checked')
      .not(":disabled");

    let mainCheckbox = $(`input[name="${name}"].check-all`);

    if (allCheckboxes.length == checkboxChecked.length) {
      mainCheckbox.prop("checked", true);
    } else {
      mainCheckbox.prop("checked", false);
    }
    attendLeaveButtons(checkboxChecked, attendButton, leaveButton);
  }
  $("th input.check-all").on("click", function() {
    let allCheckboxes = $(this)
      .parents("table")
      .find('tbody input[type="checkbox"]')
      .not(":disabled");

    if ($(this).is(":checked")) {
      allCheckboxes.each(function() {
        $(this).prop("checked", true);
        checkedCkeckbox($(this));
        CalcCheckboxex($(this));
      });
    } else {
      allCheckboxes.each(function() {
        $(this).prop("checked", false);
        checkedCkeckbox($(this));
        CalcCheckboxex($(this));
      });
    }
  });
  // ================= Attend and leave Modal ====================
  /*
    ============================
    ===== End Staff Page =====
    ============================
  */

/*
  ==============================
  ===== Start Reports Page =====
  ==============================
*/

  $("#reports-search").on("change", function() {
    let serachDate = $(this)
      .parents(".search-container")
      .find(".search-date");
    let searchNamePrice = $(this)
      .parents(".search-container")
      .find(".search-name");

    let searchCustomer = $(this)
      .parents(".search-container")
      .find(".search-customer");

      serachDate.each(function() {
        $(this).addClass("d-none");
      });
      searchNamePrice.each(function() {
        $(this).addClass("d-none");
      });
      searchCustomer.addClass('d-none');

    if ($(this).val() == "id") {
      searchNamePrice.each(function() {
        $(this).removeClass("d-none");
      });
    } else if ($(this).val() == "customer") {
      searchCustomer.removeClass('d-none');
      serachDate.each(function() {
        $(this).removeClass("d-none");
      });
    } else {
      serachDate.each(function() {
        $(this).removeClass("d-none");
      });
    }
  });
/*
  ============================
  ===== End Reports Page =====
  ============================
*/

});
