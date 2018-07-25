
<div class="form-inline pull-right mr_2"  >
  <div class="form-group ">
    <label for="name">审核筛选:</label>
    <select class="form-control" name="is_check" id="is_check">
      @foreach($options as $option => $label)
        <option value ="{{$option}}">{{$label}}</option>
     @endforeach
    </select>
   
  </div>
</div>
<script>
$(document).ready(function(){
	 $("#is_check").change(function(){
		 $.ajax({
		        method: 'get',
		        url: '/admin/trade/check',
		        data: {
		            _token:LA.token,
		            action: $(this).val(),
		        },
		        success: function () {
		            $.pjax.reload('#pjax-container');
		            //toastr.success('操作成功');
		        }
		    });
		    
	 });
});


</script>