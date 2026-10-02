<template>
    <el-form label-position="top">
        <form-item label="Заголовок" :errors="errors['seo.title']">
            <el-input v-model="seo.title" @input="updateSeo"/>
        </form-item>
        <form-item label="H1" :errors="errors['seo.h1']">
            <el-input v-model="seo.h1" @input="updateSeo"/>
        </form-item>
        <form-item label="Keywords" :errors="errors['seo.keywords']">
            <el-input type="textarea" v-model="seo.keywords" @input="updateSeo"/>
        </form-item>
        <form-item label="Description" :errors="errors['seo.description']">
            <el-input type="textarea" v-model="seo.description" @input="updateSeo"/>
        </form-item>
        <form-item label="Включить в карту сайта" :errors="errors['seo.site_map']">
            <el-switch v-model="seo.site_map" @input="updateSeo"/>
        </form-item>

        <el-row :gutter="10" v-show="seo.site_map">
            <el-col :xs="24" :lg="12">
                <form-item :errors="errors['seo.changefreq']">
                    <el-select v-model="seo.changefreq" placeholder="Период обновления" @input="updateSeo">
                        <el-option
                            v-for="item in changefreq"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        />
                    </el-select>
                </form-item>
            </el-col>
            <el-col :xs="24" :lg="12">
                <form-item :errors="errors['seo.priority']">
                    <el-select v-model="seo.priority" placeholder="Приоритет" @input="updateSeo">
                        <el-option
                            v-for="item in priority"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        />
                    </el-select>
                </form-item>
            </el-col>
        </el-row>
    </el-form>
</template>

<script>
import FormItem from "../UI/Form/FormItem.vue";

export default {
    name: "SeoComponent",
    components: {FormItem},
    props: {
        modelValue: {
            'title': '',
            'h1': '',
            'keywords': '',
            'description': '',
            'site_map': false,
            'changefreq': '',
            'priority': '',
        },
        errors: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            default: {
                'title': '',
                'h1': '',
                'keywords': '',
                'description': '',
                'site_map': false,
                'changefreq': '',
                'priority': '',
            },
            changefreq: [
                {value: 'always', label: 'always'},
                {value: 'hourly', label: 'hourly'},
                {value: 'daily', label: 'daily'},
                {value: 'weekly', label: 'weekly'},
                {value: 'monthly', label: 'monthly'},
                {value: 'yearly', label: 'yearly'},
                {value: 'never', label: 'never'},
            ],
            priority: [
                {value: '0.1', label: '0.1'},
                {value: '0.2', label: '0.2'},
                {value: '0.3', label: '0.3'},
                {value: '0.4', label: '0.4'},
                {value: '0.5', label: '0.5'},
                {value: '0.6', label: '0.6'},
                {value: '0.7', label: '0.7'},
                {value: '0.8', label: '0.8'},
                {value: '0.9', label: '0.9'},
                {value: '1.0', label: '1.0'},
            ]
        }
    },
    computed: {
        seo() {
            return this.modelValue ?? this.default
        }
    },
    methods: {
        updateSeo(event) {
            this.$emit('update:modelValue', this.seo);
        }
    }
}
</script>
