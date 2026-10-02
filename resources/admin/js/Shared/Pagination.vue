<template>
    <nav aria-label="Page navigation example" v-if="links && links['length'] > 3">
        <ul class="pagination">
            <template v-for="(link, key) in links">
                <li class="page-item"
                    :class="{ active: link.active, disabled: link.url === null, 'd-none d-lg-block': key !== 0 && (this.links.length - 1) !== key}">
                    <Link v-if="link.url === null" class="page-link" href="#" v-html="link.label"
                          preserve-scroll></Link>
                    <Link v-else class="page-link" :href="link.url" v-html="link.label" preserve-scroll></Link>
                </li>
            </template>
        </ul>
    </nav>
</template>

<script>

export default {
    props: {
        links: {
            type: Array,
            default: [],
        },
    },
}
</script>
