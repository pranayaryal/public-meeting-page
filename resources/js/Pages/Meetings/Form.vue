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
              <jet-input-error :message="form.errors.rsvp" class="mt-2" />
            </div>

            <!-- Agenda Items -->
            <div class="col-span-6 sm:col-span-4 mt-4">
              <jet-label for="items" value="Agenda Items" />
              <textarea id="agenda" name="agenda" 
               class="border-gray-300 mt-1 block w-full focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
               v-model="form.agenda" />
              <jet-input-error :message="form.errors.agenda" class="mt-2" />

            </div>

            <!-- Show Agenda -->
            <div class="col-span-6 sm:col-span-4 mt-6">
              <input id="show" type="checkbox" 
                class="mt-1 block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                v-model="form.show" />
              <span class="mt-2 text-sm text-gray-700 font-medium">{{ form.show ? 'Show Agenda On Public Page' : 'Dont Show Agenda On Public Page' }}</span>
              <jet-input-error :message="form.errors.show" class="mt-2" />

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
    import JetDropDown from '@/Jetstream/Dropdown'

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
          registrations: Array | Object
        },

        created(){
        },
        

        data() {
            return {
                form: {
                    name: "",
                    email: "",
                    rsvp: "",
                    agenda: "",
                    show: false,
                    meeting_id: this.meeting.id,
                    errors: {
                      name: "",
                      email: "",
                      rsvp: "",
                      agenda: "",
                      show: ''
                    }
                }

            };
        },

        methods: {

            register(){
              axios.post(route("meetings.register"), {
                name: this.form.name,
                email: this.form.email,
                rsvp: this.form.rsvp,
                agenda: this.form.agenda,
                show: this.form.show,
                meeting_id: this.meeting.id
              }).then(() => {
                console.log('success');
                this.form.reset();
                
              }).catch(error => {
                this.form.errors.email = error.response.data.errors.email[0];
                this.form.errors.name = error.response.data.errors.name[0];
                this.form.errors.rsvp = error.response.data.errors.rsvp[0];
                this.form.errors.agenda = error.response.data.errors.agenda[0];
                this.form.errors.show = error.response.data.errors.show[0];
                
              })
              
            }

        },
    }
</script>
