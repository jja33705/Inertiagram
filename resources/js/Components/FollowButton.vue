<template>
    <button @click="followUser" v-text="btnText" class="px-2 mx-4 mb-4 font-semibold text-blue-700 bg-transparent border border-blue-700">
    </button>
</template>

<script>
export default {
    props: ['profile_user'],
    data() {
        return {
            form: this.$inertia.form({

            }),
            btnText: '',
            contain: false,
        }
    },
    methods: {
        followUser() {
            this.form.post(`/follow/${this.profile_user.id}`, {
                preserveScroll: true,
                only: ['profile_user', 'followers'],
                onSuccess: () => this.changeBtnText(),
            });
        },
        initBtnText() {
            for (let i = 0; i < this.profile_user.profile.followers.length; i++) {
                if (this.profile_user.profile.followers[i].id == this.$page.props.user.id) {
                    this.contain = true;
                    break;
                }
            }
            this.btnText = this.contain ? '팔로우 취소' : '팔로우 하기';
        },
        changeBtnText() {
            this.contain = !this.contain;
            this.btnText = this.contain ? '팔로우 취소' : '팔로우 하기';
        }
    },
    created() {
        this.initBtnText();
    }
}
</script>