<script setup lang="ts">
import { ProfileData, SocialLinks } from "@/types/types";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { router } from '@inertiajs/vue3';
import { Head } from "@inertiajs/inertia-vue3";

const navConfig = {
    brandName: {
        first: "BIZ",
        second: "CHECK",
    },
    buttonText: "Get Started",
    loginRoute: "login",
    submissionRoute: "submissions",
    evaluationRoute: "evaluations",
    profileRoute: "profile",
};

const form = ref({
  name: "",
  lastName: "",
  email: "",
  phone: "",
});

const formError = ref('');

const saveChanges = () => {
  // Reset previous error
  formError.value = '';

  // Validate form fields
  const isFormValid = 
    form.value.name.trim() !== '' && 
    form.value.lastName.trim() !== '' && 
    form.value.email.trim() !== '' && 
    form.value.phone.trim() !== '';

  // If form is not valid, show error
  if (!isFormValid) {
    formError.value = 'Please fill out all fields';
    return;
  }

  console.log('Saving changes...', form.value);

  router.post("/profile/update", form.value, {
    onSuccess: () => {
      console.log('Profile update successful');
      router.visit('/update-verification');
    },
    onError: (errors: any) => {
      console.error('Profile update error:', errors);
      formError.value = errors.message || 'An error occurred while updating profile';
    }
  });
};

const changeImage = () => {
  const input = document.createElement('input');
  input.type = 'file';
  input.accept = 'image/*'; 
  input.onchange = (event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        const img = document.querySelector('.w-24.h-24 img') as HTMLImageElement;
        img.src = e.target?.result as string;
      };
      reader.readAsDataURL(file);
    }
  };
  input.click();
};
</script>

<template>
    <Head title="Edit Profile" />
    <AuthenticatedLayout>
      <main class="flex flex-1 gap-5 mx-auto container py-5 justify-center font-montserrat">
      <div id="edit-profile" class="w-[700px] h-[720px] flex flex-col gap-3 bg-secondary px-6 py-5 rounded-lg mx-auto">
    <!-- Title Section -->
    <div class="text-center">
      <h1 class="text-primary-yellow font-bold text-2xl flex items-center justify-center">
        Edit Profile
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5 ml-2 text-white"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            d="M17.414 2.586a2 2 0 010 2.828l-10 10a2 2 0 01-.878.516l-4 1a1 1 0 01-1.265-1.266l1-4a2 2 0 01.515-.878l10-10a2 2 0 012.828 0zm-2.121 2.121L4.293 15.707 3.586 17l1.293-.707L15.707 5.707 15.293 5l-.707-.707zm1.414-1.414a1 1 0 00-1.414-1.414l-.293.293 1.414 1.414.293-.293z"
          />
        </svg>
      </h1>
      <p class="text-white text-sm mt-1 mb-2">Update your personal information</p>
      <div class="border-b border-primary"></div>
    </div>

    <!-- Profile Image -->
    <div class="mt-6 flex flex-col items-center">
      <div class="flex items-center space-x-4">
          <div class="w-24 h-24 rounded-full border-2 border-primary overflow-hidden">
              <img
                  src="/path/to/default-image.jpg"
                  alt="Profile Image"
                  class="w-full h-full object-cover"
              />
          </div>
          <div class="flex flex-col">
              <span class="font-bold text-white text-lg">John Doe</span>
              <span class="text-white text-sm">john.doe@gmail.com</span>
          </div>
      </div>
      <button 
          class="mt-2 text-xs text-primary-yellow underline self-start ml-48"
          @click="changeImage"
      >
          Change Profile 
      </button>
    </div>

    <!-- Form Fields -->
    <form @submit.prevent="saveChanges" class="mt-6 w-full px-4">
      <!-- Error Message Display -->
      <div v-if="formError" class="text-red-500 text-sm mb-4 text-center">
        {{ formError }}
      </div>

      <div class="flex flex-col gap-4">
        <!-- Name Field -->
        <div>
          <label for="name" class="text-white text-sm font-bold">Name</label>
          <input
            id="name"
            type="text"
            v-model="form.name"
            class="w-full border-2 border-accent bg-transparent py-2 px-3 rounded-md text-sm text-white outline-none"
          />
        </div>

        <!-- Last Name Field -->
        <div>
          <label for="lastName" class="text-white text-sm font-bold">Last Name</label>
          <input
            id="lastName"
            type="text"
            v-model="form.lastName"
            class="w-full border-2 border-accent bg-transparent py-2 px-3 rounded-md text-sm text-white outline-none"
          />
        </div>

        <!-- Email Field -->
        <div>
          <label for="email" class="text-white text-sm font-bold">Email</label>
          <input
            id="email"
            type="email"
            v-model="form.email"
            class="w-full border-2 border-accent bg-transparent py-2 px-3 rounded-md text-sm text-white outline-none"
          />
        </div>

        <!-- Phone Number Field -->
        <div>
          <label for="phone" class="text-white text-sm font-bold">Phone Number</label>
          <input
            id="phone"
            type="text"
            v-model="form.phone"
            class="w-full border-2 border-accent bg-transparent py-2 px-3 rounded-md text-sm text-white outline-none"
          />
        </div>
      </div>

      <!-- Save Button -->
      <div class="text-center mt-4">
        <button
          type="submit"

          class="mt-6 w-half bg-primary text-secondary font-bold py-2 px-4 rounded-md hover:bg-opacity-90 transition-all"
        >
          Save Changes
        </button>
      </div>
    </form>
  </div>
</main>
</AuthenticatedLayout>
</template>
