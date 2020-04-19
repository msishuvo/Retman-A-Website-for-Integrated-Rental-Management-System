</div>

<footer class="text-center" id = "footer">&copy; Copyright 2018 RETMAN</footer>

<script>
  function updateEditions()
  {
    var editionString = '';
    for (var i = 1; i <= 12; i++)
    {
      if (jQuery('#edition'+i).val() != '')
      {
        editionString += jQuery('#edition'+i).val()+':'+jQuery('#qty'+i).val()+':'+jQuery('#threshold'+i).val()+',';
      }
    }
    jQuery('#editions').val(editionString);
  }

  function get_child_options(selected)
  {
    if (typeof selected === 'undefined')
    {
      var selected = '';
    }
    var parentID = jQuery('#parent').val();
    jQuery.ajax(
      {
        url: '/retman/admin/parsers/child_categories.php',
        type: 'POST',
        data: {parentID : parentID, selected: selected},
        success: function(data)
        {
          jQuery('#child').html(data);
        },
        error: function()
        {
          alert("Something went wong.")
        },
      }
    );
  }
  jQuery('select[name="parent"]').change(get_child_options);

</script>

</body>
</html>
