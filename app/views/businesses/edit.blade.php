@extends('layouts.master')

@section('content')
	<div class="title">
		<h4>{{ trans('ui.' . $modelName . 'Detail') }}</h4>
	</div>
	@include('elements.messages')


	<ul class="nav nav-tabs">
		@if ($id_tab == 1) <li class="active"> @else <li> @endif
			<a href="#tab1" data-toggle="tab">{{ trans('ui.general') }}</a></li>
		@if ($id_tab == 2) <li class="active"> @else <li> @endif
	    	<a href="#tab2" data-toggle="tab">{{ trans('ui.locations') }}</a></li>
		@if ($id_tab == 3) <li class="active"> @else <li> @endif
	    	<a href="#tab3" data-toggle="tab">{{ trans('ui.contacts') }}</a></li>
		@if ($id_tab == 4) <li class="active"> @else <li> @endif
	    	<a href="#tab4" data-toggle="tab">{{ trans('ui.history') }}</a></li>
	</ul>
	<div class="tab-content">
		@if ($id_tab == 1)
			<div class="tab-pane fade in active" id="tab1">
		@else
			<div class="tab-pane fade" id="tab1">
		@endif
			{{ Form::model($model, array('method' => 'PATCH', 'route' => array($modelName . '.update', $model->id), 'class' => 'form-horizontal form-standard', 'id' => 'modelForm', 'name' => 'modelForm')) }}
			@include('elements.fieldSelect', array('info' => array('name' => 'id_database', 'sLabel' => '3', 'sField' => '9', 'data' => $databases)))
			@include('elements.fieldText', array('info' => array('name' => 'name', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
			@include('elements.fieldText', array('info' => array('name' => 'description', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
			@if ($typesBusinesses)
				@include('elements.fieldSelect', array('info' => array('name' => 'id_typesBusiness', 'sLabel' => '3', 'sField' => '9', 'data' => $typesBusinesses)))
			@endif
			@include('elements.fieldText', array('info' => array('name' => 'foundation', 'sLabel' => '3', 'sField' => '5', 'class' => 'datePicker')))
			@include('elements.fieldText', array('info' => array('name' => 'numberEmployees', 'sLabel' => '3', 'sField' => '5', 'class' => '')))
			@include('elements.fieldText', array('info' => array('name' => 'email', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
			@include('elements.fieldText', array('info' => array('name' => 'website', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
			@include('elements.fieldTextarea', array('info' => array('name' => 'note', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
			<div class="form-group">
				<div class="col-offset-2 col-7">
					@include('elements.updateButtonForm')
					@include('elements.deleteButtonForm')
					@include('elements.cancelButtonForm')
				</div>		
			</div>
			{{ Form::close() }}
		</div>
		@if ($id_tab == 2)
			<div class="tab-pane fade in active" id="tab2">
		@else
			<div class="tab-pane fade" id="tab2">
		@endif
			<table class="table table-condensed table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="width: 40%">{{ trans('ui.addressLine1') }}</th>
						<th style="width: 20%">{{ trans('ui.id_city') }}</th>
						<th style="width: 10%">{{ trans('ui.zipcode') }}</th>
						<th style="width: 10%">{{ trans('ui.phone') }}</th>
						<th colspan="2">{{ trans('ui.actions') }}</th>
					</tr>
				</thead>
				@if ($locations->count())
					<tbody>		
						@foreach($locations as $record)
						<tr {{ $record->isActive == 'No' ? 'class="warning"' : ''}}>
							<td>
								@include('elements.linkTable', array('info' => array('name' => $record->address->addressLine1, 'popover' => $record->address->reference, 'link' => '#')))
							</td>
							<td class="text-center">{{ $record->address->city->name }}</td>
							<td class="text-center">{{ $record->address->zipcode }}</td>
							<td class="text-center">{{ $record->phone }}</td>
							<td class="text-center">
								@include('elements.customButtonTabTable', array('info' => array('id' => $record->id, 'id_tab' => 2, 'name' => trans('ui.edit'), 'method' => 'editLocation', 'class' => 'btn btn-info btn-xs sameSizeButton')))
							</td>
							<td class="text-center">
								@include('elements.customButtonTabTable', array('info' => array('id' => $record->id, 'id_tab' => 2, 'name' => trans('ui.delete'),'method' => 'deleteLocation', 'class' => 'btn btn-danger btn-xs sameSizeButton')))
							</td>
						</tr>			
						@endforeach
					</tbody>
				@endif
			</table>
			@include('elements.footTable', array('info' => array('data' => $locations, 'pagination' => 'No')))
			<div class="form-group">
				<div class="col-offset-2 col-7">
					<button class="btn btn-primary" data-toggle="modal" data-target="#locationsModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.addLocation') }}</button>
				</div>		
			</div>
		</div>
		@if ($id_tab == 3)
			<div class="tab-pane fade in active" id="tab3">
		@else
			<div class="tab-pane fade" id="tab3">
		@endif
			<table class="table table-condensed table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th style="width: 15%">{{ trans('ui.firstName') }}</th>
						<th style="width: 15%">{{ trans('ui.lastName') }}</th>
						<th style="width: 15%">{{ trans('ui.phone') }}</th>
						<th style="width: 35%">{{ trans('ui.notes') }}</th>
						<th colspan="2">{{ trans('ui.actions') }}</th>
					</tr>
				</thead>
				@if ($contactsBusinesses->count())
					<tbody>		
						@foreach($contactsBusinesses as $record)
						<tr {{ $record->isActive == 'No' ? 'class="warning"' : ''}}>
							<td>
								@include('elements.linkTable', array('info' => array('name' => $record->contact->firstName, 'popover' => $record->scheduleNotes, 'link' => '#')))
							</td>
							<td class="text-center">{{ $record->contact->lastName }}</td>
							<td class="text-center">{{ $record->contact->phone }}</td>
							<td class="text-center">{{ $record->contact->notes }}</td>
							<td class="text-center">
								@include('elements.customButtonTabTable', array('info' => array('id' => $record->id, 'id_tab' => 2, 'name' => trans('ui.edit'), 'method' => 'editContactsBusiness', 'class' => 'btn btn-info btn-xs sameSizeButton')))
							</td>
							<td class="text-center">
								@include('elements.customButtonTabTable', array('info' => array('id' => $record->id, 'id_tab' => 2, 'name' => trans('ui.delete'),'method' => 'deleteContactsBusiness', 'class' => 'btn btn-danger btn-xs sameSizeButton')))
							</td>
						</tr>			
						@endforeach
					</tbody>
				@endif
			</table>
			@include('elements.footTable', array('info' => array('data' => $contactsBusinesses, 'pagination' => 'No')))
			<div class="form-group">
				<div class="col-offset-2 col-7">
					<button class="btn btn-primary" data-toggle="modal" data-target="#contactsBusinessesModal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false">{{ trans('ui.addContact') }}</button>
				</div>		
			</div>
		</div>
		@if ($id_tab == 4)
			<div class="tab-pane fade in active" id="tab4">
		@else
			<div class="tab-pane fade" id="tab4">
		@endif
			Activities where the Business was involved in the past
		</div>
	</div>
	<div class="modal fade" id="locationsModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" tabindex="1">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">{{ trans('ui.assignLocations') }}</h4>
	      		</div>
		      	<div class="modal-body">
						<div class="well">
						@include('elements.messagesModal')
						{{ Form::open(array('url' => array($modelName . '/assignLocation'),
										 'method' => 'GET',
										 'class' => 'form-horizontal form-standard',
										 'id' => 'listLocations', 'name' => 'listLocations')) }}
						@include('elements.fieldSelect', array('info' => array('name' => 'id_city', 'sLabel' => '3', 'sField' => '9', 'data' => $cities)))
						@include('elements.fieldSelect', array('info' => array('name' => 'id_database', 'sLabel' => '3', 'sField' => '9', 'data' => $databases)))
						@include('elements.fieldSelect', array('info' => array('name' => 'id_statusAddress', 'sLabel' => '3', 'sField' => '9', 'data' => $statusAddresses)))
						@include('elements.fieldSelect', array('info' => array('name' => 'id_typesAddress', 'sLabel' => '3', 'sField' => '9', 'data' => $typesAddresses)))
						@include('elements.fieldText', array('info' => array('name' => 'addressLine1', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'addressLine2', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'suite', 'sLabel' => '3', 'sField' => '5', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'zipcode', 'sLabel' => '3', 'sField' => '5', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'phone', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'phoneAdditional', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'fax', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
						@include('elements.fieldSelect', array('info' => array('name' => 'id_statusLocation', 'sLabel' => '3', 'sField' => '9', 'data' => $statusLocations)))
						@include('elements.fieldSelect', array('info' => array('name' => 'isHeadquarter', 'sLabel' => '3', 'sField' => '5', 'entity' => 'locations')))
						@include('elements.fieldSelect', array('info' => array('name' => 'isShipping', 'sLabel' => '3', 'sField' => '5', 'entity' => 'locations')))
						@include('elements.fieldSelect', array('info' => array('name' => 'isBilling', 'sLabel' => '3', 'sField' => '5', 'entity' => 'locations')))
						@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '5', 'entity' => 'locations')))
						@include('elements.fieldTextarea', array('info' => array('name' => 'reference', 'sLabel' => '3', 'sField' => '9', 'class' => '')))		
					</div>
				</div>
		      	<div class="modal-footer">
		      		@include('elements.updateButtonModal')
					@include('elements.cancelButtonTabModal', array('info' => array('id_tab' => '2')))
	      		</div>
	      		{{ Form::hidden('id_location') }}
	      		{{ Form::hidden('latitude') }}
	      		{{ Form::hidden('longitude') }}
	      		{{ Form::hidden('id') }}
	      		{{ Form::hidden('id_tab', 2) }}
	      		{{ Form::hidden('id_business', $id) }}
				{{ Form::hidden('activateLocationsModal', $activateLocationsModal, array('id' => 'activateLocationsModal')); }}
	 			{{ Form::close() }}
	    	</div>
		</div>
	</div>
	<div class="modal fade" id="locationsEditModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" tabindex="1">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">{{ trans('ui.assignLocations') }}</h4>
	      		</div>
		      	<div class="modal-body">
						<div class="well">
						@include('elements.messagesModal')
						{{ Form::open(array('url' => array($modelName . '/storeLocation'),
										 'method' => 'GET',
										 'class' => 'form-horizontal form-standard',
										 'id' => 'listLocations', 'name' => 'listLocations')) }}
					    @if ($location)
							@include('elements.fieldSelect', array('info' => array('name' => 'id_city', 'value' => $location->id_city, 'sLabel' => '3', 'sField' => '9', 'data' => $cities)))
							@include('elements.fieldSelect', array('info' => array('name' => 'id_database', 'value' => $location->id_database, 'sLabel' => '3', 'sField' => '9', 'data' => $databases)))
							@include('elements.fieldSelect', array('info' => array('name' => 'id_statusAddress', 'value' => $location->id_statusAddress, 'sLabel' => '3', 'sField' => '9', 'data' => $statusAddresses)))
							@include('elements.fieldSelect', array('info' => array('name' => 'id_typesAddress', 'value' => $location->id_typesAddress, 'sLabel' => '3', 'sField' => '9', 'data' => $typesAddresses)))
							@include('elements.fieldText', array('info' => array('name' => 'addressLine1', 'value' => $location->addressLine1, 'sLabel' => '3', 'sField' => '9', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'addressLine2', 'value' => $location->addressLine2, 'sLabel' => '3', 'sField' => '9', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'suite', 'value' => $location->suite, 'sLabel' => '3', 'sField' => '5', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'zipcode', 'value' => $location->zipcode, 'sLabel' => '3', 'sField' => '5', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'phone', 'value' => $location->phone, 'sLabel' => '3', 'sField' => '7', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'phoneAdditional', 'value' => $location->phoneAdditional, 'sLabel' => '3', 'sField' => '7', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'fax', 'value' => $location->fax, 'sLabel' => '3', 'sField' => '7', 'class' => '')))
							@include('elements.fieldSelect', array('info' => array('name' => 'id_statusLocation', 'value' => $location->id_statusLocation, 'sLabel' => '3', 'sField' => '9', 'data' => $statusLocations)))
							@include('elements.fieldSelect', array('info' => array('name' => 'isHeadquarter', 'value' => $location->isHeadquarter, 'sLabel' => '3', 'sField' => '5', 'entity' => 'locations')))
							@include('elements.fieldSelect', array('info' => array('name' => 'isShipping', 'value' => $location->isShipping, 'sLabel' => '3', 'sField' => '5', 'entity' => 'locations')))
							@include('elements.fieldSelect', array('info' => array('name' => 'isBilling', 'value' => $location->isBilling, 'sLabel' => '3', 'sField' => '5', 'entity' => 'locations')))
							@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'value' => $location->isActive, 'sLabel' => '3', 'sField' => '5', 'entity' => 'locations')))
							@include('elements.fieldTextarea', array('info' => array('name' => 'reference', 'value' => $location->reference, 'sLabel' => '3', 'sField' => '9', 'class' => '')))		
						@endif
					</div>
				</div>
		      	<div class="modal-footer">
		      		@include('elements.updateButtonModal')
					@include('elements.cancelButtonTabModal', array('info' => array('id_tab' => '2')))
	      		</div>
	      		{{ Form::hidden('id_location') }}
	      		{{ Form::hidden('latitude') }}
	      		{{ Form::hidden('longitude') }}
	      		{{ Form::hidden('id') }}
	      		{{ Form::hidden('id_tab', 2) }}
				{{ Form::hidden('activateEditLocationsModal', $activateEditLocationsModal, array('id' => 'activateEditLocationsModal')); }}
	 			{{ Form::close() }}
	    	</div>
		</div>
	</div>


	<div class="modal fade" id="contactsBusinessesModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" tabindex="1">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">{{ trans('ui.assignContacts') }}</h4>
	      		</div>
		      	<div class="modal-body">
						<div class="well">
						@include('elements.messagesModal')
						{{ Form::open(array('url' => array($modelName . '/assignContact'),
										 'method' => 'GET',
										 'class' => 'form-horizontal form-standard',
										 'id' => 'listContactsBusinesses', 'name' => 'listContactsBusinesses')) }}
						@include('elements.fieldSelect', array('info' => array('name' => 'id_database', 'sLabel' => '3', 'sField' => '9', 'data' => $databases)))
						@include('elements.fieldText', array('info' => array('name' => 'firstName', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'lastName', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'position', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'phone', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'phoneAdditional', 'sLabel' => '3', 'sField' => '7', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'email', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
						@include('elements.fieldText', array('info' => array('name' => 'emailAdditional', 'sLabel' => '3', 'sField' => '9', 'class' => '')))
						@include('elements.fieldSelect', array('info' => array('name' => 'dayMonday', 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
						@include('elements.fieldSelect', array('info' => array('name' => 'dayTuesday', 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
						@include('elements.fieldSelect', array('info' => array('name' => 'dayWednesday', 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
						@include('elements.fieldSelect', array('info' => array('name' => 'dayThursday', 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
						@include('elements.fieldSelect', array('info' => array('name' => 'dayFriday', 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
						@include('elements.fieldSelect', array('info' => array('name' => 'daySaturday', 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
						@include('elements.fieldText', array('info' => array('name' => 'start', 'sLabel' => '3', 'sField' => '7', 'class' => 'timePicker')))
						@include('elements.fieldText', array('info' => array('name' => 'end', 'sLabel' => '3', 'sField' => '7', 'class' => 'timePicker')))
						@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
						@include('elements.fieldTextarea', array('info' => array('name' => 'scheduleNotes', 'sLabel' => '3', 'sField' => '9', 'class' => '')))		
						@include('elements.fieldTextarea', array('info' => array('name' => 'notes', 'sLabel' => '3', 'sField' => '9', 'class' => '')))		
					</div>
				</div>
		      	<div class="modal-footer">
		      		@include('elements.updateButtonModal')
					@include('elements.cancelButtonTabModal', array('info' => array('id_tab' => '3')))
	      		</div>
	      		{{ Form::hidden('id_contact') }}
	      		{{ Form::hidden('id') }}
	      		{{ Form::hidden('id_tab', 3) }}
	      		{{ Form::hidden('id_business', $id) }}
				{{ Form::hidden('activateContactsBusinessesModal', $activateContactsBusinessesModal, array('id' => 'activateContactsBusinessesModal')); }}
	 			{{ Form::close() }}
	    	</div>
		</div>
	</div>
	<div class="modal fade" id="contactsBusinessesEditModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" tabindex="1">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<h4 class="modal-title" id="myModalLabel">{{ trans('ui.assignContacts') }}</h4>
	      		</div>
		      	<div class="modal-body">
						<div class="well">
						@include('elements.messagesModal')
						{{ Form::open(array('url' => array($modelName . '/storeContact'),
										 'method' => 'GET',
										 'class' => 'form-horizontal form-standard',
										 'id' => 'listContactsBusinesses', 'name' => 'listContactsBusinesses')) }}
					    @if ($contactsBusiness)
							@include('elements.fieldSelect', array('info' => array('name' => 'id_database', 'value' => $contactsBusiness->id_database, 'sLabel' => '3', 'sField' => '9', 'data' => $databases)))
							@include('elements.fieldText', array('info' => array('name' => 'firstName', 'value' => $contactsBusiness->firstName, 'sLabel' => '3', 'sField' => '7', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'lastName', 'value' => $contactsBusiness->lastName, 'sLabel' => '3', 'sField' => '7', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'position', 'value' => $contactsBusiness->position, 'sLabel' => '3', 'sField' => '7', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'phone', 'value' => $contactsBusiness->phone, 'sLabel' => '3', 'sField' => '7', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'phoneAdditional', 'value' => $contactsBusiness->phoneAdditional, 'sLabel' => '3', 'sField' => '7', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'email', 'value' => $contactsBusiness->email, 'sLabel' => '3', 'sField' => '9', 'class' => '')))
							@include('elements.fieldText', array('info' => array('name' => 'emailAdditional', 'value' => $contactsBusiness->emailAdditional, 'sLabel' => '3', 'sField' => '9', 'class' => '')))
							@include('elements.fieldSelect', array('info' => array('name' => 'dayMonday', 'value' => $contactsBusiness->dayMonday, 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
							@include('elements.fieldSelect', array('info' => array('name' => 'dayTuesday', 'value' => $contactsBusiness->dayTuesday, 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
							@include('elements.fieldSelect', array('info' => array('name' => 'dayWednesday', 'value' => $contactsBusiness->dayWednesday, 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
							@include('elements.fieldSelect', array('info' => array('name' => 'dayThursday', 'value' => $contactsBusiness->dayThursday, 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
							@include('elements.fieldSelect', array('info' => array('name' => 'dayFriday', 'value' => $contactsBusiness->dayFriday, 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
							@include('elements.fieldSelect', array('info' => array('name' => 'daySaturday', 'value' => $contactsBusiness->daySaturday, 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
							@include('elements.fieldText', array('info' => array('name' => 'start', 'value' => $contactsBusiness->start, 'sLabel' => '3', 'sField' => '7', 'class' => 'timePicker')))
							@include('elements.fieldText', array('info' => array('name' => 'end', 'value' => $contactsBusiness->end, 'sLabel' => '3', 'sField' => '7', 'class' => 'timePicker')))
							@include('elements.fieldSelect', array('info' => array('name' => 'isActive', 'value' => $contactsBusiness->isActive, 'sLabel' => '3', 'sField' => '5', 'entity' => 'contactsBusinesses')))
							@include('elements.fieldTextarea', array('info' => array('name' => 'scheduleNotes', 'value' => $contactsBusiness->scheduleNotes, 'sLabel' => '3', 'sField' => '9', 'class' => '')))		
							@include('elements.fieldTextarea', array('info' => array('name' => 'notes', 'value' => $contactsBusiness->notes, 'sLabel' => '3', 'sField' => '9', 'class' => '')))		
						@endif
					</div>
				</div>
		      	<div class="modal-footer">
		      		@include('elements.updateButtonModal')
					@include('elements.cancelButtonTabModal', array('info' => array('id_tab' => '3')))
	      		</div>
	      		{{ Form::hidden('id_contact') }}
	      		{{ Form::hidden('id') }}
	      		{{ Form::hidden('id_tab', 3) }}
				{{ Form::hidden('activateEditContactsBusinessesModal', $activateEditContactsBusinessesModal, array('id' => 'activateEditContactsBusinessesModal')); }}
	 			{{ Form::close() }}
	    	</div>
		</div>
	</div>
@stop

@section('scripts')
	{{ HTML::script('js/helpers.js')}}
	{{ HTML::script('js/bootstrap-datepicker.js')}}
	{{ HTML::script('js/jquery.datetimepicker.js')}}
	{{ HTML::script('js/jquery.timepicker.js')}}
	{{ HTML::script('js/jquery-ui-1.10.3.custom.js') }}
	<script type="text/javascript">
		if (top.location != location) {
	    	top.location.href = document.location.href;
	  	}

		$('.datePicker').datepicker({
			dateFormat: 'yy-mm-dd'
		});
	
		$('.timePicker').timepicker({
		    'minTime': '7:00am',
		    'maxTime': '7:00pm'});

	</script>
@stop
