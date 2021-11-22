<template>
    <div>
        <div class="mt-5 overflow-hidden rounded shadow-lg">
            <a @click="imgClicked()"><img class="w-full" :src="`/storage/${post.image}`" :alt="post.image"></a>
        </div>

        <jet-dialog-modal :show="showPost" @close="showPost = false">
            <template #header></template>
            <template #content>
                <div class="w-full mx-3 overflow-hidden bg-white border rounded md:w-12/12 md:mx-0 lg:mx-0">
                    <div class="w-full flex justify-between p-3">
                        <span class="px-2 hover:bg-gray-300 cursor-pointer rounded">
                            <i class="fas fa-ellipsis-h pt-2 text-lg"></i>
                        </span>
                    </div>
                    <img class="w-full bg-cover" :src="`/storage/${post.image}`" alt="photo" />
                    <div class="px-3 pb-2">
                        <div class="mt-2">
                            <span>{{ post.caption }}</span>
                        </div>
                        <div class="pt-2">
                            <i class="cursor-pointer far fa-heart"></i>
                            <span class="text-sm font-medium text-gray-400">12 likes</span>
                        </div>
                        <div class="text-sm mb-2 text-gray-400 cursor-pointer font-medium">View all 14 comments</div>
                        <div class="pt-1">
                            <div class="mb-2 text-sm">
                                <span class="mr-2 font-medium">braydoncoyer</span> Dude! How cool! I went to New Zealand last summer and had a blast taking the tour! So much to see! Make sure you bring a good camera when you go!
                            </div>
                        </div>
                        <div class="mb-2 text-sm font-medium text-gray-400 cursor-pointer">View all 14 comments</div>
                        <div class="mb-2">
                            <span class="mb-2 text-sm">braydoncoyer</span> Dude! How cool! I went to New Zealand last summer and had a blast taking the tour! So much to see! Make sure you bring a good camera when you go!
                        </div>
                    </div>
                </div>
            </template>
            <template #footer>
                <div class="flex flex-row px-6 py-4">
                    <button class="pr-4">
                        <svg fill="none" viewBox="0 0 24 24"  class="w-4 h-4 mr-1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                    <button class="pr-4">
                        <svg fill="none" viewBox="0 0 24 24" class="w-4 h-4 mr-1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                        </svg>
                    </button>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                </div>
            </template>
        </jet-dialog-modal>
    </div>
</template>



<script>
import JetDialogModal from '@/Jetstream/ConfirmationModal.vue';
export default {
    props: ['post'],
    data() {
        return {
            showPost: false,
        };
    },
    components: {
        JetDialogModal,
    },
    methods: {
        imgClicked() {
            this.showPost = true;
        },
    }
}
</script>