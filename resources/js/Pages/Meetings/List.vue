<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Meetings
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="mt-8 text-2xl">Meetings</div>

            <div v-for="meeting in meetings" :key="meeting.id">
              <div class="mt-6 text-gray-500">
                <inertia-link :href="'/meetings/' + meeting.id + '/public'" 
                  class="ml-4 text-sm text-gray-700">
                  {{ meeting.title }}    
                </inertia-link>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
  components: {
    AppLayout,
  },

  created() {
    console.log("The component is mounted");
    console.log(this.meetings);
  },

  props: {
    meetings: Array,
  },
};
</script>
