<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="cloudinaryUploadComponent({!! $getXData() !!})"
        class="fi-fo-cloudinary-upload rounded-xl bg-gray-50 p-4 text-sm ring-1 ring-gray-950/10 dark:bg-white/5 dark:ring-white/10"
    >
        <template x-if="preview">
            <div class="mb-3">
                <img
                    :src="preview"
                    alt="Aperçu"
                    class="h-40 w-full rounded-lg bg-white object-contain ring-1 ring-gray-950/5 dark:bg-gray-800"
                />
            </div>
        </template>

        <div class="flex flex-wrap items-center gap-3">
            <button
                type="button"
                @click="$refs.file.click()"
                :disabled="uploading"
                class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-primary-500 focus:outline-none focus:ring-2 disabled:opacity-50 disabled:hover:bg-primary-600"
            >
                <span x-text="uploading ? 'Upload...' : 'Choisir une image'"></span>
            </button>

            <template x-if="value">
                <button
                    type="button"
                    @click="remove()"
                    :disabled="uploading"
                    class="inline-flex items-center gap-2 rounded-lg border border-red-500 bg-transparent px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50 disabled:opacity-50 dark:text-red-400 dark:hover:bg-white/5"
                >
                    <span>Retirer</span>
                </button>
            </template>
        </div>

        <template x-if="uploading">
            <div class="mt-3">
                <div class="h-1.5 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                    <div class="h-full rounded-full bg-primary-600 transition-all" :style="`width: ${progress}%`"></div>
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    <span x-text="progress"></span> %
                </p>
            </div>
        </template>

        <template x-if="error">
            <p class="mt-2 text-xs font-medium text-red-600 dark:text-red-400" x-text="error"></p>
        </template>

        <input
            type="file"
            accept="image/*"
            x-ref="file"
            class="hidden"
            @change="pickFile($event)"
        />
    </div>
</x-dynamic-component>