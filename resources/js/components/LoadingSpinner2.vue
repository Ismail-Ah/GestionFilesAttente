<template>
<div class="spinner-wrapper">
      <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
      </div>
    </div></template>

<script>
export default {
  name: 'LoadingSpinner2'
};
</script>

<style scoped>
.spinner-wrapper {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;

}



.spinner {
  position: absolute;
  
  width: 3.75rem;
  height: 1.25rem;
  margin: -0.625rem 0 0 -1.875rem; /* width and height divided by two */
  text-align: center;
  margin-top: 50px;
}

.spinner > div {
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #000;
  -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
  animation: sk-bouncedelay 1.4s infinite ease-in-out both;
}

.spinner .bounce1 {
  -webkit-animation-delay: -0.32s;
  animation-delay: -0.32s;
}

.spinner .bounce2 {
  -webkit-animation-delay: -0.16s;
  animation-delay: -0.16s;
}

@-webkit-keyframes sk-bouncedelay {
  0%, 80%, 100% { -webkit-transform: scale(0); }
  40% { -webkit-transform: scale(1.0); }
}

@keyframes sk-bouncedelay {
  0%, 80%, 100% { 
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    transform: scale(0);
  } 40% { 
    -webkit-transform: scale(1.0);
    -ms-transform: scale(1.0);
    transform: scale(1.0);
  }
}
</style>
