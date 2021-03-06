<template>
    <app-layout title="Dashboard">
        <template #header>
            <div class="flex flex-col items-start md:flex-row">
                <div class="flex flex-row items-start">
                    <div class="flex-shrink-0 mr-3 px-40" v-if="$page.props.jetstream.managesProfilePhotos">
                        <img :src="profile_user.profile_photo_url" :alt="profile_user.name" class="rounded-full h-40 w-40 object-cover">
                    </div>
                    <div class="flex-col justify-items-start">
                        <div class="flex flex-row items-end my-4">
                            <h2 class="mb-4 font-semibold text-xl text-gray-800 leading-tight">
                                {{ profile_user.name }}
                            </h2>
                            <follow-button :profile_user="profile_user" />
                            <div v-if="can.create_update == true">
                                <jet-secondary-button class="mb-4" @click="createNewPost=true">Add New Post</jet-secondary-button>
                                <jet-secondary-button class="mb-4" @click="editProfile=true">edit Profile</jet-secondary-button>
                            </div>
                        </div>
                        <div class="mb-4 flex flex-row">
                            <div class="mr-10">게시물 <span class="font-black">{{ posts.length }}</span></div>
                            <div class="mr-10">팔로워 {{ followers }}</div>
                            <div class="mr-10">팔로우 {{ profile_user.following.length }}</div>
                        </div>
                        <div class="mb-4">{{ profile_user.profile_username }}</div>
                        <div class="mb-2 font-semibold text-lg">{{ profile_user.profile? profile_user.profile.title : 'No Title' }}</div>
                        <div class='mb-4'>{{ profile_user.profile? profile_user.profile.description : 'No Description' }}</div>
                    </div>
                </div>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <post-list :posts="posts" />
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="createNewPost" @close="createNewPost = false">
            <template #title>
                Create New Post
            </template>

            <template #content>
                <form @submit.prevent="submit">
                    <div>
                        <jet-label for="caption" value="caption" />
                        <jet-input id="caption" type="text" class="block w-full mt-1" v-model="form.caption" required autofocus autocomplete="caption" />
                        <jet-input-error :message="form.errors.caption" class="mt-2" />
                    </div>
                    <div>
                        <jet-label for="image" value="image" />
                        <input type="file" class="hidden" ref="image" @change="updateImagePreview" />
                        <div class="mt-2" v-show="imagePreview">
                            <span class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full" :style="'background-image: url(\'' + imagePreview + '\')'"></span>
                        </div>
                        
                        <jet-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewImage">
                            Select A New Image
                        </jet-secondary-button>

                        <jet-input-error :message="form.errors.image" class="mt-2" />
                        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                            {{ form.progress.percentage }}%
                        </progress>
                    </div>
                </form>
            </template>

            <template #footer>
                <jet-secondary-button @click.prevent="submit">
                    Create
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="editProfile" @close="editProfile = false">
            <template #title>
                Update Profile
            </template>

            <template #content>
                <form @submit.prevent="updateProfile">
                    <div class="mb-2">
                        <jet-label for="title" value="title" />
                        <jet-input id="title" type="text" class="black w-full mt-1" v-model="updateProfileForm.title" required autofocus autocomplete="title" />
                        <jet-input-error :message="updateProfileForm.errors.title" class="mt-2" />
                    </div>

                    <div class="mb-2">
                        <jet-label for="description" value="description" />
                        <textarea id="description" cols="40" rows="10" class="form-textarea" v-model="updateProfileForm.description" required autofocus autocomplete="description"></textarea>
                        <jet-input-error :message="updateProfileForm.errors.description" class="mt-2" />
                    </div>
                </form>
            </template>
            <template #footer>
                <jet-secondary-button @click.prevent="updateProfile">
                    Update Profile
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>

    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import PostList from '@/Components/PostList.vue';
    import JetDialogModal from '@/Jetstream/ConfirmationModal.vue';
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
    import JetInput from '@/Jetstream/Input.vue';
    import JetInputError from '@/Jetstream/InputError.vue';
    import JetLabel from '@/Jetstream/Label.vue';
    import FollowButton from '@/Components/FollowButton'

    export default defineComponent({
        props: ['profile_user', 'posts', 'can', 'followers'],
        components: {
            AppLayout,
            PostList,
            JetDialogModal,
            JetSecondaryButton,
            JetInput,
            JetInputError,
            JetLabel,
            FollowButton
        },
        data() {
            return {
                createNewPost: false,
                form: this.$inertia.form({
                    _method: 'POST',
                    caption: '',
                    image: '',
                }),
                imagePreview: null,
                editProfile: false,
                updateProfileForm: this.$inertia.form({
                    _method: 'PATCH',
                    title: this.profile_user.profile.title,
                    description: this.profile_user.profile.description,
                }),
            }
        },

        methods: {
            submit() {
                if (this.$refs.image) {
                    this.form.image = this.$refs.image.files[0];
                }
                this.form.post(route('post.store'), {
                    errorBag: 'createNewPost',
                    preserveScroll: true,
                    onSuccess: () => { 
                        this.createNewPost = false; 
                        this.clearFields(); 
                    },
                });
            },

            clearFields() {
                this.form.caption = '';
                this.form.image = '';
            },

            updateImagePreview() {
                const photo = this.$refs.image.files[0];
                if (!photo) return;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(photo);
            },

            selectNewImage() {
                this.$refs.image.click();
            },

            initUpdateProfilesFields() {
                this.updateProfileForm.title = this.profile_user.profile.title;
                this.updateProfileForm.description = this.profile_user.profile.description;
            },

            updateProfile() {
                this.updateProfileForm.post(route('profile.update'), {
                    errorBag: 'updateProfile',
                    preserveScroll: true,
                    onSuccess: () => { 
                        this.editProfile = false;
                        this.initUpdateProfilesFields(); 
                    },
                });
            },
        },
    });
</script>
