<x-mail::message>
Dear User,

This is a friendly reminder for your upcoming event:

## **Event Name:** {{ $event->title }}

### **Start Date:** {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y, g:i a') }}
### **End Date:** {{ \Carbon\Carbon::parse($event->end_date)->format('F j, Y, g:i a') }}

@if($event->description)
    ## Event Details:
    {{ $event->description }}
@endif

We look forward to your participation in the event!

Best regards,
{{ config('app.name') }} Team

</x-mail::message>
