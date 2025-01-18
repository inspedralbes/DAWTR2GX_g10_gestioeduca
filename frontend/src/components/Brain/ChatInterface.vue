<script setup>
import { ref, onMounted } from 'vue';
import { useChatStore } from '../../stores/chatStore';
import { useChat } from '../../composables/useChat';
import ChatHeader from './ChatHeader.vue';
import MessageList from './MessageList.vue';
import MessageInput from './MessageInput.vue';
import ChatSidebar from './ChatSidebar.vue';

const chatStore = useChatStore();
const { sendMessage, isLoading, processFile } = useChat();

onMounted(() => {
  chatStore.loadFromLocalStorage();
});

const handleSend = async (message) => {
  if (!chatStore.currentChatId) {
    chatStore.createNewChat();
  }
  await sendMessage(message, chatStore.currentChatId);
};

const handleFileContent = async (content) => {
  if (!chatStore.currentChatId) {
    chatStore.createNewChat();
  }
  await processFile(content, chatStore.currentChatId);
};
</script>

<template>
  <div class="min-h-screen bg-gray-50 flex">
    <!-- Sidebar -->
    <div class="w-80 h-screen flex-shrink-0">
      <ChatSidebar />
    </div>

    <!-- Main Chat Area -->
    <div class="flex-1 h-screen flex flex-col bg-white">
      <ChatHeader />
      <MessageList 
        :messages="chatStore.currentChat?.messages || []"
        :is-loading="isLoading"
      />
      <div class="border-t border-gray-100 py-4">
        <MessageInput 
          :is-loading="isLoading"
          @send="handleSend"
          @file-processed="handleFileContent"
        />
      </div>
    </div>
  </div>
</template>