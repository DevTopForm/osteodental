<div class="article">
<div class="txt">
	{$content}
	<script>
		$(document).ready(function(){ldelim}
			$('.form-container input.username').val('{$user->lastname} {$user->firstname} {$user->middlename}')
		{rdelim});
	</script>
	<div class="clear"></div>
</div>
</div>
