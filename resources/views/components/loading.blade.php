<div id="loading-overlay" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex flex-col items-center justify-center">
    <div class="relative">
        <div class="absolute inset-0 rounded-full bg-purple-600/20 animate-pulse-slow blur-xl"></div>
        <div class="w-24 h-24 rounded-full border-4 border-transparent border-t-purple-600 border-r-purple-500 animate-spin"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-6 h-6 bg-purple-600 rounded-full animate-pulse"></div>
        </div>
    </div>
    <div class="mt-6 text-center">
        <p class="text-xl font-semibold text-purple-400">Loading</p>
        <div class="flex justify-center mt-2 space-x-1">
            <div class="w-2 h-2 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0s"></div>
            <div class="w-2 h-2 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            <div class="w-2 h-2 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
        </div>
    </div>
</div>