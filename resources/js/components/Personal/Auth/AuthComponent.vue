<template>
    <div class="w-[500px]">
        <LoginFormComponent v-if="type === 'login'" @changeType="changeType" :privacyPolicyLink="privacyPolicyLink"/>
        <RegisterFormComponent v-else-if="type === 'register'" @changeType="changeType" :privacyPolicyLink="privacyPolicyLink"/>
        <PasswordResetFormComponent v-else-if="type === 'password_reset'" @changeType="changeType" :privacyPolicyLink="privacyPolicyLink"/>
    </div>
</template>
<script>
import LoginFormComponent from "@/components/Personal/Auth/LoginFormComponent.vue";
import RegisterFormComponent from "@/components/Personal/Auth/RegisterFormComponent.vue";
import PasswordResetFormComponent from "@/components/Personal/Auth/PasswordResetFormComponent.vue";

export default {
    name: "AuthComponent",
    components: {LoginFormComponent, RegisterFormComponent, PasswordResetFormComponent},
    props: {
        privacyPolicyLink: null,
    },
    data() {
        return {
            type: 'login',
        }
    },
    methods: {
        changeType(type) {
            this.type = type;
        }
    }
}
</script>
