<template>
    <div :id="id" class="vue-emitting-analog-clock" :class="shape" :style="{width: size + 'px', height: size + 'px'}">
  </div>
  </template>
  
  
  <script>
  import createAnalogClock from 'emitting-analog-clock';
  
  const optionKeys = {
    size: {
      type: Number,
      default: 200,
    },
    color: String,
    backgroundColor: String,
    backgroundImage: String,
    visibleSecondHand: {
      type: Boolean,
      default: true
    },
    shadowing: {
      type: Boolean,
      default: true
    },
    showDigital: {
      type: Boolean,
      default: false
    },
    smooth: {
      type: Boolean,
      default: false
    },
    date: Object,
    dateFunc: Function,
    nextFunc: Function
  };
  
  const props = Object.assign({
    shape: {
        default: 'circle'
    },
    id: {
      default: 'clock'
    }
  }, optionKeys);
  
  export default {
    name: 'Clock',
    props: props,
    data() {
      return {
      };
    },
    mounted () {
      var option = {
        id: this.id
      };
      for (var key in optionKeys) {
        if(this[key] !== undefined){
          option[key] = this[key];
        }
      }
      createAnalogClock(option);
    }
  }
  </script>
  
  <style>
  .vue-emitting-analog-clock {
    left: 0;
    right: 0;
    margin: auto;
  }
  
  .vue-emitting-analog-clock div {
    box-shadow: 0 5px 14px black;
  }
  .vue-emitting-analog-clock.square div{
    border-radius: 5px;
    overflow: hidden;
  }
  
  .vue-emitting-analog-clock.circle div {
    border-radius: 50%;
    overflow: hidden;
  }
  </style>