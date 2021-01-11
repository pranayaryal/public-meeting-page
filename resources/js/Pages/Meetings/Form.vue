<template>
    <jet-form-section @submitted="register">
        <template #title>
            RSVP Information
        </template>

        <template #description>
          Enter your name, email and agenda
        </template>

        <template #form>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
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
            </div>

            <!-- Agenda Items -->
            <div class="col-span-6 sm:col-span-4 mt-4">
              <jet-label for="items" value="Agenda Items" />
              <textarea id="items" name="items" 
               class="border-gray-300 mt-1 block w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
               v-model="form.items" />

            </div>

            <!-- Show Agenda -->
            <div class="col-span-6 sm:col-span-4 mt-6">
              <input id="show" type="checkbox" 
                class="mt-1 block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                v-model="form.show" />
              <span class="mt-2 text-sm text-gray-700 font-medium">{{ form.show ? 'Show Agenda On Public Page' : 'Dont Show Agenda On Public Page' }}</span>

            </div>

            </div>

        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

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


        data() {
            return {
                form: this.$inertia.form({
                    name: "",
                    email: "",
                    rsvp: "",
                    items: "",
                    show: false 
                },
                {
                  bag: "postMeetingForm",
                  resetOnSuccess: false,
                }
                )

            };
        },

        methods: {

            register(){
              this.form
              .post(route("register"), {
                preserveScroll: true,
              })
              .then((res) => {
                this.form.name = "";
                this.form.email = "";
                this.form.rsvp = "";
                this.form.items = "";
                this.form.show = false;
                console.log(res.data);
              });
              
            }
        },
    }
</script>
