<x-mail::message>
Hello Admin,,

The Order No.{{$order->id}} to  {{$customer->name}} has been placed successfully and is now being processed

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>