<template>
    <div class="sticky bottom-0 z-20 pb-6 bg-white">
        <div class="w-full bg-gray-200 rounded-lg p-6 space-y-2">
            <form>
                <textarea id="post-area" maxlength="1000"
                    class="w-full p-1 bg-transparent resize-none border-none focus:outline-none" rows="1"
                    placeholder="Type a message..."></textarea>
                <div class="flex flex-col items-start justify-between lg:flex-row lg:items-center">
                    <div class="flex items-center space-x-8">
                        <div>
                            <input type="file" id="post-media" class="hidden" accept="image/*">
                            <i class="fas fa-image text-gray-500 cursor-pointer transition-all duration-200 lg:hover:text-black"
                                id="post-media-icon"></i>
                        </div>
                        <div class="relative inline-block z-10">
                            <i id="emoji-icon"
                                class="fas fa-smile text-gray-500 transition-all duration-200 cursor:pointer lg:hover:text-black"></i>
                            <emoji-picker id="emoji-picker"
                                class="absolute left-[-250px] scale-75 transform top-full mt-1 hidden shadow-2xl md:left-0 md:scale-100"></emoji-picker>
                        </div>
                    </div>
                    <button
                        class="self-end mt-2 rounded-full text-white bg-black py-2 px-4 transition-all duration-200 lg:mt-0 lg:hover:bg-gray-500"
                        type="submit">Send message</button>
                </div>
            </form>
        </div>
    </div>
</template>