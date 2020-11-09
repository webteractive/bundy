<template>
    <div>
        <span class="text-gray-600">{{ label }}:</span>
        <slot>
            <span>{{ value }}</span>
        </slot>
    </div>
</template>

<script>
export default {
    props: ['label', 'value']
}
</script>