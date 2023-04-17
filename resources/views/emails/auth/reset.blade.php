<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>
<p> reset code is {{ $code }} </p>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
