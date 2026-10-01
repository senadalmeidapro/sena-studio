<div x-data="{ copied: false }" class="space-y-3">
    <textarea x-ref="draft" readonly rows="8" class="w-full rounded-lg border border-gray-300 bg-white p-3 text-sm text-gray-950 dark:border-white/10 dark:bg-gray-950 dark:text-white">{{ $draft }}</textarea>
    <button
        type="button"
        class="fi-btn fi-btn-size-md inline-flex items-center justify-center gap-1.5 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white"
        @click="navigator.clipboard.writeText($refs.draft.value).then(() => { copied = true; setTimeout(() => copied = false, 1800) })"
    >
        <span x-text="copied ? @js(__('leads.reply_draft.copied')) : @js(__('leads.reply_draft.copy'))"></span>
    </button>
</div>
