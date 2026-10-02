<template>
    <div @click="changeTheme">
        <div class="m-auto">
            <Icon icon="line-md:moon-loop" v-if="theme === 'dark'"/>
            <Icon v-else icon="line-md:moon-to-sunny-outline-loop-transition"/>
        </div>
    </div>
</template>

<script>
export default {
    name: "ThemeSwitcher",
    data() {
        return {
            theme: 'light',
        }
    },
    mounted() {
        this.setTheme(this.getPreferredTheme())
    },
    methods: {
        changeTheme() {
            this.setTheme(this.getPreferredTheme() == 'dark' ? 'light' : 'dark')
        },
        getPreferredTheme() {
            const storedTheme = this.getStoredTheme()
            if (storedTheme) {
                return storedTheme
            }

            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
        },
        setTheme(theme) {
            this.theme = theme
            this.setStoredTheme(theme)
            if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('class', 'dark')
            } else {
                document.documentElement.setAttribute('class', theme)
            }
        },
        getStoredTheme() {
            return localStorage.getItem('theme')
        },
        setStoredTheme(theme) {
            localStorage.setItem('theme', theme)
        }
    }
}
</script>
