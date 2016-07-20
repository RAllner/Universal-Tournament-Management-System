<?php
/**
 * Created by PhpStorm.
 * User: Raphael
 * Date: 14.07.2016
 * Time: 17:57
 */
?>
<script>
    alert( "Handler for .change() called." );

$('#tournament-stage_type > label > input[type="radio"]').click(function() {
    alert( "Handler for .change() called." );
});
 if (stage == '0')
 {
     $('.group-stage').hide();
 } else {
     $('.group-stage').show();
 }
</script>
