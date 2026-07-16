jQuery(document).on("click", function (e) {

  if (

    !jQuery(e.target).hasClass("applyBtn") &&

    jQuery(e.target).parents(".filter-item").length == 0 &&

    jQuery(".select2-container--open").length == 0 &&

    !jQuery(".daterangepicker").is(":visible")

  ) {

    jQuery(".filter-item-title,.filter-item,.filter-item-dropdown").removeClass(

      "active"

    );

  }

});



jQuery(document).ready(function () {

  jQuery(".apimo_select2").select2();



  jQuery(".apimo_input_select").select2();



  jQuery(".apimo_slick_slider").each(function () {

    var desktop = parseInt(jQuery(this).attr("data-slide-to-desktop"));



    var tablate = parseInt(jQuery(this).attr("data-slide-to-tablate"));



    var mobile = parseInt(jQuery(this).attr("data-slide-to-mobile"));



    jQuery(this).slick({

      dots: false,



      infinite: false,



      speed: 300,



      slidesToShow: desktop,



      slidesToScroll: 1,



      prevArrow: jQuery(".apimo-carousel-prev"),



      nextArrow: jQuery(".apimo-carousel-next"),



      responsive: [

        {

          breakpoint: 1024,



          settings: {

            slidesToShow: tablate,



            slidesToScroll: 1,



            infinite: true,



            dots: true,

          },

        },



        {

          breakpoint: 600,



          settings: {

            slidesToShow: mobile,



            slidesToScroll: 1,

          },

        },

      ],

    });

  });



  jQuery(".apimo-propery-images.apimo-display").slick({

    slidesToShow: 1,



    slidesToScroll: 1,



    adaptiveHeight: true,



    arrows: true,



    fade: true,



    asNavFor: ".apimo-propery-images.apimo-navbar",



    prevArrow: jQuery(".apimo-carousel-prev"),



    nextArrow: jQuery(".apimo-carousel-next"),

  });



  jQuery(".apimo-propery-images.apimo-navbar").slick({

    slidesToShow: 7,



    slidesToScroll: 1,



    asNavFor: ".apimo-propery-images.apimo-display",



    centerMode: false,



    focusOnSelect: true,



    arrows: false,

  });



  if (jQuery(".apimo-archive-pagination-div").length) {

    jQuery(".apimo-archive-pagination-div").each(function () {

      apimo_refresh_pagination(jQuery(this).attr("data-unique-id"));

    });

  }



  jQuery(".apimo_dates_filter_input").each(function () {

    var $this = jQuery(this);



    var unique_id = jQuery(this).attr("data-unique-id");



    $this.daterangepicker({}, function (start, end, label) {

      jQuery(

        '.apimo_input_text[data-unique-id="' +

          unique_id +

          '"][data-id="apimo_dates_end"]'

      ).val(end.format("YYYY-MM-DD"));



      jQuery(

        '.apimo_input_text[data-unique-id="' +

          unique_id +

          '"][data-id="apimo_dates_start"]'

      )

        .val(start.format("YYYY-MM-DD"))

        .trigger("change");



      console.log(

        "A new date selection was made: " +

          start.format("YYYY-MM-DD") +

          " to " +

          end.format("YYYY-MM-DD")

      );



      jQuery(".apimo_dates_filter_input").html(

        admin_urls.from +

          " " +

          start.format("YYYY-MM-DD") +

          " " +

          admin_urls.to +

          " " +

          end.format("YYYY-MM-DD")

      );



      //apimo_archive_load_data_ajax(unique_id);

    });

  });



  refreshFsLightbox();



  initArchiveSlide();

});



jQuery(document).on(

  "click",

  ".apimo-filters .filter-item .filter-item-title",

  function () {

    if (!jQuery(this).hasClass("active")) {

      jQuery(

        ".filter-item,.filter-item-title,.filter-item-dropdown"

      ).removeClass("active");

    }



    jQuery(this).toggleClass("active");



    jQuery(this).parent(".filter-item").toggleClass("active");



    jQuery(this).next(".filter-item-dropdown").toggleClass("active");



    jQuery(".filter-lists-value").removeClass("min-done");



    jQuery(".range-from input,.range-to input").removeClass("apimo-focus");



    jQuery(".range-from input:visible").focus().addClass("apimo-focus");

  }

);



jQuery(document).on(

  "click",

  ".apimo-filters .filter-item .filter-lists-value li",

  function () {

    var data = jQuery(this).data("value");



    jQuery(this).toggleClass("active");



    jQuery(this).next(".filter-item-dropdown").toggleClass("active");

  }

);



jQuery(document).on("change", ".apimo_filter_order_by", function () {

  apimo_archive_load_data_ajax(jQuery(this).attr("data-unique-id"));

});



jQuery(document).on("click", ".apimo-apply-filter", function () {

  apimo_archive_load_data_ajax(jQuery(this).attr("data-unique-id"));



  jQuery(".filter-item").removeClass("active");



  jQuery(".filter-item-title").removeClass("active");



  jQuery(".filter-item-dropdown").removeClass("active");



  update_active_filter(jQuery(this).attr("data-unique-id"));

});



function update_active_filter(unique_id) {

  var number_of_rooms = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="number_of_rooms"]'

  ).val();



  var number_of_bedrooms = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="number_of_bedrooms"]'

  ).val();



  var price_range_min = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="price_range_min"]'

  ).val();



  var price_range_max = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="price_range_max"]'

  ).val();



  var property_areas_min = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="property_areas_min"]'

  ).val();



  var property_areas_max = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="property_areas_max"]'

  ).val();



  var order_by = jQuery('[name="order-by-properties"]:checked').val();



  var advance_area = [];



  jQuery(

    '.apimo_input_checkbox[data-unique-id="' +

      unique_id +

      '"][name="apimo_advance[areas][]"]:checked'

  ).each(function () {

    advance_area.push(jQuery(this).val());

  });







  var advance_service = [];



  jQuery(

    '.apimo_input_checkbox[data-unique-id="' +

      unique_id +

      '"][name="apimo_advance[service][]"]:checked'

  ).each(function () {

    advance_service.push(jQuery(this).val());

  });



  var category_filter = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_category_filter"]'

  );



  console.log(category_filter);

  var subtype_filter = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_subtype_filter"]'

  );



  var country = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_country"]'

  );



  var region = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_region"]'

  );



  var district = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_district"]'

  );



  var city = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_city"]'

  );

  var zone = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_zone"]'

  );

 console.log(zone);


  var start_date = jQuery(

    '.apimo_input_text[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_dates_start"]'

  ).val();



  var end_date = jQuery(

    '.apimo_input_text[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_dates_end"]'

  ).val();



  var date_filter_type = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][name="apimo_date_filter_type"]:checked'

  ).val();



  var filter_list = jQuery(

    '.apimo-active-filter-list[data-unique-id="' + unique_id + '"]'

  );



  filter_list.html("");



  var remove_html = jQuery(".apimo-filter-remove-all .icon").html();



  var filter_count = 0;



  if (subtype_filter.val() != "" && subtype_filter.val() !== undefined) {

    filter_count++;



    filter_list.append(

      '<div class="apimo-filter">' +

        subtype_filter.find("option:selected").html() +

        '  <div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="apimo_subtype_filter" >' +

        remove_html +

        "</div></div>"

    );

  }



  if (category_filter.val() != "" && category_filter.val() !== undefined) {

    filter_count++;



    filter_list.append(

      '<div class="apimo-filter">' +

        category_filter.find("option:selected").html() +

        '  <div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="apimo_category_filter" >' +

        remove_html +

        "</div></div>"

    );

  }



  if (country.val() != "" && country.val() !== undefined) {

    filter_count++;



    filter_list.append(

      '<div class="apimo-filter">' +

        country.find("option:selected").html() +

        '  <div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="country" >' +

        remove_html +

        "</div></div>"

    );

  }



  if (region.val() != "" && region.val() !== undefined) {

    filter_count++;



    filter_list.append(

      '<div class="apimo-filter" >' +

        region.find("option:selected").html() +

        '  <div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="region" >' +

        remove_html +

        "</div></div>"

    );

  }



  if (district.val() != "" && district.val() !== undefined) {

    filter_count++;



    filter_list.append(

      '<div class="apimo-filter" >' +

        district.find("option:selected").html() +

        '  <div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="district" >' +

        remove_html +

        "</div></div>"

    );

  }



  if (city.val() != "" && city.val() !== undefined) {

    filter_count++;



    filter_list.append(

      '<div class="apimo-filter" >' +

        city.find("option:selected").html() +

        '  <div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="city" >' +

        remove_html +

        "</div></div>"

    );

  }

  if (zone.val() != "" && zone.val() !== undefined) {

    filter_count++;



    filter_list.append(

      '<div class="apimo-filter" >' +

        zone.find("option:selected").html() +

        '  <div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="zone" >' +

        remove_html +

        "</div></div>"

    );

  }




  if (number_of_rooms != 0 && number_of_rooms !== undefined) {

    filter_count++;



    filter_list.append(

      '<div class="apimo-filter"><span>' +

        number_of_rooms +

        ' Rooms</span><div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="rooms" >' +

        remove_html +

        "</div></div>"

    );

  }



  if (number_of_bedrooms != 0 && number_of_bedrooms !== undefined) {

    filter_count++;



    filter_list.append(

      '<div class="apimo-filter"><span>' +

        number_of_bedrooms +

        ' Bedrooms</span><div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="bedrooms" >' +

        remove_html +

        "</div></div>"

    );

  }



  if (

    (price_range_min !== undefined && price_range_min != "") ||

    (price_range_max !== undefined && price_range_max != "")

  ) {

    filter_count++;



    $price_html = "";



    if (price_range_min != "" && price_range_max == "") {

      $price_html = ">= " + price_range_min + "€";

    } else if (price_range_min == "" && price_range_max != "") {

      $price_html = "<= " + price_range_max + "€";

    } else if (price_range_min != "" && price_range_max != "") {

      $price_html = price_range_min + "€" + " - " + price_range_max + "€";

    }



    filter_list.append(

      '<div class="apimo-filter"><span>' +

        $price_html +

        '</span><div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="price"  >' +

        remove_html +

        "</div></div>"

    );

  }



  if (

    (property_areas_min !== undefined && property_areas_min != "") ||

    (property_areas_max !== undefined && property_areas_max != "")

  ) {

    filter_count++;



    $price_html = "";



    if (property_areas_min != "" && property_areas_max == "") {

      $price_html = ">= " + property_areas_min + " m<sup>2</sup>";

    } else if (property_areas_min == "" && property_areas_max != "") {

      $price_html = "<= " + property_areas_max + " m<sup>2</sup>";

    } else if (property_areas_min != "" && property_areas_max != "") {

      $price_html =

        property_areas_min +

        " m<sup>2</sup>" +

        " - " +

        property_areas_max +

        " m<sup>2</sup>";

    }



    filter_list.append(

      '<div class="apimo-filter"><span>' +

        $price_html +

        '</span><div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="area_remove"  >' +

        remove_html +

        "</div></div>"

    );

  }



  if (

    start_date !== undefined &&

    start_date != "" &&

    end_date !== undefined &&

    end_date != ""

  ) {

    filter_count++;



    let label = jQuery(

      '.apimo_filter_input[data-unique-id="' +

        unique_id +

        '"][name="apimo_date_filter_type"]'

    )

      .parent()

      .find("label")

      .html();



    filter_list.append(

      '<div class="apimo-filter" >' +

        label +

        " " +

        start_date +

        " - " +

        end_date +

        '  <div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="date"  >' +

        remove_html +

        "</div></div>"

    );

  }



  jQuery(

    '.apimo_input_checkbox[data-unique-id="' +

      unique_id +

      '"][name="apimo_advance[service][]"]:checked'

  ).each(function () {

    filter_count++;



    filter_list.append(

      '<div class="apimo-filter" > ' +

        jQuery(this).parent().find(".text").html() +

        '  <div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '" data-id="services" data-attr-id="' +

        jQuery(this).attr("id") +

        '" >' +

        remove_html +

        "</div></div>"

    );

  });



  jQuery(

    '.apimo_input_checkbox[data-unique-id="' +

      unique_id +

      '"][name="apimo_advance[areas][]"]:checked'

  ).each(function () {

    filter_count++;



    filter_list.append(

      '<div class="apimo-filter" > ' +

        jQuery(this).parent().find(".text").html() +

        '  <div class="apimo-remove-filter" data-unique-id="' +

        unique_id +

        '"  data-id="areas"  data-attr-id="' +

        jQuery(this).attr("id") +

        '" >' +

        remove_html +

        "</div></div>"

    );

  });



  if (filter_count == 0) {

    jQuery(

      '.apimo-active-filter[data-unique-id="' + unique_id + '"]'

    ).slideUp();

  } else {

    jQuery(

      '.apimo-active-filter[data-unique-id="' + unique_id + '"]'

    ).slideDown();

  }

}



jQuery(document).on("click", ".apimo-remove-filter", function () {

  var unique_id = jQuery(this).attr("data-unique-id");



  var data_id = jQuery(this).attr("data-id");



  var attr_id = jQuery(this).attr("data-attr-id");



  jQuery(this).parent().remove();



  if (data_id == "apimo_category_filter") {

    jQuery(

      '.apimo_input_select[data-unique-id="' +

        unique_id +

        '"][data-id="apimo_category_filter"]'

    )

      .val("")

      .trigger("change");

  }



  if (data_id == "apimo_subtype_filter") {

    jQuery(

      '.apimo_input_select[data-unique-id="' +

        unique_id +

        '"][data-id="apimo_subtype_filter"]'

    )

      .val("")

      .trigger("change");

  }



  if (data_id == "country") {

    jQuery(

      '.apimo_input_select[data-unique-id="' +

        unique_id +

        '"][data-id="apimo_country"]'

    )

      .val("")

      .trigger("change");

  }



  if (data_id == "region") {

    jQuery(

      '.apimo_input_select[data-unique-id="' +

        unique_id +

        '"][data-id="apimo_region"]'

    )

      .val("")

      .trigger("change");

  } else if (data_id == "district") {

    jQuery(

      '.apimo_input_select[data-unique-id="' +

        unique_id +

        '"][data-id="apimo_district"]'

    )

      .val("")

      .trigger("change");

  } else if (data_id == "city") {

    jQuery(

      '.apimo_input_select[data-unique-id="' +

        unique_id +

        '"][data-id="apimo_city"]'

    )

      .val("")

      .trigger("change");

  } else if (data_id == "zone") {

    jQuery(

      '.apimo_input_select[data-unique-id="' +

        unique_id +

        '"][data-id="apimo_zone"]'

    )

      .val("")

      .trigger("change");


  } else if (data_id == "rooms") {

    jQuery(

      '.apimo_filter_input[data-unique-id="' +

        unique_id +

        '"][data-id="number_of_rooms"]'

    )

      .val("0")

      .trigger("change");

  } else if (data_id == "bedrooms") {

    jQuery(

      '.apimo_filter_input[data-unique-id="' +

        unique_id +

        '"][data-id="number_of_bedrooms"]'

    )

      .val("0")

      .trigger("change");

  } else if (data_id == "areas") {

    jQuery(

      '.apimo_input_checkbox[data-unique-id="' +

        unique_id +

        '"][id="' +

        attr_id +

        '"]'

    ).trigger("click");

  } else if (data_id == "services") {

    jQuery(

      '.apimo_input_checkbox[data-unique-id="' +

        unique_id +

        '"][id="' +

        attr_id +

        '"]'

    ).trigger("click");

  } else if (data_id == "price") {

    jQuery(

      '.apimo_filter_input[data-unique-id="' +

        unique_id +

        '"][data-id="price_range_min"]'

    )

      .val("")

      .trigger("change");



    jQuery(

      '.apimo_filter_input[data-unique-id="' +

        unique_id +

        '"][data-id="price_range_max"]'

    )

      .val("")

      .trigger("change");

  } else if (data_id == "area_remove") {

    jQuery(

      '.apimo_filter_input[data-unique-id="' +

        unique_id +

        '"][data-id="property_areas_min"]'

    )

      .val("")

      .trigger("change");



    jQuery(

      '.apimo_filter_input[data-unique-id="' +

        unique_id +

        '"][data-id="property_areas_max"]'

    )

      .val("")

      .trigger("change");

  } else if (data_id == "date") {

    jQuery(

      '.apimo_input_text[data-unique-id="' +

        unique_id +

        '"][data-id="apimo_dates_start"]'

    ).val("");



    jQuery(

      '.apimo_input_text[data-unique-id="' +

        unique_id +

        '"][data-id="apimo_dates_end"]'

    ).val("");



    jQuery(".apimo_dates_filter_input").html("Select Date");

  }



  if (

    jQuery('.apimo-remove-filter[data-unique-id="' + unique_id + '"]').length ==

    0

  ) {

    jQuery(

      '.apimo-active-filter[data-unique-id="' + unique_id + '"]'

    ).slideUp();

  } else {

    jQuery(

      '.apimo-active-filter[data-unique-id="' + unique_id + '"]'

    ).slideDown();

  }



  apimo_archive_load_data_ajax(unique_id);

});



jQuery(document).on("click", ".apimo-filter-remove-all", function () {

  var unique_id = jQuery(this).attr("data-unique-id");



  var filter_list = jQuery(

    '.apimo-active-filter-list[data-unique-id="' + unique_id + '"]'

  );



  filter_list.find(".apimo-filter").each(function () {

    jQuery(this).find(".apimo-remove-filter").trigger("click");

  });

});



jQuery(document).on("click", ".filter-mobile-toggle", function () {

  jQuery(".apimo-archive-filters").toggleClass("active");

});



function apimo_archive_load_data_ajax(unique_id) {

  $pagination_div = jQuery(

    '.apimo-archive-pagination-div[data-unique-id="' + unique_id + '"]'

  );



  let pageNumber = $pagination_div.attr("data-current-page");



  let pageSize = $pagination_div.attr("data-post-per-page");



  let number_of_rooms = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="number_of_rooms"]'

  ).val();

  let number_of_bedrooms = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="number_of_bedrooms"]'

  ).val();

  let price_range_min = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="price_range_min"]'

  ).val();



  let price_range_max = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="price_range_max"]'

  ).val();



  let property_areas_min = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="property_areas_min"]'

  ).val();



  let property_areas_max = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][data-id="property_areas_max"]'

  ).val();



  let order_by = jQuery('[name="order-by-properties"]:checked').val();



  let advance_area = [];



  jQuery(

    '.apimo_input_checkbox[data-unique-id="' +

      unique_id +

      '"][name="apimo_advance[areas][]"]:checked'

  ).each(function () {

    advance_area.push(jQuery(this).val());

  });



  let advance_service = [];



  jQuery(

    '.apimo_input_checkbox[data-unique-id="' +

      unique_id +

      '"][name="apimo_advance[service][]"]:checked'

  ).each(function () {

    advance_service.push(jQuery(this).val());

  });



  let category_filter = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_category_filter"]'

  ).val();



  let subtype_filter = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_subtype_filter"]'

  ).val();



  let country = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_country"]'

  ).val();



  let region = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_region"]'

  ).val();



  let district = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_district"]'

  ).val();



  let city = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_city"]'

  ).val();



  let zone = jQuery(

    '.apimo_input_select[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_zone"]'

  ).val();




  let start_date = jQuery(

    '.apimo_input_text[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_dates_start"]'

  ).val();



  let end_date = jQuery(

    '.apimo_input_text[data-unique-id="' +

      unique_id +

      '"][data-id="apimo_dates_end"]'

  ).val();



  let date_filter_type = jQuery(

    '.apimo_filter_input[data-unique-id="' +

      unique_id +

      '"][name="apimo_date_filter_type"]:checked'

  ).val();



  let listing_type = jQuery(

    '.apimo-property-wrapper[data-unique-id="' + unique_id + '"]'

  ).attr("data-type");



  let tax_apimo_property_standing;



  let tax_apimo_property_condition;



  let tax_apimo_heating_access;



  let meta_apimo_construction_year;



  let meta_apimo_bedrooms;



  let meta_apimo_renovation_year;



  let meta_apimo_residence_fees;



  let repository_tags;



  let customised_tags;



  let listing_wrapper = jQuery(

    '.apimo-property-wrapper[data-unique-id="' + unique_id + '"]'

  );



  if (listing_type == "shortcode") {

    if (listing_wrapper.attr("data-category_filter")) {

      category_filter = listing_wrapper.attr("data-category_filter");

    }



    if (listing_wrapper.attr("data-subtype_filter")) {

      subtype_filter = listing_wrapper.attr("data-subtype_filter");

    }



    if (listing_wrapper.attr("data-country")) {

      country = listing_wrapper.attr("data-country");

    }



    if (listing_wrapper.attr("data-region")) {

      region = listing_wrapper.attr("data-region");

    }



    if (listing_wrapper.attr("data-city")) {

      city = listing_wrapper.attr("data-city");

    }

    if (listing_wrapper.attr("data-zone")) {

      zone = listing_wrapper.attr("data-zone");

    }



    if (listing_wrapper.attr("data-district")) {

      district = listing_wrapper.attr("data-district");

    }



    if (listing_wrapper.attr("data-price_range_min")) {

      price_range_min = listing_wrapper.attr("data-price_range_min");

    }



    if (listing_wrapper.attr("data-price_range_max")) {

      price_range_max = listing_wrapper.attr("data-price_range_max");

    }



    if (listing_wrapper.attr("data-property_areas_min")) {

      property_areas_min = listing_wrapper.attr("data-property_areas_min");

    }



    if (listing_wrapper.attr("data-property_areas_max")) {

      property_areas_max = listing_wrapper.attr("data-property_areas_max");

    }



    if (listing_wrapper.attr("data-number_of_rooms")) {

      number_of_rooms = listing_wrapper.attr("data-number_of_rooms");

    }



    if (listing_wrapper.attr("data-number_of_bedrooms")) {

      number_of_bedrooms = listing_wrapper.attr("data-number_of_bedrooms");

    }



    if (listing_wrapper.attr("data-date_filter_type")) {

      date_filter_type = listing_wrapper.attr("data-date_filter_type");

    }



    if (listing_wrapper.attr("data-start_date")) {

      start_date = listing_wrapper.attr("data-start_date");

    }



    if (listing_wrapper.attr("data-end_date")) {

      end_date = listing_wrapper.attr("data-end_date");

    }



    if (listing_wrapper.attr("data-advance_area")) {

      advance_area = listing_wrapper.attr("data-advance_area").split(",");

    }



    if (listing_wrapper.attr("data-tax_apimo_property_standing")) {

      tax_apimo_property_standing = listing_wrapper

        .attr("data-tax_apimo_property_standing")

        .split(",");

    }



    if (listing_wrapper.attr("data-tax_apimo_property_condition")) {

      tax_apimo_property_condition = listing_wrapper

        .attr("data-tax_apimo_property_condition")

        .split(",");

    }



    if (listing_wrapper.attr("data-tax_apimo_heating_access")) {

      tax_apimo_heating_access = listing_wrapper

        .attr("data-tax_apimo_heating_access")

        .split(",");

    }



    if (listing_wrapper.attr("data-meta_apimo_construction_year")) {

      meta_apimo_construction_year = listing_wrapper

        .attr("data-meta_apimo_construction_year")

        .split(",");

    }



    if (listing_wrapper.attr("data-meta_apimo_bedrooms")) {

      meta_apimo_bedrooms = listing_wrapper.attr("data-meta_apimo_bedrooms");

    }



    if (listing_wrapper.attr("data-meta_apimo_renovation_year")) {

      meta_apimo_renovation_year = listing_wrapper

        .attr("data-meta_apimo_renovation_year")

        .split(",");

    }



    if (listing_wrapper.attr("data-meta_apimo_residence_fees")) {

      meta_apimo_residence_fees = listing_wrapper.attr(

        "data-meta_apimo_residence_fees"

      );

    }



    if (listing_wrapper.attr("data-repository_tags")) {

      repository_tags = listing_wrapper.attr("data-repository_tags").split(",");

    }



    if (listing_wrapper.attr("data-customised_tags")) {

      customised_tags = listing_wrapper.attr("data-customised_tags").split(",");

    }

  }



  let desktop = listing_wrapper.attr("data-desktop");



  let tablet = listing_wrapper.attr("data-tablet");



  let mobile = listing_wrapper.attr("data-mobile");



  var data = {

    action: "apimo_archive_filter",



    page: pageNumber,



    size: pageSize,



    number_of_rooms: number_of_rooms,



    number_of_bedrooms: number_of_bedrooms,



    price_range_min: price_range_min,



    price_range_max: price_range_max,



    property_areas_min: property_areas_min,



    property_areas_max: property_areas_max,



    category_filter: category_filter,



    subtype_filter: subtype_filter,



    country: country,



    region: region,



    city: city,


    zone: zone,


    district: district,



    date_filter_type: date_filter_type,



    start_date: start_date,



    end_date: end_date,



    advance_area: advance_area,



    advance_service: advance_service,



    tax_apimo_property_standing: tax_apimo_property_standing,



    tax_apimo_property_condition: tax_apimo_property_condition,



    tax_apimo_heating_access: tax_apimo_heating_access,



    meta_apimo_bedrooms: meta_apimo_bedrooms,



    meta_apimo_construction_year: meta_apimo_construction_year,



    meta_apimo_renovation_year: meta_apimo_renovation_year,



    meta_apimo_residence_fees: meta_apimo_residence_fees,



    repository_tags: repository_tags,



    customised_tags: customised_tags,



    desktop: desktop,



    tablet: tablet,



    mobile: mobile,



    order_by: order_by,

  };



  jQuery(document).on("click", ".search_shortcode_buttton", function () {

    // Retrieve the value of the input with ID 'page_redirect'

    let base_url = jQuery("#page_redirect").val();



    // Initialize the URL with the base URL

    let url = base_url.trim();



    // Check if the base URL already contains query parameters

    if (url.includes("?")) {

      // If it contains query parameters, append '&' to add new parameters

      url += "&";

    } else {

      // If it doesn't contain query parameters, append '?' to start adding parameters

      url += "?";

    }



    for (let key in data) {

      // ignore action param

      if (key == "action") continue;



      if (

        data.hasOwnProperty(key) &&

        data[key] !== undefined &&

        data[key] !== null

      ) {

        url +=

          encodeURIComponent(key) + "=" + encodeURIComponent(data[key]) + "&";

      }

    }



    // Remove the trailing '&' if there are parameters

    url = url.slice(0, -1);



    // Navigate to the constructed URL

    window.location.href = url;

  });



  jQuery('.apimo-loader[data-unique-id="' + unique_id + '"]').show();



  //jQuery('.apimo-property-wrapper[data-unique-id="' + unique_id + '"] .apimo-row').fadeOut();



  if (

    jQuery('.apimo-archive-filters[data-unique-id="' + unique_id + '"]')

      .length > 0

  ) {

    jQuery("html, body").animate(

      {

        scrollTop: jQuery(

          '.apimo-archive-filters[data-unique-id="' + unique_id + '"]'

        ).offset().top,

      },

      1000

    );

  } else {

    jQuery("html, body").animate(

      {

        scrollTop: jQuery(

          '.apimo-content-wrapper[data-unique-id="' + unique_id + '"]'

        ).offset().top,

      },

      1000

    );

  }



  jQuery.post(admin_urls.ajax, data, function (response) {

    var data = JSON.parse(response);

    // console.log(data.max_page);



    jQuery(

      '.apimo-property-wrapper[data-unique-id="' + unique_id + '"] .apimo-row'

    ).html(data.loop_data);



    jQuery(

      '.apimo-archive-pagination-div[data-unique-id="' + unique_id + '"]'

    ).attr("data-max-page", data.max_page);



    apimo_refresh_pagination(unique_id);



    refreshFsLightbox();



    initArchiveSlide();



    jQuery('.apimo-loader[data-unique-id="' + unique_id + '"]').fadeOut();



    jQuery(

      '.apimo-property-wrapper[data-unique-id="' + unique_id + '"] .apimo-row'

    ).fadeIn();

  });

}



function initArchiveSlide() {

  jQuery(".apimo-propery-images-archive").each(function () {

    if (jQuery(this).hasClass("slick-initialized")) {

      jQuery(this).slick("unslick");

    }



    jQuery(this).slick({

      dots: true,



      slide: ".apimo-image",



      infinite: true,



      speed: 500,



      fade: true,



      cssEase: "linear",

    });

  });

}



function apimo_refresh_pagination(unique_id) {

  var $this = jQuery(

    '.apimo-archive-pagination-div[data-unique-id="' + unique_id + '"]'

  );



  var max_page = $this.attr("data-max-page");



  $this.pagination({

    dataSource: function (done) {

      var result = [];



      for (

        var i = 1;

        i < parseInt(max_page * $this.attr("data-post-per-page"));

        i++

      ) {

        result.push(i);

      }



      done(result);

    },



    pageSize: $this.attr("data-post-per-page"),



    totalNumber: max_page,



    pageNumber: $this.attr("data-current-page"),



    autoHidePrevious: true,



    autoHideNext: true,



    callback: function (data, pagination) {

      $this.attr("data-current-page", pagination.pageNumber);



      // apimo_archive_load_data_ajax($this.attr('data-unique-id'));

    },



    afterPageOnClick: function (data, pagination) {

      console.log(data, pagination);



      $this.attr("data-current-page", pagination);



      apimo_archive_load_data_ajax($this.attr("data-unique-id"));

    },



    afterNextOnClick: function (data, pagination) {

      console.log(data, pagination);



      $this.attr("data-current-page", pagination);



      apimo_archive_load_data_ajax($this.attr("data-unique-id"));

    },



    afterPreviousOnClick: function (data, pagination) {

      console.log(data, pagination);



      $this.attr("data-current-page", pagination);



      apimo_archive_load_data_ajax($this.attr("data-unique-id"));

    },

  });

}



jQuery(document).on("click", ".range-to input,.range-from input", function () {

  jQuery(".range-to input,.range-from input").removeClass("apimo-focus");



  jQuery(this).addClass("apimo-focus");



  manage_range_enable_disable();

});



jQuery(document).on("click", ".list-filter-click ul li span", function () {

  var value = jQuery(this).attr("data-value");



  var $this = jQuery(this);



  var range_from = $this.parents(".filter-item").find(".range-from input");



  var range_to = $this.parents(".filter-item").find(".range-to input");



  if (range_to.hasClass("apimo-focus")) {

    range_to.val(value);



    manage_range_enable_disable();



    return;

  }



  if (range_from.hasClass("apimo-focus")) {

    $this.parents(".filter-item").find(".range-from input").val(value);



    jQuery(this).parents(".filter-lists-value").addClass("min-done");



    range_to.focus().addClass("apimo-focus");



    manage_range_enable_disable();



    return;

  }



  range_to.val(value);



  manage_range_enable_disable();

});



function manage_range_enable_disable() {

  var range_from = jQuery(".range-from input:visible");



  var range_to = jQuery(".range-to input:visible");



  var min_value = jQuery(".range-from input:visible").val();



  var max_value = jQuery(".range-to input:visible").val();



  jQuery(".list-filter-click:visible li").each(function () {

    jQuery(this).removeClass("disable");

  });



  console.log("min_value", min_value);



  console.log("max_value", max_value);



  if (min_value != "" && max_value == "" && range_to.hasClass("apimo-focus")) {

    jQuery(".list-filter-click:visible li").each(function () {

      var this_value = jQuery(this).find("span").attr("data-value");



      if (parseFloat(this_value) < parseFloat(min_value))

        jQuery(this).addClass("disable");

    });

  } else if (

    min_value == "" &&

    max_value != "" &&

    range_from.hasClass("apimo-focus")

  ) {

    jQuery(".list-filter-click:visible li").each(function () {

      var this_value = jQuery(this).find("span").attr("data-value");



      if (parseFloat(this_value) > parseFloat(max_value))

        jQuery(this).addClass("disable");

    });

  } else if (min_value != "" && max_value != "") {

    range_from.focus();



    range_to.removeClass("apimo-focus");



    range_from.addClass("apimo-focus");



    jQuery(".filter-lists-value:visible").removeClass("min-done");



    jQuery(".list-filter-click:visible li").each(function () {

      var this_value = jQuery(this).find("span").attr("data-value");



      if (parseFloat(this_value) < parseFloat(max_value)) {

        jQuery(this).removeClass("disable");

      } else {

        jQuery(this).addClass("disable");

      }

    });

  }



  // else if (min_value != '' && max_value != '') {



  //     jQuery('.list-filter-click:visible li').each(function () {



  //         var this_value = jQuery(this).find('span').attr('data-value');



  //         if (parseFloat(this_value) > parseFloat(max_value) || parseFloat(this_value) < parseFloat(min_value))



  //             jQuery(this).addClass('disable')



  //     })



  // }

}



jQuery(document).on("click", ".apimo-qty-minus", function () {

  jQuery(this).parent().find("input")[0].stepDown();

});



jQuery(document).on("click", ".apimo-qty-plus", function () {

  jQuery(this).parent().find("input")[0].stepUp();

});



jQuery(document).on("click", ".apimo-archive-pagination ul li", function () {

  var page = "";



  if (jQuery(this).hasClass("prev")) {

    if (

      1 ==

      parseInt(

        jQuery(".apimo-archive-pagination ul li.active").attr("data_page")

      )

    ) {

      page = 1;

    } else {

      page =

        parseInt(

          jQuery(".apimo-archive-pagination ul li.active").attr("data_page")

        ) - 1;

    }

  } else if (jQuery(this).hasClass("next")) {

    if (

      parseInt(jQuery(".max_num_pages").val()) ==

      parseInt(

        jQuery(".apimo-archive-pagination ul li.active").attr("data_page")

      )

    ) {

      page = parseInt(

        jQuery(".apimo-archive-pagination ul li.active").attr("data_page")

      );

    } else {

      page =

        parseInt(

          jQuery(".apimo-archive-pagination ul li.active").attr("data_page")

        ) + 1;

    }

  } else {

    page = parseInt(jQuery(this).attr("data_page"));

  }



  jQuery(".apimo-archive-pagination ul li").each(function () {

    jQuery(this).removeClass("active");

  });



  jQuery('.apimo-archive-pagination ul li[data_page="' + page + '"]').addClass(

    "active"

  );



  var data = {

    action: "apimo_archive_pagination",



    page: page,



    no_of_post: jQuery(".no_of_post").val(),

  };



  jQuery.post(admin_urls.ajax, data, function (response) {

    jQuery(".Product-wrapper .apimo-row").html(response);

  });

});



jQuery(document).on("click", ".apimo-shortcode-pagination ul li", function () {

  var page = "";



  if (jQuery(this).hasClass("prev")) {

    if (

      1 ==

      parseInt(

        jQuery(".apimo-shortcode-pagination ul li.active").attr("data_page")

      )

    ) {

      page = 1;

    } else {

      page =

        parseInt(

          jQuery(".apimo-shortcode-pagination ul li.active").attr("data_page")

        ) - 1;

    }

  } else if (jQuery(this).hasClass("next")) {

    if (

      parseInt(jQuery(".max_num_pages").val()) ==

      parseInt(

        jQuery(".apimo-shortcode-pagination ul li.active").attr("data_page")

      )

    ) {

      page = parseInt(

        jQuery(".apimo-shortcode-pagination ul li.active").attr("data_page")

      );

    } else {

      page =

        parseInt(

          jQuery(".apimo-shortcode-pagination ul li.active").attr("data_page")

        ) + 1;

    }

  } else {

    page = parseInt(jQuery(this).attr("data_page"));

  }



  var shortcode_id = jQuery(this).parent().parent().attr("data_id");



  jQuery(".apimo-shortcode-pagination ul li").each(function () {

    jQuery(this).removeClass("active");

  });



  jQuery(

    '.apimo-shortcode-pagination ul li[data_page="' + page + '"]'

  ).addClass("active");



  var data = {

    action: "apimo_shortcode_pagination",



    page: page,



    no_of_post: jQuery(".no_of_post").val(),



    included_post: jQuery(".included_post").val(),

  };



  jQuery.post(admin_urls.ajax, data, function (response) {

    jQuery('.Product-wrapper .row[data_id="' + shortcode_id + '"]').html(

      response

    );

  });

});



jQuery(document).ready(function () {

  jQuery(".apimo-apply-filter:eq(0)").click();

});

