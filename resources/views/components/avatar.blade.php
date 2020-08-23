@props([
  'user' => auth()->user(),
  'size' => 'sm',
  'class' => ''
])

@php
$sizes = [
  'xs' => 'h6 w-6',
  'sm' => 'h8 w-8',
  'md' => 'h16 w-16',
  'lg' => 'h24 w-24',
  'xl' => 'h32 w-32',  
];
@endphp
<div class="avatar {{ $sizes[$size] }} {{ $class }}">
  @if ($user->photo)
    <img src="{{ $user->photo['small'] }}" class="{{ $sizes[$size] }}" />
  @else
    <span>{{ $user->name_initials }}</span>
  @endif
</div>