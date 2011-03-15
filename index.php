<!DOCTYPE HTML>
<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen"  />
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"  />
		<title></title>
	</head>
	<body>

    <?php
      require_once('lib/db.php');
      $lists_request = $db->query("select * from lists");
    ?>

    <div class="wrap-all">
      <h1 class="logo">The Todo'inator</h1>
      <div class="left-wrap">
        <div class="list-wrap">
          <form class="todo-form" action="submit" method="post" accept-charset="utf-8">
            <h1 class="big-title">I don't want ToDo List</h1>
            <?php 

              while($post = $lists_request->fetch_assoc()) {
              ?>
              <ul data-list_id = <?php echo $post['list_id']; ?>>
                <h2 class="list-title"><?php echo $post["list_title"]; ?></h2>

                <?php
                  $list_items_request = $db->query("select li.list_item, li.item_id from list_items li join lists l on l.list_id = li.list_id where li.list_id = '".$post['list_id']."';");
                  while($post_item = $list_items_request->fetch_assoc()) {
                  ?>


                  <li data-item_id = "<?php echo $post_item["item_id"]; ?>"><input class="delete-button button-wrap" type="button" value="X"><span class="text-wrap"><?php echo $post_item["list_item"];?></span></li>
                  <?php
                  }  /* closing the inner loop */
                ?>

                <span class="error-span"></span>
                <input class="add-item" type="text" name="new_list_item" value="">
                <input class="add-item-button" type="button" value="add item">
              </ul>
              <?php
              } /* closing the outer loop */
            ?>

          </form>
        </div>
        <div class="create-list-wrap">
          <input class="hide-me add-list-input" type="text" name="" value="">
          <input class="add-list-button" type="button" value="Create New List">
          <span class="error-span list-title-error"></span>
        </div>
      </div>

    <div class="right-wrap">
      <p>So, you have lots things to do. Well... lets rephrase that. You have lots of things you don't want to do but need to get done.</p>
      <p>Enter:  <span class="the-todo">The Todo'inator</span></p>
      <p>Scientifically Enginered and Genetically Modified (possibly cloned) to make sure you... buy it.</p>
    </div>

    </div>



    <script src="jquery.js" type="text/javascript" charset="utf-8">
      
    </script>

<script type="text/javascript" charset="utf-8">
  var input_value;
  var timeout;
  var add_delete_button ='<input class="delete-button button-wrap" type="button" value="X">'; 
  var li_pre_content = '<span class="text-wrap">';
  var li_post_content = '</span></li>';


/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
/************************************** !!! Strike and DoubleClick Edit Item!!! *******************************************************************************/
/*****************************************************************************************************************************************/

  $("ul h2.list-title").live('dblclick', /* Listens for a click on an li */ 
      function() {
        edit_item($(this));
      });

  $("li span.text-wrap").live('click', /* Listens for a click on an li */ 
      function() {
        on_click($(this));
      });

  numclicks = 0;

  function on_click(target) {
    if(numclicks == 0) {
      setTimeout(count_clicks, 250, target);
    }
    numclicks ++;
  }
  function count_clicks(target) {
    if(numclicks == 1) { target.toggleClass("strike-out") };
    if(numclicks == 2) { 
      edit_item(target) };
    if(numclicks >= 3) {};

    numclicks = 0;

  }
  function edit_item(target) {
      html_content = target.html();
    if(target.hasClass('list-title')) {
        console.log(target.html());
        var add_edit_button ='<input class="add-edit button-wrap" type="button" value="+">';
        var edit_input_box = '<input class="input-edit" type="text" name="some_name" value="'+html_content+'">';


        target.replaceWith(add_edit_button + edit_input_box);

        $(".add-edit").live('click', function() {
            close_title();
            });
        $(".input-edit").live({

          focusout: function() {
            close_title();
          },
          keydown: function(event) {
          if(event.which == 13) {
          event.preventDefault();
          close_title()};
            }
        });

      } else {
          var add_edit_button ='<li><input class="add-edit button-wrap" type="button" value="+">';
          var edit_input_box = '<input class="input-edit" type="text" name="some_name" value="'+html_content+'"></li>';

          target.parent().replaceWith(add_edit_button + edit_input_box);

          $(".add-edit").live('click', function() {
              close_item();
              });
          $(".input-edit").live({

            focusout: function() {
              close_item();
            },
            keydown: function(event) {
            if(event.which == 13) {
            event.preventDefault();
            close_item()};
              }
          });
      };
  }
    function close_title() {
       var html_new_content = $(".input-edit").val();
       if(html_new_content < 1){$(".input-edit").parent().remove()};
       $(".input-edit").replaceWith('<span class="list-item">' + html_new_content + '</span>');
       $(".add-edit").remove();


  }
    function close_item() {
       var html_new_content = $(".input-edit").val();
       if(html_new_content < 1){$(".input-edit").parent().remove()};
       $(".input-edit").replaceWith('<span class="text-wrap">' + html_new_content + '</span>');
       $(".add-edit").replaceWith(add_delete_button);

       $.post("lib/update.php", { original: html_content, current: html_new_content });

  }


/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
/************************************** !!! Delete Item!!! *******************************************************************************/
/*****************************************************************************************************************************************/

        /* Create delete button for title on hover */
        $('.list-title').live('mouseenter', function(){
          $(this).append('<input class="delete-button button-wrap" type="button" value="X">');

        }).live('mouseleave focusOut click', function() {
          $(this).children('input').remove();

        });

  $(".delete-button").live('click', delete_button); /* calls the delete function on click */

  function delete_button() { 
      if($(this).parent().hasClass('list-title')) { /* check if it is a title or a list item */ 
        var parent_ul = $(this).parent().parent('ul');
        var parent_ul_id = parent_ul.attr('data-list_id');

        $.post('lib/delete_title.php', { list_id: parent_ul_id });
        parent_ul.remove(); /* delete the parent ul to delete a list */ 

      } else {

        var delete_this = $(this).parent('li').attr('data-item_id');

    $.post("lib/delete.php", { item_id: delete_this }); /* delete the parent li to delete a list item  */
    $(this).parents("li").remove();
    }


  }

/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
/************************************** !!! ADD ITEM !!! *******************************************************************************/
/*****************************************************************************************************************************************/

$(".add-item-button").live('click', function() {
    add_item_button($(this));
    }); /* calls add item function on click */

$(".add-item").live('keydown', function(event){
    if(event.which == 13) {
      event.preventDefault();
      $(this).next(".add-item-button").trigger('click', function(){
        add_item_button($(this));
        }
        );
      }
      });

function add_item_button(this_scoped) { /* validates field value and adds li when true */

  var prev_ul = this_scoped.parent('ul');
  var input_value = prev_ul.children(".add-item").attr("value");
  var id_container = prev_ul.attr("data-list_id");

  if(input_value) {

      $.post("lib/input.php", { list_item: input_value, list_id: id_container }, function(list_id) { 
    prev_ul.children('span.error-span').before('<li data-list_id = "'+list_id+'">'+ add_delete_button + li_pre_content + input_value + li_post_content);

    $(".add-item").val("");
    $(".add-item").prev().html("");
});} else {
      prev_ul.children('.add-item').focus();
      prev_ul.children('span.error-span').html("Please Enter a Value");
}
  }

/*>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>*/
/************************************** !!! ADD NEW LIST !!! *******************************************************************************/
/*****************************************************************************************************************************************/

$('.add-list-button').live('click', function() {
    var input_box = $(this).prev();

    if($(this).prev().hasClass('hide-me')) {
        /* the input box is not showing */

        input_box.toggleClass('hide-me');
        $(this).val('Add List')
        input_box.focus();

      } else {
        /* the input box is showing */

        if(!input_box.val()) {
            /* the input box is not showing */

            var something = $(this);
            $('.list-title-error').html('Please enter a title');
            input_box.focus();
          } else {
            /* the input box is showing and has a value  */
            var new_list_title = input_box.val();

            create_new_list(new_list_title);
              input_box.toggleClass('hide-me'); /* hide the input */ 
              input_box.val('');                /* clear the input value */ 
              $(this).val('Create New List');   /* chante the value of the button back to original state */
              $('.list-title-error').html('');  /* clear potential validation error showing */
              $(this).blur();                   /* remove focus from the input button */ 

    }
  }
}); /* end .live */

function create_new_list(new_list_title) {

    var new_list_title = new_list_title;

    $.post("lib/input_title.php", { list_title: new_list_title }, function(the_id) {

    if($('form.todo-form ul').length > 0  ) {
        
        $('form.todo-form ul:last').after('<ul data-list_id = "'+the_id+'"><h2 class="list-title">'+new_list_title+'</h2> <span class="error-span"></span> <input class="add-item" type="text" name="new_list_item" value=""> <input class="add-item-button" type="button" value="add item"> </ul>');
  } else {
    $('form.todo-form').append('<ul data-list_id = "'+the_id+'"><h2 class="list-title">'+new_list_title+'</h2> <span class="error-span"></span> <input class="add-item" type="text" name="new_list_item" value=""> <input class="add-item-button" type="button" value="add item"> </ul>');

}

    });
}


</script>


	</body>
</html>
