<template>
  <PageContent activeItem1="" :role="role">
    <div class="wrapper">
      <div class="content-header">
        <div style="margin: auto; width: 50%; margin-top: 10%;">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Mettre à jour l'image de profil</h3>
            </div>
            <form @submit.prevent="updateProfileImage" class="form-container">
              <div v-if="loading" class="spinner-wrapper">
                <LoadingSpinner3 />
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="image">Image de profil :</label>
                  <input type="file" id="image" @change="handleFileChange" class="form-control" accept="image/*" required />
                </div>
                <div style="display: flex; justify-content: center; align-items: center; width:100%;height: 100%;">
  <p v-if="errorMessage" style="color: red; text-align: center; margin: 0; padding: 10px;" class="alert shadow-sm">{{ errorMessage }}</p>
</div>
              </div>
              <div class="card-footer" style="display: flex; flex-direction: column; align-items: center;">

                <button type="submit" class="btn btn-primary">Mettre à jour l'image</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </PageContent>
</template>

<script>
import axios from 'axios';
import PageContent from '../layout/PageContent.vue';
import LoadingSpinner3 from '../LoadingSpinner3.vue'; // Importer votre composant spinner

export default {
  name: 'UpdateProfileImage',
  components: { PageContent, LoadingSpinner3 },
  props: {
    role: String,
  },
  data() {
    return {
      image: null,
      loading: false, // Suivre l'état de chargement
      errorMessage: '' // État du message d'erreur
    };
  },
  methods: {
    handleFileChange(event) {
      this.image = event.target.files[0];
    },
    updateProfileImage() {
      if (!this.image) {
        this.errorMessage = 'Veuillez sélectionner une image.';
        return;
      }
  
      this.loading = true; // Afficher le spinner
      this.errorMessage = ''; // Effacer le message d'erreur précédent
  
      const formData = new FormData();
      formData.append('image', this.image);
  
      axios.post(`/user/${this.$route.params.id}/update-profile-image`, formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
        .then(response => {
          alert('L\'image de profil a été mise à jour avec succès!');
          localStorage.setItem('profileImage', response.data.profile_image);          
          this.$router.push('/profile');
        })
        .catch(error => {
          if (error.response && error.response.status === 422) {
            this.errorMessage = Object.values(error.response.data.errors).flat().join(', ');
          } else {
            this.errorMessage = 'Erreur lors de la mise à jour de l\'image de profil.';
          }
        })
        .finally(() => {
          this.loading = false; // Cacher le spinner
        });
    },
  },
};
</script>

<style scoped>
.form-container {
  position: relative; /* Pour positionner le spinner absolument dans le formulaire */
}

.spinner-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8); /* Optionnel : pour donner une superposition de fond */
  z-index: 1000; /* Assurez-vous qu'il apparaisse au-dessus des autres contenus */
}
</style>
