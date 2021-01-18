<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Meeting</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div
            class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2"
          >
            <div class="p-6">
              <!-- icon -->
              <div class="flex items-center">
                <svg
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  class="w-8 h-8 text-gray-400"
                >
                  <path
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                  ></path>
                </svg>
                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                  <p>{{ meeting.title }}</p>
                </div>
              </div>

              <div class="ml-12">
                <div class="mt-2 text-sm text-gray-500">
                  {{ meeting.description }}
                </div>

                <div class="mt-2 text-sm text-gray-500">
                  {{ meeting.location }}
                </div>

                <div class="mt-2 text-xs text-gray-500">
                  {{ "Start: " + meeting.start.substring(0, 10) }} -
                  {{ "End: " + meeting.end.substring(0, 10) }}
                </div>

                <!-- Show meeting rsvp -->
                <div v-if="registrations[0] != undefined" class="mt-12">
                  <p class="text-lg text-gray-600">RSVPs For This Meeting</p>
                  <div class="flex-column mt-2 text-sm text-gray-500">
                    <div
                      class="mt-2"
                      v-for="(registration, index) in registrations"
                      :key="registration.id"
                    >
                      <div v-if="registration.show_public">
                        <p class="text-gray-800">
                          {{ index + 1 }}. {{ registration.name }}
                        </p>
                        <p v-if="registration.show_public">
                          Agenda: {{ registration.agenda_items }}
                        </p>
                        <p>RSVP: {{ registration.rsvp }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="p-16">
            <registration-form
              :meeting="meeting"
              @register="register"
              :registrations="registrations"
              @checkEmailExistsForRegistration="registrationExists"
              :successMessage="successMessage"
            />
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/LayoutWithoutAuth";
import RegistrationForm from "./Form";
import FormContainer from "./FormContainer";

export default {
  components: {
    AppLayout,
    RegistrationForm,
    FormContainer,
  },

  data() {
    return {
      form: {
        name: "",
        email: "",
        rsvp: "yes",
        agenda: "",
        show: true,
        meeting_id: this.meeting.id,
        errors: {
          name: "",
          email: "",
          emailExists: "",
          agenda: "",
          show: "",
        },
      },
      successMessage: false
    };
  },

  props: {
    meeting: Array | Object,
    registrations: Array | Object,
  },

  mounted() {
    console.log("you are mounted in Show");
  },

  methods: {
    register(form) {
      this.form = form;
      console.log(this.form);

      axios
        .post(route("meetings.register"), {
          name: this.form.name,
          email: this.form.email,
          rsvp: this.form.rsvp,
          agenda: this.form.agenda,
          show: this.form.show,
          meeting_id: this.meeting.id,
        })
        .then((res) => {
          this.registrations.push(res.data.registration);
          this.successMessage = res.data.success;
        })
        .catch((error) => {
          console.log(error.response.data.errors);
        });
    },

    registrationExists() {
      let emailExists = false;

      console.log("you are in registrationExists in Show");
      if (this.registrations[0] != undefined) {
        this.registrations.map((reg) => {
          if (reg.email === this.form.email) {
            emailExists = true;
          }
        });
      }

      return emailExists;
    },
  },
};
</script>
