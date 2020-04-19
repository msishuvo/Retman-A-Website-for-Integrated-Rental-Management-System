</div>

<footer class="text-center" id = "footer">&copy; Copyright 2018 RETMAN</footer>



<script>
  jQuery(window).scroll(function()
  {
    var vscroll = jQuery(this).scrollTop();
    jQuery('#logotext').css({"transform" : "translate(0px, "+vscroll/2+"px)"});

    var vscroll = jQuery(this).scrollTop();
    jQuery('#discription').css({"transform" : "translate(0px, "+vscroll/8+"px)"});
  });

  function detailsmodal(id)
  {
    var data = {"id":id};
    jQuery.ajax(
    {
      url : '/retman/includes/detailsmodal.php',
      method : "post",
      data : data,
      success : function(data)
      {
        jQuery('body').append(data);
        jQuery('#details-modal').modal('toggle');

      },
      error : function()
      {
        alert("Something went wrong");

      }
    });
  }

  function update_cart(mode, edit_id, edit_edition)
  {
    var data = {"mode" : mode, "edit_id" : edit_id, "edit_edition" : edit_edition};
    jQuery.ajax(
      {
        url : '/retman/admin/parsers/update_cart.php',
        method : "post",
        data : data,
        success : function(){location.reload();},
        error : function(){alert("Something went wrong.");},
      });
  }

  function add_to_cart()
  {
    jQuery('#modal_errors').html("");
    var edition = jQuery('#edition').val();
    var quantity = jQuery('#quantity').val();
    var available = jQuery('#available').val();
    var error = '';
    var data = jQuery('#add_product_form').serialize();
    if (edition == '' || quantity == '' || quantity == 0)
    {
      error += '<p class="text-danger text-center">You must choose an edition and quantity.</p>';
      jQuery('#modal_errors').html(error);
      return;
    }
    else if (quantity > available)
    {
      error += '<p class="text-danger text-center">There are only '+available+' available.</p>';
      jQuery('#modal_errors').html(error);
      return;
    }
    else
    {
      jQuery.ajax({
        url : '/retman/admin/parsers/add_cart.php',
        method : "post",
        data : data,
        success : function(){
          location.reload();
        },
        error : function()
        {
          alert("Something went wrong");
        }
      });
    }
  }
</script>
</body>
</html>
