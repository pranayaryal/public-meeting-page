<template>
  <jet-form-section @submitted="register">
    <template #title> RSVP Information </template>

    <template #description> Enter your name, email, rsvp and agenda </template>

    <template #form>
      <!-- Name -->
      <div class="col-span-6 sm:col-span-4">
        <p class="text-sm" v-if="successMessage">Congrats, form was submitted</p>
        <jet-label for="name" value="Name" class="mt-2" />
        <!-- <jet-input id="name"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.name"
                  autocomplete="name"
                   /> -->
        <input
          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          @change="form.errors.name = ''"
          type="text"
          v-model="form.name"
          autocomplete="name"
        />
        <jet-input-error :message="form.errors.name" class="mt-2" />
      </div>

      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="email" value="Email" />
        <input
          class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          @change="form.errors.email = ''"
          type="text"
          v-model="form.email"
          autocomplete="email"
        />
        <jet-input-error :message="form.errors.email" class="mt-2" />
        <jet-input-error :message="form.errors.emailExists" class="mt-2" />
      </div>

      <!-- RSVP -->
      <div class="col-span-6 sm:col-span-4">
        <jet-label value="RSVP" />
        <div class="flex justify-between mt-1">
          <div>
            <jet-label for="rsvp" value="Yes" />
            <input id="yes" value="yes" type="radio" v-model="form.rsvp" />
          </div>
          <div>
            <jet-label for="rsvp" value="No" />
            <input id="no" value="no" type="radio" v-model="form.rsvp" />
          </div>
          <div>
            <jet-label for="rsvp" value="Maybe" />
            <input id="maybe" value="maybe" type="radio" v-model="form.rsvp" />
          </div>
          <jet-input-error :message="form.errors.rsvp" class="mt-2" />
        </div>

        <!-- Agenda Items -->
        <div class="col-span-6 sm:col-span-4 mt-4">
          <jet-label for="items" value="Agenda Items" />
          <textarea
            id="agenda"
            name="agenda"
            class="border-gray-300 mt-1 block w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            v-model="form.agenda"
            @change="form.errors.agenda = ''"
          />
          <jet-input-error :message="form.errors.agenda" class="mt-2" />
        </div>

        <!-- Show Agenda -->
        <div class="col-span-6 sm:col-span-4 mt-6">
          <input
            id="show"
            type="checkbox"
            class="mt-1 block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            v-model="form.show"
          />
          <span class="mt-2 text-sm text-gray-700 font-medium">{{
            form.show
              ? "Show Agenda On Public Page"
              : "Dont Show Agenda On Public Page"
          }}</span>
          <jet-input-error :message="form.errors.show" class="mt-2" />
        </div>
      </div>
    </template>

    <template #actions>
      <jet-action-message :on="form.recentlySuccessful" class="mr-3">
        Saved.
      </jet-action-message>

      <jet-button
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
      </jet-button>
    </template>
  </jet-form-section>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetDropDown from "@/Jetstream/Dropdown";

export default {
  components: {
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
  },

  props: {
    meeting: Array | Object,
    registrations: Array | Object,
    successMessage: Boolean
  },

  mounted() {
    console.log("mouned in Form");
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
    };
  },

  methods: {
    register() {
      if (this.validate()) {
        this.$emit("register", this.form);
      }
    },

    validate() {
      console.log("you are in validate");
      this.checkIfEmailAssociatedWithMeeting();
      this.form.errors.emailExists = this.checkIfEmailAssociatedWithMeeting()
        ? "That email already exists for this meeting"
        : "";
      this.form.errors.email = this.validateEmail()
        ? ""
        : "Email is incorrect. Please check your email";
      this.form.errors.agenda =
        this.form.agenda === "" ? "Agenda is required" : "";
      this.form.errors.name = this.form.name === "" ? "Name is required" : "";

      return (
        this.form.errors.email === "" &&
        this.form.errors.name == "" &&
        this.form.errors.agenda == "" &&
        this.validateEmail() &&
        !this.checkIfEmailAssociatedWithMeeting()
      );
    },

    checkIfEmailAssociatedWithMeeting() {
      let emailExists = false;

      console.log(this.registrations);

      this.registrations.map((reg) => {
        if (reg.email === this.form.email) {
          emailExists = true;
        }
      });

      return emailExists;
    },

    validateEmail() {
      const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(this.form.email).toLowerCase());
    },

    resetForm() {
      this.form.email = "";
      this.form.name = "";
      this.form.rsvp = "";
      this.form.agenda = "";
    },
  },
};
</script>
