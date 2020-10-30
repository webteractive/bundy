<div class="flex items-start mb-2 text-sm">
    @svg($icon, 'inline-block w-5 h-5 ' . ($iconClass ?? '') )
    <div class="flex-1 pl-1 leading-snug">{{ $slot }}</div>
</div>