<template>
    <div>
        <div v-if="loading" class="loader-frame">
            <div class="loader"></div>
        </div>

        <div v-else>
            <div v-if="account.personalData">
                <h1>{{ account.personalData.full_name }}</h1>
                <p>{{ account.personalData.email }}</p>
            </div>

            <div class="flex items-center gap-[15px] profile-items mb-[15px]">
                <p v-for="tab in tabs"
                   :key="tab.name"
                   :class="['cursor-pointer mb-0', { 'active': activeTab === tab.name }] "
                   @click="activeTab = tab.name">
                    {{ tab.label }}
                </p>
                <a href="/account/me/logout" class="cursor-pointer">
                    Выйти
                </a>
            </div>

            <div class="profile-items-content">
                <div v-show="activeTab === 'profile'" data-tab="profile" class="profile-order_count">
                    <AccountProfileComponent :orderCount="account.personalData.order_count" />
                </div>
                <div v-show="activeTab === 'personal_data'" data-tab="personal_data">
                    <AccountPersonalDataComponent :personalData="account.personalData" />
                </div>
                <div v-show="activeTab === 'history'" data-tab="history">
                    <AccountHistoryComponent :history="account.history" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AccountProfileComponent from "@/components/Personal/Account/AccountProfileComponent.vue";
import AccountPersonalDataComponent from "@/components/Personal/Account/AccountPersonalDataComponent.vue";
import AccountHistoryComponent from "@/components/Personal/Account/AccountHistoryComponent.vue";

export default {
    name: "Account",
    components: { AccountHistoryComponent, AccountPersonalDataComponent, AccountProfileComponent },
    data() {
        return {
            loading: true,
            activeTab: 'profile',
            account: {
                personalData: null,
                history: null
            },
            tabs: [
                { name: 'profile', label: 'Профиль' },
                { name: 'personal_data', label: 'Личные данные' },
                { name: 'history', label: 'Заказы' },
            ],
        };
    },
    mounted() {
        this.loadInitialData();
    },
    methods: {
        async loadInitialData() {
            try {
                await Promise.all([
                    this.loadAccountData(),
                    this.loadHistory()
                ]);
            } finally {
                this.loading = false;
            }
        },

        async loadAccountData() {
            const response = await axios.get('/account/me/show');
            this.account.personalData = response.data;
        },

        async loadHistory() {
            const response = await axios.get('/account/me/history');
            this.account.history = response.data;
        }
    }
};
</script>

<style scoped>

</style>
