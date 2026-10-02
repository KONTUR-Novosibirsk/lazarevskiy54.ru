<script>
export default {
    name: "VListGroupItem",
    props: {
        current: {
            type: Boolean,
            default: false,
        }
    }
}
</script>

<template>
    <div :class="{'!bg-neutral-200 dark:!bg-neutral-800':current}"
         class="block px-4 py-3 text-dark bg-neutral-50 border-b border-neutral-200 dark:border-neutral-800 cursor-pointer dark:bg-neutral-900
        hover:bg-neutral-200 hover:dark:bg-neutral-800 first:rounded-t-lg last:rounded-b-lg">
        <slot/>
    </div>
</template>
