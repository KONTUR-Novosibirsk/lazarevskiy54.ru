<template>
    <Link :href="url" class="">
       <slot>
       </slot>
    </Link>
</template>

<script>
export default {
    name: "PreviewPage",
    props: {
        url: {
            type: String,
            required: true,
        }
    }
}
</script>

<style scoped>

</style>
