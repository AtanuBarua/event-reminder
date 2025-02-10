@extends('master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>All Events</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
        Add New Event
    </button>
</div>

<table class="table table-bordered">
    <thead>
       <tr>
         <th>Reminder ID</th>
         <th>Title</th>
         <th>Start Date</th>
         <th>End Date</th>
         <th>Status</th>
         <th>Actions</th>
       </tr>
    </thead>
    <tbody>
    @foreach($events as $event)
       <tr>
           <td>{{ $event->event_reminder_id }}</td>
           <td>{{ $event->title }}</td>
           <td>{{ $event->start_date }}</td>
           <td>{{ $event->end_date }}</td>
           <td>{{ $event->end_date < now() ? 'Completed' : 'Upcoming' }}</td>
           <td>
             <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editEventModal"
                data-id="{{ $event->id }}"
                data-title="{{ $event->title }}"
                data-description="{{ $event->description }}"
                data-start_date="{{ date('Y-m-d\TH:i', strtotime($event->start_date)) }}"
                data-end_date="{{ date('Y-m-d\TH:i', strtotime($event->end_date)) }}"
                data-reminder_at="{{ $event->reminder_at ? date('Y-m-d\TH:i', strtotime($event->reminder_at)) : '' }}"
                data-reminder_emails="{{ $event->reminder_emails }}">
                Edit
             </button>
             <form action="{{route('event.delete', $event->id)}}" method="POST" class="d-inline"
                   onsubmit="return confirm('Are you sure you want to delete this event?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
             </form>
           </td>
       </tr>
    @endforeach
    </tbody>
</table>

<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{route('event.store')}}" method="POST">
         @csrf
         <div class="modal-header">
            <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
             <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" >
             </div>
             <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control"></textarea>
             </div>
             <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="datetime-local" name="start_date" id="start_date" class="form-control" >
             </div>
             <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="datetime-local" name="end_date" id="end_date" class="form-control" >
             </div>
             <div class="mb-3">
                <label for="reminder_at" class="form-label">Reminder At</label>
                <input type="datetime-local" name="reminder_at" id="reminder_at" class="form-control">
             </div>
             <div class="mb-3">
                <label for="reminder_emails" class="form-label">Reminder Emails (comma separated)</label>
                <input type="text" name="reminder_emails" id="reminder_emails" class="form-control">
             </div>
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
             <button type="submit" class="btn btn-primary">Add Event</button>
         </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{route('event.update', $event->id)}}">
         @csrf
         @method('PUT')
         <div class="modal-header">
            <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
             <div class="mb-3">
                <label for="edit_title" class="form-label">Title</label>
                <input type="text" name="title" id="edit_title" class="form-control">
             </div>
             <div class="mb-3">
                <label for="edit_description" class="form-label">Description</label>
                <textarea name="description" id="edit_description" class="form-control"></textarea>
             </div>
             <div class="mb-3">
                <label for="edit_start_date" class="form-label">Start Date</label>
                <input type="datetime-local" name="start_date" id="edit_start_date" class="form-control">
             </div>
             <div class="mb-3">
                <label for="edit_end_date" class="form-label">End Date</label>
                <input type="datetime-local" name="end_date" id="edit_end_date" class="form-control">
             </div>
             <div class="mb-3">
                <label for="edit_reminder_at" class="form-label">Reminder At</label>
                <input type="datetime-local" name="reminder_at" id="edit_reminder_at" class="form-control">
             </div>
             <div class="mb-3">
                <label for="edit_reminder_emails" class="form-label">Reminder Emails (comma separated)</label>
                <input type="text" name="reminder_emails" id="edit_reminder_emails" class="form-control">
             </div>
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
             <button type="submit" class="btn btn-primary">Update Event</button>
         </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    const editEventModal = document.getElementById('editEventModal');
    editEventModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const description = button.getAttribute('data-description');
        const start_date = button.getAttribute('data-start_date');
        const end_date = button.getAttribute('data-end_date');
        const reminder_at = button.getAttribute('data-reminder_at');
        const reminder_emails = button.getAttribute('data-reminder_emails');

        const form = editEventModal.querySelector('form');
        form.action = "{{ route('event.update', ':id') }}".replace(':id', id);

        form.querySelector('#edit_title').value = title;
        form.querySelector('#edit_description').value = description;
        form.querySelector('#edit_start_date').value = start_date;
        form.querySelector('#edit_end_date').value = end_date;
        form.querySelector('#edit_reminder_at').value = reminder_at;
        form.querySelector('#edit_reminder_emails').value = reminder_emails;
    });
</script>
@endpush
