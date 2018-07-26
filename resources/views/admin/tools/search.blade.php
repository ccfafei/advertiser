
<div class="pull-right mr_2"  >
<form class="form-inline" action="/admin/trade/check" method="post">
  <div class="form-group ">
    <label for="name">筛选:</label>
    <select class="form-control" name="is_check" id="is_check">
     @foreach($options as $option => $label)
        <option value ="{{$option}}">{{$label}}</option>
     @endforeach
    </select>
   
  </div>
  </form>
</div>
<script>
$(document).ready(function(){
	 $("#is_check").change(function(){
		  check =$(this).val();
		  $("#is_check option[value='"+check+"']").attr("selected", "selected");
		  $('.form-inline').submit();
      });
		
});


</script>