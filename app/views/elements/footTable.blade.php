@if (isset($info['pagination']) && $info['pagination'] == "No")
	@if (gettype($info['data']) == "array" && count($info['data']))
	<div class="footTable well">
		<div class="footText col-xs-12"><p class="footTable">{{ count($info['data']) . ' ' . trans('ui.records') }}</p></div>
	</div>
	@elseif (gettype($info['data']) == "object" && $info['data']->count())
	<div class="footTable well">
		<div class="footText col-xs-12"><p class="footTable">{{ $info['data']->count() . ' ' . trans('ui.records') }}</p></div>
	</div>
	@else
	<div class="footTable well">
		<div class="footText col-xs-12"><p class="footTable">{{ trans('ui.thereAreNoRows') }}</p></div>
	</div>
	@endif
@else
	@if (isset($info['data']) && gettype($info['data']) == "array" && count($info['data']))
	<div class="footTable well">
		<div class="footText col-xs-12"><p class="footTable">{{ count($info['data']) . ' ' . trans('ui.records') }}</p></div>
	</div>
	@elseif (isset($info['data']) && gettype($info['data']) == "object" && $info['data']->count()) 
	<div class="footTable well">
		<div class="footText col-xs-3"><p class="footTable">{{ $info['data']->getTotal() . ' ' . trans('ui.records') }}</p></div>
		<div class="pagLocation text-right col-xs-9">{{ $info['data']->appends(array('searchField' => $input))->links() }}</div>
	</div>
	@else
	<div class="footTable well">
		<div class="footText col-xs-12"><p class="footTable">{{ trans('ui.thereAreNoRows') }}</p></div>
	</div>
	@endif
@endif