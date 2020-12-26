
$(document).ready(function(){

  
  filter_data();

  function filter_data()
  {
    $("#loading").hide();

      var action = 'fetch_data';
      var brands = get_filter('brand');
      var types = get_filter('type');

      // console.log(brands);
      // console.log(types);

      $.ajax({
          url:"./getAllCars.php",
          method:"POST",
          data:{action:action, brandz:brands, typez:types},
          beforeSend: function(){
            $("#loading").show();
          },
          success:function(data){
            $("#loading").hide();
              $('.filter_data').html(data);
          }
      });
  }

  function get_filter(class_name)
  {
      var filter = [];
      $('.'+class_name+':checked').each(function(){
          filter.push($(this).val());
      });
      return filter;
  }

  $('.inp-chk').click(function(){
      filter_data();
  });

 

});

/* $(document).ready(function () {
  const brands = [];
  const types = [];

  $(".inp-chk-brand-filter").change(function () {
    var checked = parseInt($(this).val());
    if ($(this).is(":checked")) {
      brands.push(checked);
      console.log(brands);
    } else {
      brands.splice($.inArray(checked, brands), 1);
      console.log(brands);
    }
  });

  $(".inp-chk-type-filter").change(function () {
    var checked = parseInt($(this).val());
    if ($(this).is(":checked")) {
      types.push(checked);
      console.log(types);
    } else {
      types.splice($.inArray(checked, types), 1);
      console.log(types);
    }
  });

  
   $.ajax("getAllCars.php", {
    dataType: "json",
    types: "POST",
    timeout: 500,
    data: { brandz:  brands, typez: types },
    success: function (data, status, xhr) {
      console.log("Hi this s working now");
    },
    error: function (jqXhr, textStatus, errorMessage) {
      console.log(errorMessage);
    }
  });
});
 */